<?php

namespace App\Contracts;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface
{
    public function getAll(?array $relations = null):Collection;
    public function getOne(?array $condition = []): ?Book;
    public function delete(array $condition): bool;
    public function create(array $data): Book;
    public function update(array $condition, array $newDetails): bool;
    public function search(string $searchData): Collection;
}
