<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'content',
        'rating',
        'is_visible',
        'avatar',
        'service_name',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'reviewed_at' => 'date',
        ];
    }
}
