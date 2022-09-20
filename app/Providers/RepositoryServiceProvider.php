<?php

namespace App\Providers;

use App\Contracts\BookRepositoryInterface;
use App\Contracts\LibraryRepositoryInterface;
use App\Contracts\LikeRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\BookRepository;
use App\Repositories\LibraryRepository;
use App\Repositories\LikeRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
         $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
         $this->app->bind(LikeRepositoryInterface::class, LikeRepository::class);
         $this->app->bind(LibraryRepositoryInterface::class, LibraryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
