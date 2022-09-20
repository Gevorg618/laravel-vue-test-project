<?php
namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * @param array|null $condition
     * @return User|null
     */
    public function getOne(?array $condition = []): ?User
    {
        return User::where($condition)->first();
    }

    /**
     * @param $condition
     * @return bool
     */
    public function delete($condition): bool
    {
        return User::where($condition)->delete();
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * @param array $condition
     * @param array $newDetails
     * @return bool
     */
    public function update(array $condition, array $newDetails): bool
    {
        return User::where($condition)->update($newDetails);
    }
}
