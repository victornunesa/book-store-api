<?php

namespace App\Domain\Store\Http\Controllers;

use App\Domain\Store\Http\Requests\StoreStoreRequest;
use App\Domain\Store\Http\Requests\UpdateStoreRequest;
use App\Domain\Store\Repositories\StoreRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private StoreRepositoryInterface $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = $this->storeRepository->all();

        return new ApiSuccessResponse($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoreRequest $request)
    {
        $book =  $this->storeRepository->create($request->all());

        return new ApiSuccessResponse($book, 'store created successfully', [], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = $this->storeRepository->find($id);

        return new ApiSuccessResponse($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoreRequest $request, string $id)
    {
        $book = $this->storeRepository->update($request->all(), $id);

        return new ApiSuccessResponse($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->storeRepository->delete($id);

        return new ApiSuccessResponse(null, 'successfully deleted store', [], 204);
    }
}
