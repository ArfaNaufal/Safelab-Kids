<?php

namespace App\Providers;

use App\Domain\Contracts\ExperimentProgressRepositoryInterface;
use App\Domain\Contracts\ExperimentRepositoryInterface;
use App\Domain\Contracts\QuestionRepositoryInterface;
use App\Infrastructure\Repositories\EloquentExperimentProgressRepository;
use App\Infrastructure\Repositories\EloquentExperimentRepository;
use App\Infrastructure\Repositories\EloquentQuestionRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExperimentRepositoryInterface::class, EloquentExperimentRepository::class);
        $this->app->singleton(QuestionRepositoryInterface::class, EloquentQuestionRepository::class);
        $this->app->singleton(ExperimentProgressRepositoryInterface::class, EloquentExperimentProgressRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. Force HTTPS if the app is in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
