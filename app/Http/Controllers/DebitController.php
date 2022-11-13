<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Debit;
use App\Models\Period;
use Illuminate\Http\Request;
use App\Http\Services\DebitService;

class DebitController extends Controller
{
    private $debitService;

    public function __construct(DebitService $debitService)
    {
        $this->debitService = $debitService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'amount' => 'required|integer',
            'category_id' => 'required',
        ],
        [
            'amount.required' => 'Le champ Prix est obligatoire.',
            'amount.integer' => 'Le champ Prix n\'est pas valide',
            'category_id.required' => 'Merci de séléctionner une catégorie',
        ]);

        $debit = $this->debitService->create(new Debit(), $request);

        $lastDayofMonth = Carbon::parse(Carbon::now())->endOfMonth()->toDateString();
        $firstDayofMonth = Carbon::parse(Carbon::now())->firstOfMonth()->toDateString();
        $period = Period::whereBetween('started_at', [$firstDayofMonth, $lastDayofMonth])->first();

        return redirect()->route("budget.index", ['period' => $period])->with('message', 'Votre dépense a été ajoutée');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
