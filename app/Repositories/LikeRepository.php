<?php

namespace App\Repositories;

use App\Contracts\LikeRepositoryInterface;
use App\Models\Like;

class LikeRepository implements LikeRepositoryInterface
{

    /**
     * @param array|null $condition
     * @return Like|null
     */
    public function getOne(?array $condition = []): ?Like
    {
        return Like::where($condition)->first();
    }

    /**
     * @param array $condition
     * @return bool
     */
    public function delete(array $condition): bool
    {
        return Like::where($condition)->delete();
    }

    /**
     * @param array $data
     * @return Like
     */
    public function create(array $data): Like
    {
        return Like::create($data);
    }
}
