<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    static function getByName(string $name): self
    {
        return Cache::remember('category-' . $name, 60 * 10, function () use ($name) {
            return self::where('name', $name)->firstOrFail();
        });
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
