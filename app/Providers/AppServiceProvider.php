<?php

namespace App\Providers;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;
use App\Features\Trivia\Infrastructure\Persistence\TriviaEloquentRepository;
use App\Features\User\Domain\Repositories\PointRepository;
use App\Features\User\Domain\Repositories\ProfileRepository;
use App\Features\User\Domain\Repositories\UserRepository;
use App\Features\User\Infrastructure\Persistence\PointEloquentRepository;
use App\Features\User\Infrastructure\Persistence\ProfileEloquentRepository;
use App\Features\User\Infrastructure\Persistence\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserEloquentRepository::class);
        $this->app->bind(ProfileRepository::class, ProfileEloquentRepository::class);
        $this->app->bind(PointRepository::class, PointEloquentRepository::class);
        $this->app->bind(TriviaRepository::class, TriviaEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
