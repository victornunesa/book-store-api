<?php

namespace App\Domain\Book\Repositories;

use App\Domain\Book\Models\Book;

class BookRepository implements BookRepositoryInterface
{
    public function all()
    {
        return Book::with('stores')->get();
    }

    public function create(array $data)
    {
        return Book::create($data);
    }

    public function update(array $data, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($data);
        return $book;
    }

    public function delete($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }

    public function find($id)
    {
        return Book::with('stores')->findOrFail($id);
    }
}
