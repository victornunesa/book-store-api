<?php

namespace App\Domain\Book\Models;

use App\Domain\Book\Database\Factories\BookFactory;
use App\Domain\Store\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'isbn', 'value'];

    protected static function newFactory(): Factory
    {
        return BookFactory::new();
    }

    public function stores() : BelongsToMany
    {
        return $this->belongsToMany(Store::class);
    }
}
