<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    const MAX_CONTENT_LENGTH = 5000;
    const SEMESTER = 'semestre';

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
