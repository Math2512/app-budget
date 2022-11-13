<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryService;
use Carbon\Carbon;
use App\Models\Period;
use Illuminate\Http\Request;
use App\Http\Services\PeriodService;
use App\Models\Category;
use App\Models\Debit;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    private $periodService;
    private $categoryService;

    public function __construct(PeriodService $periodService, CategoryService $categoryService)
    {
        $this->periodService = $periodService;
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lastDayofMonth = Carbon::parse(Carbon::now())->endOfMonth()->toDateString();
        $firstDayofMonth = Carbon::parse(Carbon::now())->firstOfMonth()->toDateString();

        $period = Period::whereBetween('started_at', [$firstDayofMonth, $lastDayofMonth])->where('user_id', Auth::id())->first();
        $debits = Debit::whereIn('category_id', $period->categories->pluck('id'))->get();

        return view("budget.index", ['period' => $period, 'debits' => $debits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("budget.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'budget' => 'required|integer',
            'started_at' => 'required|date',
            'ended_at' => 'required|date',
        ],
        [
            'started_at.date' => 'Le champ Date de départ n\'est pas valide',
            'started_at.required' => 'Le champ Date de départ est obligatoire.',
            'ended_at.date' => 'Le champ Date de fin n\'est pas valide',
            'ended_at.required' => 'Le champ Date de fin est obligatoire.'
        ]);

        $start = Carbon::parse($request['started_at'])->format('Y-m-d');
        $end = Carbon::parse($request['ended_at'])->format('Y-m-d');
        $period = $this->periodService->createOrUpdate(new Period(), $start, $end, $request->budget);

        foreach($request->name as $index => $name) {
            $this->categoryService
            ->createOrUpdate(new Category(), $period, $name, $request->spending[$index], $request->objective[$index], $request->color[$index]);
        }

        $lastDayofMonth = Carbon::parse(Carbon::now())->endOfMonth()->toDateString();
        $firstDayofMonth = Carbon::parse(Carbon::now())->firstOfMonth()->toDateString();
        $period = Period::whereBetween('started_at', [$firstDayofMonth, $lastDayofMonth])->where('user_id', Auth::id())->first();

        return view("budget.index", ['period' => $period])->with('message', 'Votre période a été créé');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $period = Period::find($id);
        return view("budget.edit", ['period' => $period]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $start = Carbon::parse($request['started_at'])->format('Y-m-d');
        $end = Carbon::parse($request['ended_at'])->format('Y-m-d');

        $period = Period::find($id);
        $this->periodService->createOrUpdate($period, $start, $end, $request->budget);

        foreach($request->existing_name as $index => $name) {
            $category = Category::find($index);
            $this->categoryService
            ->createOrUpdate($category, $period, $name, $request->existing_spending[$index], $request->existing_objective[$index], $request->existing_color[$index]);
        }


        foreach($request->name as $index => $name) {
            $this->categoryService
            ->createOrUpdate(new Category(), $period, $name, $request->spending[$index], $request->objective[$index], $request->color[$index]);
        }

        $lastDayofMonth = Carbon::parse(Carbon::now())->endOfMonth()->toDateString();
        $firstDayofMonth = Carbon::parse(Carbon::now())->firstOfMonth()->toDateString();
        $period = Period::whereBetween('started_at', [$firstDayofMonth, $lastDayofMonth])->where('user_id', Auth::id())->first();

        return redirect()->route("budget.index", ['period' => $period]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
