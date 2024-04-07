<?php

namespace App\Providers;

use App\Domain\Book\Repositories\BookRepository;
use App\Domain\Book\Repositories\BookRepositoryInterface;
use App\Domain\User\Repositories\UserRepository;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
    */
    public $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        BookRepositoryInterface::class => BookRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
