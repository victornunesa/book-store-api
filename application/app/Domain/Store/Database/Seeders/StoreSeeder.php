<?php

namespace App\Domain\Store\Database\Seeders;

use App\Domain\Book\Models\Book;
use App\Domain\Store\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::factory()
                ->has(Book::factory()->count(10))
                ->count(5)
                ->create();
    }
}
