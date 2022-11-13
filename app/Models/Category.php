<?php

namespace App\Models;

use App\Models\Debit;
use App\Models\Period;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'spending',
        'objective',
        'real'
    ];

    /**
     * category
     *
     * @return BelongsTo
     */
    public function period() :BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * category
     *
     * @return HasMany
     */
    public function debits() :HasMany
    {
        return $this->hasMany(Debit::class);
    }
}
