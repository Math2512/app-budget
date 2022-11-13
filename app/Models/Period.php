<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'started_date',
        'ended_date'
    ];

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * category
     *
     * @return HasMany
     */
    public function categories() :HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function previsionnel()
    {
        $sum = Category::where('period_id', $this->id)->sum('spending');

        return $this->budget - $sum;
    }

    public function objective()
    {
        $sum = [];
        foreach($this->categories as $category)
        {
            if(!is_null($category->objective))
                $sum[] = $category->objective;
            else
                $sum[] = $category->spending;
        }

        return array_sum($sum);
    }

    public function real()
    {

        foreach($this->categories as $category)
        {
            if(!is_null($category->real))
                $sum[] = $category->real;
            else
                $sum[] = 0;
        }

        return $this->budget - array_sum($sum);
    }


}
