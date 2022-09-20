<?php

namespace App\Http\Controllers;

use App\Contracts\UserRepositoryInterface;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\GlobalResponseResource;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    /**
     * @param AuthRequest $request
     * @return GlobalResponseResource
     */
    public function login(AuthRequest $request): GlobalResponseResource
    {
        if (!auth()->attempt(['email' => $request->getEmail(), 'password' => $request->getPassword()])) {
            return new GlobalResponseResource([
                'type'    => 'error',
                'success' => 0,
                'message' => 'Incorrect Details.  Please try again'
            ]);
        }

        $user = auth()->user();
        $token = $user->createToken('API Token')->accessToken;

        return new GlobalResponseResource([
            'type'    => 'success',
            'success' => 1,
            'message' => 'You are logged in successfully.',
            'user'    => $user,
            'token'   => $token
        ]);
    }

    /**
     * @param UserRepositoryInterface $userRepository
     * @return GlobalResponseResource
     */
    public function logout(UserRepositoryInterface $userRepository): GlobalResponseResource
    {
        $user = $userRepository->getOne(['id'=>auth()->id()]);
        $accessToken = auth()->user()->token();
        $token = $user->tokens->find($accessToken);
        $token->revoke();

        return new GlobalResponseResource([
            'type'    => 'success',
            'success' => 1,
            'message' => 'You are logged out successfully.',
        ]);
    }
}
