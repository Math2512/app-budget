<?php

namespace App\Http\Services;

use App\Models\Period;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{

    /**
     * create
     *
     * @param  mixed $contact
     * @param  mixed $request
     * @return Period
     */
    public function createOrUpdate(Category $category, Period $period, $name, $spending, $objective, $color) :Category
    {
        $category->period_id = $period->id;
        $category->name = $name;
        $category->spending = $spending;
        $category->objective = $objective;
        $category->color = $color;

        $category->save();

        return $category;
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
