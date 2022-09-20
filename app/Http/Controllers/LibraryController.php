<?php

namespace App\Http\Controllers;

use App\Contracts\LibraryRepositoryInterface;
use App\Http\Resources\LibraryResponseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class LibraryController extends Controller
{
    /**
     * @param LibraryRepositoryInterface $libraryRepository
     * @return AnonymousResourceCollection
     */
    public function index(LibraryRepositoryInterface $libraryRepository): AnonymousResourceCollection
    {
        $libraries = $libraryRepository->getAll(['books.likes']);

        foreach ($libraries as $library) {
            foreach ($library->books as $book) {
                $book->liked = false;
                foreach ($book->likes as $like) {
                    if ($like->user_id === auth()->id()) {
                        $book->liked = true;
                    }
                }
            }
        }
        return LibraryResponseResource::collection($libraries);
    }

    /**
     * @param LibraryRepositoryInterface $libraryRepository
     * @return AnonymousResourceCollection
     */
    public function getOnlyLibraries(LibraryRepositoryInterface $libraryRepository): AnonymousResourceCollection
    {
        return LibraryResponseResource::collection($libraryRepository->getAll());
    }
}
