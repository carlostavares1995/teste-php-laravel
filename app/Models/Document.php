<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'contents',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
