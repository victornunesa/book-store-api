<?php

namespace App\Domain\Book\Http\Controllers;

use App\Domain\Book\Http\Requests\StoreBookRequest;
use App\Domain\Book\Http\Requests\UpdateBookRequest;
use App\Domain\Book\Repositories\BookRepositoryInterface;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = $this->bookRepository->all();
        return new ApiSuccessResponse($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book =  $this->bookRepository->create($request->all());

        return new ApiSuccessResponse($book, 'book created successfully', [], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = $this->bookRepository->find($id);
        return new ApiSuccessResponse($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $book = $this->bookRepository->update($request->all(), $id);

        return new ApiSuccessResponse($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->bookRepository->delete($id);

        return new ApiSuccessResponse(null, 'successfully deleted book', [], 204);
    }
}
