<?php

namespace App\Observers;

use App\Models\Debit;

class DebitObserver
{
    /**
     * Handle the Debit "created" event.
     *
     * @param  \App\Models\Debit  $debit
     * @return void
     */
    public function created(Debit $debit)
    {

        if(is_null($debit->category->real))
            $debit->category->real = $debit->amount;
        else
            $debit->category->real = $debit->category->real + $debit->amount;

        $debit->category->save();
    }

    /**
     * Handle the Debit "updated" event.
     *
     * @param  \App\Models\Debit  $debit
     * @return void
     */
    public function updated(Debit $debit)
    {
        //
    }

    /**
     * Handle the Debit "deleted" event.
     *
     * @param  \App\Models\Debit  $debit
     * @return void
     */
    public function deleted(Debit $debit)
    {
        //
    }

    /**
     * Handle the Debit "restored" event.
     *
     * @param  \App\Models\Debit  $debit
     * @return void
     */
    public function restored(Debit $debit)
    {
        //
    }

    /**
     * Handle the Debit "force deleted" event.
     *
     * @param  \App\Models\Debit  $debit
     * @return void
     */
    public function forceDeleted(Debit $debit)
    {
        //
    }
}
