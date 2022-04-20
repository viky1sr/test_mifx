<?php

namespace App\Providers;

use App\Repository\BookCacheRepository;
use App\Repository\BookReviewCacheRepository;
use App\Repository\Interfaces\BookRepositoryInterface;
use App\Repository\Interfaces\BookReviewRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\UserCacheRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class , UserCacheRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookCacheRepository::class);
        $this->app->bind(BookReviewRepositoryInterface::class, BookReviewCacheRepository::class);
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
