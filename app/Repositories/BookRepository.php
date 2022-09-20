<?php

namespace App\Repositories;

use App\Contracts\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{

    /**
     * @param array|null $relations
     * @return Collection
     */
    public function getAll(?array $relations = null): Collection
    {
        return Book::when($relations, function ($query) use ($relations) {
            return $query->with($relations);
        })
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * @param array|null $condition
     * @return Book|null
     */
    public function getOne(?array $condition = []): ?Book
    {
        return Book::where($condition)->first();
    }

    /**
     * @param array $condition
     * @return bool
     */
    public function delete(array $condition): bool
    {
        return Book::where($condition)->delete();
    }

    /**
     * @param array $data
     * @return Book
     */
    public function create(array $data): Book
    {
        return Book::create($data);
    }

    /**
     * @param array $condition
     * @param array $newDetails
     * @return bool
     */
    public function update(array $condition, array $newDetails):bool
    {
        return Book::where($condition)->update($newDetails);
    }

    /**
     * @param string $searchData
     * @return Collection
     */
    public function search(string $searchData): Collection
    {
        return Book::where('title', "like", "%".$searchData."%")
            ->orWhere('description', "like", "%".$searchData."%")
            ->with('libraries', 'likes')
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
