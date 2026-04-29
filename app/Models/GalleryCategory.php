<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_visible',
        'sort_order',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class, 'category_id');
    }
}
