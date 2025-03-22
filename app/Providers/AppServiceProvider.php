<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Interfaces\ArenaRepositoryInterface;
use App\Repositories\Interfaces\TimeSlotRepositoryInterface;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\ArenaRepository;
use App\Repositories\TimeSlotRepository;
use App\Repositories\BookingRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(ArenaRepositoryInterface::class, ArenaRepository::class);
         $this->app->bind(TimeSlotRepositoryInterface::class, TimeSlotRepository::class);
         $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191); // Fix for MySQL index length
    }
}
