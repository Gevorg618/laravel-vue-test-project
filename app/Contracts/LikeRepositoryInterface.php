<?php

namespace App\Contracts;

use App\Models\Like;

interface LikeRepositoryInterface
{
    public function getOne(?array $condition = []): ?Like;
    public function delete(array $condition): bool;
    public function create(array $data): Like;

}
