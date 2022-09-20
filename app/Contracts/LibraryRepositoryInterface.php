<?php

namespace App\Contracts;

use App\Models\Library;
use Illuminate\Database\Eloquent\Collection;

interface LibraryRepositoryInterface
{
    public function getAll(array $relations = []):Collection;
    public function getOne(?array $condition = []): ?Library;
    public function delete(array $condition): bool;
    public function create(array $data): Library;
    public function update(array $condition, array $newDetails): bool;

}
