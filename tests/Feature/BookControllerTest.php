<?php

namespace Tests\Feature;

use App\Models\Library;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use DatabaseTransactions, UserHelper;

    /**
     * @return void
     * @throws Exception
     */
    public function test_create_book_success()
    {
        $auth = $this->createUserAndAuthenticate();
        $libraries = Library::factory(3)->create();
        foreach ($libraries as $library) {
            $libraryData[] = [
                "library" => $library,
                "count"   => random_int(10, 25)
            ];
        }
        $data = [
            'title'       => fake()->title(),
            'description' => fake()->text(),
            'author'      => fake()->name(),
            'libraries'   => $libraryData
        ];
        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $auth['token']
        ])->post('/api/books', $data);

        $response->assertCreated();
        $response->assertJsonFragment(['title' => $data['title']]);
        $response->assertJsonFragment(['description' => $data['description']]);
        $response->assertJsonFragment(['user_id' => $auth['user']->id]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_delete_book_success()
    {
        $auth = $this->createUserAndAuthenticate();
        $libraries = Library::factory(3)->create();
        $libraries = $libraries->map->only('id');
        $book = $auth['user']->books()->create([
            'title'       => fake()->title(),
            'description' => fake()->text(),
            'author'      => fake()->name(),
        ]);

        foreach ($libraries as $library) {
            $pivotData[] = [
                "library_id"     => $library['id'],
                "existing_count" => random_int(12, 35)
            ];
        }

        $book->libraries()->attach($pivotData);

        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $auth['token']
        ])->delete("/api/books/{$book->id}");

        $response->assertOk();
        $response->assertJsonFragment(['message' => "Book Deleted successfully."]);
        $response->assertJsonFragment(['type' => "success"]);
        $response->assertJsonFragment(['success' => 1]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_get_books_with_libraries_success()
    {
        $auth = $this->createUserAndAuthenticate();
        $libraries = Library::factory(3)->create();
        $libraries = $libraries->map->only('id');
        $book = $auth['user']->books()->create([
            'title'       => fake()->title(),
            'description' => fake()->text(),
            'author'      => fake()->name(),
        ]);

        foreach ($libraries as $library) {
            $pivotData[] = [
                "library_id"     => $library['id'],
                "existing_count" => random_int(12, 35)
            ];
        }

        $book->libraries()->attach($pivotData);

        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $auth['token']
        ])->get("/api/books");

        $response->assertOk();
        $response->assertJsonFragment(['id' => $book->id]);
        $response->assertJsonFragment(['title' => $book->title]);
        $response->assertJsonFragment(['existing_count' => $pivotData[0]["existing_count"]]);
        $response->assertJsonFragment(['id' => $pivotData[0]["library_id"]]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_like_book_success()
    {
        $auth = $this->createUserAndAuthenticate();
        $book = $auth['user']->books()->create([
            'title'       => fake()->title(),
            'description' => fake()->text(),
            'author'      => fake()->name(),
        ]);

        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $auth['token']
        ])->get("/api/books/{$book->id}/like");

        $response->assertOk();
        $response->assertJsonFragment(['message' => "Added like for book successfully."]);
        $response->assertJsonFragment(['type' => "success"]);
        $response->assertJsonFragment(['success' => 1]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_delete_like_for_book_success()
    {
        $auth = $this->createUserAndAuthenticate();
        $book = $auth['user']->books()->create([
            'title'       => fake()->title(),
            'description' => fake()->text(),
            'author'      => fake()->name(),
        ]);
        $book->likes()->create([
             "user_id" => $auth['user']->id,
        ]);

        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $auth['token']
        ])->get("/api/books/{$book->id}/like");

        $response->assertOk();
        $response->assertJsonFragment(['message' => "Deleted like for book successfully."]);
        $response->assertJsonFragment(['type' => "success"]);
        $response->assertJsonFragment(['success' => 1]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_search_books_success()
    {
        $auth = $this->createUserAndAuthenticate();
        $libraries = Library::factory(3)->create();
        $libraries = $libraries->map->only('id');
        $book = $auth['user']->books()->create([
            'title'       => fake()->title(),
            'description' => Str::random(150),
            'author'      => fake()->name(),
        ]);

        foreach ($libraries as $library) {
            $pivotData[] = [
                "library_id"     => $library['id'],
                "existing_count" => random_int(12, 35)
            ];
        }

        $book->libraries()->attach($pivotData);

        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $auth['token']
        ])->post("/api/books/search", ["searchData" => $book->description]);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', 1)
                ->has('data.0', fn ($json) =>
                $json->where('id', $book->id)
                    ->where('description', $book->description)
                    ->etc()
                )
            );
    }
}
