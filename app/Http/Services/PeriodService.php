<?php

namespace App\Http\Services;

use App\Models\Period;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class PeriodService
{
    /**
     * create
     *
     * @param  mixed $contact
     * @param  mixed $request
     * @return Period
     */
    public function createOrUpdate(Period $period, $start_period, $end_period, $budget) :Period
    {
        if(!isset($period->id))
            $period->user_id = Auth::id();
        $period->started_at = $start_period;
        $period->ended_at = $end_period;
        $period->ended_at = $end_period;
        $period->budget = $budget;

        $period->save();

        return $period;
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
