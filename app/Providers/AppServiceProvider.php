<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory as EloquentFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        app()->singleton(\Faker\Generator::class, function () {
            return FakerFactory::create('vi_VN');
        });
        EloquentFactory::guessFactoryNamesUsing(fn (string $modelName) => 'Database\\Factories\\' . class_basename($modelName) . 'Factory');
    }
}
