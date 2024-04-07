<?php

namespace App\Domain\Store\Repositories;

use App\Domain\Store\Models\Store;

class StoreRepository implements StoreRepositoryInterface
{
    public function all()
    {
        return Store::all();
    }

    public function create(array $data)
    {
        $store = Store::create($data);

        if(!empty($data['books_id'])) {
            $store->books()->sync($data['books_id']);
        }

        return $store;
    }

    public function update(array $data, $id)
    {
        $store = Store::findOrFail($id);
        $store->update($data);

        if(!empty($data['books_id'])) {
            $store->books()->sync($data['books_id']);
        }

        
        return $store;
    }

    public function delete($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
    }

    public function find($id)
    {
        return Store::findOrFail($id);
    }
}
