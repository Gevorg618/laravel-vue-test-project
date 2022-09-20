<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions, UserHelper;

    /**
     *
     * @return void
     */
    public function test_login_user_success()
    {
        $user = $this->createUser();
        $response = $this->post('/api/login', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $response->assertOk();
        $response->assertJsonFragment(['id' => $user->id]);
    }

    /**
     *
     * @return void
     */
    public function test_login_user_fake_data_failed()
    {
        $user = $this->createUser();
        $response = $this->post('/api/login', [
            'email'    => $user->email,
            'password' => 'fakePassword'
        ]);

        $response->assertJsonFragment(['message' => "Incorrect Details.  Please try again"]);
        $response->assertJsonFragment(['type' => "error"]);
        $response->assertJsonFragment(['success' => 0]);
    }

    /**
     *
     * @return void
     */
    public function test_logout_user_success()
    {
        $auth = $this->createUserAndAuthenticate();
        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $auth['token']
        ])->get('/api/logout');

        $response->assertJsonFragment(['message' => "You are logged out successfully."]);
        $response->assertJsonFragment(['type' => "success"]);
        $response->assertJsonFragment(['success' => 1]);
    }

}
