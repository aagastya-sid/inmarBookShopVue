<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'price',
    ];

    public function getImageAttribute()
    {
        return 'https://placehold.co/400x400?text=' . Str::limit($this->title, 10, '...');
    }
}
