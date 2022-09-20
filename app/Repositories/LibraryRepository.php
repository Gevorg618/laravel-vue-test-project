<?php

namespace App\Repositories;

use App\Contracts\LibraryRepositoryInterface;
use App\Models\Library;
use Illuminate\Database\Eloquent\Collection;

class LibraryRepository implements LibraryRepositoryInterface
{

    /**
     * @param array $relations
     * @return Collection
     */
    public function getAll(array $relations = []): Collection
    {
        return Library::with($relations)->orderBy('updated_at', 'desc')->get();
    }

    /**
     * @param array|null $condition
     * @return Library|null
     */
    public function getOne(?array $condition = []): ?Library
    {
        return Library::where($condition)->get();
    }

    /**
     * @param array $condition
     * @return bool
     */
    public function delete(array $condition): bool
    {
        return Library::where($condition)->delete();
    }

    /**
     * @param array $data
     * @return Library
     */
    public function create(array $data): Library
    {
        return Library::create($data);
    }

    /**
     * @param array $condition
     * @param array $newDetails
     * @return bool
     */
    public function update(array $condition, array $newDetails): bool
    {
        return Library::where($condition)->update($newDetails);
    }
}
