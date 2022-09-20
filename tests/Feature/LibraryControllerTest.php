<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Library;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class LibraryControllerTest extends TestCase
{
    use DatabaseTransactions, UserHelper;

    /**
     *
     * @return void
     */
    public function test_get_only_libraries_success()
    {
        $auth = $this->createUserAndAuthenticate();
        $library = Library::factory(1)->create()[0];
        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $auth['token']
        ])->get('/api/libraries');

        $response->assertOk();
        $response->assertJsonFragment(['id' => $library->id]);
        $response->assertJsonFragment(['name' => $library->name]);
    }

    /**
     * @return void
     */
    public function test_get_libraries_with_books()
    {
        $auth = $this->createUserAndAuthenticate();
        $library = Library::factory(1)->create()[0];
        $book = $auth['user']->books()->create([
            'title'       => fake()->title(),
            'description' => fake()->text(),
            'author'      => fake()->name()
        ]);
        $library->books()->attach([[
            'book_id'        => $book->id,
            'existing_count' => 15
        ]]);

        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $auth['token']
        ])->get('/api/libraries/books');

        $response->assertOk();
        $response->assertJsonFragment(['id' => $library->id]);
        $response->assertJsonFragment(['id' => $book->id]);
        $response->assertJsonFragment(['name' => $library->name]);
        $response->assertJsonFragment(['existing_count' => 16]);
    }

}
