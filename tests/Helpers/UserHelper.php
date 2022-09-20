<?php

namespace Tests\Helpers;

use App\Models\User;

trait UserHelper
{
    /**
     * @return User
     */
    public function createUser(): User
    {
        return User::factory()->create();
    }

    /**
     * @return array
     */
    public function createUserAndAuthenticate(): array
    {
        $user = $this->createUser();
        auth()->attempt(['email'=>$user->email, 'password'=>'password']);
        $token = $user->createToken('API Token')->accessToken;
        return ['user'=>$user, 'token'=>$token];
    }

}
