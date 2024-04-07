<?php

namespace App\Domain\Store\Models;

use App\Domain\Book\Models\Book;
use App\Domain\Store\Database\Factories\StoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'active'];

    public function books() : BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    protected static function newFactory(): Factory
    {
        return StoreFactory::new();
    }
}
