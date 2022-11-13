<?php

namespace App\Http\Services;

use App\Models\Debit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Collection;

class DebitService
{
    /**
     * create
     *
     * @param  mixed $contact
     * @param  mixed $request
     * @return Debit
     */
    public function create($debit, Request $request) :Debit
    {
        $debit->category_id = $request->category_id;
        $debit->amount = $request->amount;

        $debit->save();

        return $debit;
    }

    /**
     * update
     *
     * @param  mixed $contact
     * @param  mixed $request
     */
    public function update()
    {

    }
}
