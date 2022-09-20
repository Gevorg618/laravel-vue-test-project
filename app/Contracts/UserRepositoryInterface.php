<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getAll(): Collection;
    public function getOne(?array $condition = []): ?User;
    public function delete(array $condition): bool;
    public function create(array $data): User;
    public function update(array $condition, array $newDetails): bool;
}
