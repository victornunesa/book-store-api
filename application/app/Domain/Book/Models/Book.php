<?php

namespace App\Domain\Book\Models;

use App\Domain\Book\Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'isbn', 'value'];

    protected static function newFactory(): Factory
    {
        return BookFactory::new();
    }
}
