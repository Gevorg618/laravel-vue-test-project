<?php

namespace App\Http\Controllers;

use App\Contracts\BookRepositoryInterface;
use App\Contracts\LikeRepositoryInterface;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\SearchBookRequest;
use App\Http\Resources\BookResponseResource;
use App\Http\Resources\GlobalResponseResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class BookController extends Controller
{
    /**
     * @param BookRepositoryInterface $bookRepository
     * @return AnonymousResourceCollection
     */
    public function index(BookRepositoryInterface $bookRepository): AnonymousResourceCollection
    {
        $books = $bookRepository->getAll(['libraries', 'likes']);
        foreach ($books as $book) {
            $book->liked = false;
            foreach ($book->likes as $like) {
                if ($like->user_id === auth()->id()) {
                    $book->liked = true;
                }
            }
        }

        return BookResponseResource::collection($books);
    }

    /**
     * @param BookRepositoryInterface $bookRepository
     * @param CreateBookRequest $request
     * @return BookResponseResource
     */
    public function create(BookRepositoryInterface $bookRepository, CreateBookRequest $request): BookResponseResource
    {
        $book = $bookRepository->create([
            'user_id'     => auth()->id(),
            'title'       => $request->getTitle(),
            'description' => $request->getDescription(),
            'author'      => $request->getAuthor()
        ]);
        $libraries = [];
        foreach ($request->getLibraries() as $library) {
            $libraries[] = [
                'existing_count' => $library['count'],
                'library_id'     => $library['library']['id']
            ];
        }

        $book->libraries()->attach($libraries);

        return new BookResponseResource($book->load('libraries', 'likes'));
    }

    /**
     * @param Book $book
     * @param LikeRepositoryInterface $likeRepository
     * @return GlobalResponseResource
     */
    public function like(Book $book, LikeRepositoryInterface $likeRepository): GlobalResponseResource
    {
        $like = $likeRepository->getOne([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
        ]);

        if (!$like) {
            $likeRepository->create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
            ]);
            $response = [
                'type'    => 'success',
                'success' => 1,
                'message' => 'Added like for book successfully.',
            ];
        } else {
            $like->delete();
            $response = [
                'type'    => 'success',
                'success' => 1,
                'message' => 'Deleted like for book successfully.',
            ];
        }

        return new GlobalResponseResource($response);
    }

    /**
     * @param BookRepositoryInterface $bookRepository
     * @param SearchBookRequest $request
     * @return AnonymousResourceCollection
     */
    public function search(BookRepositoryInterface $bookRepository, SearchBookRequest $request): AnonymousResourceCollection
    {
        $books = $bookRepository->search($request->getSearchData());

        foreach ($books as $book) {
            $book->liked = false;
            foreach ($book->likes as $like) {
                if ($like->user_id === auth()->id()) {
                    $book->liked = true;
                }
            }
        }
        return BookResponseResource::collection($books);
    }

    /**
     * @param Book $book
     * @return GlobalResponseResource
     */
    public function delete(Book $book): GlobalResponseResource
    {
        $book->libraries()->detach();
        $book->delete();

        return new GlobalResponseResource([
            'type'    => 'success',
            'success' => 1,
            'message' => 'Book Deleted successfully.'
        ]);
    }
}
