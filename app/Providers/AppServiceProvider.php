<?php

namespace App\Providers;

use App\Models\{Vegetable, VegetableClassification};
use App\Http\Controllers\{VegetableController, VegetableClassificationController};
use App\Http\Resources\{VegetableResource, VegetableClassificationResource};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // App bindings
        $this->app->singleton(Vegetable::class);
        $this->app->when(VegetableController::class)
            ->needs(Vegetable::class)
            ->give(Vegetable::class);
        $this->app->when(VegetableController::class)
            ->needs(VegetableResource::class)
            ->give(VegetableResource::class);

        $this->app->bind(VegetableResource::class);
        $this->app->when(VegetableResource::class)
            ->needs('$resource')
            ->give(Vegetable::class);

        $this->app->singleton(VegetableClassification::class);
        $this->app->when(VegetableClassificationController::class)
            ->needs(VegetableClassification::class)
            ->give(VegetableClassification::class);
        $this->app->when(VegetableClassificationController::class)
            ->needs(VegetableClassificationResource::class)
            ->give(VegetableClassificationResource::class);

        $this->app->bind(VegetableClassificationResource::class);
        $this->app->when(VegetableClassificationResource::class)
            ->needs('$resource')
            ->give(VegetableClassification::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Error handler
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \App\Handlers\ExceptionHandler::class
        );
    }
}
