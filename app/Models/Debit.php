<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Debit extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'amount'
    ];

    /**
     * category
     *
     * @return BelongsTo
     */
    public function category() :BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
