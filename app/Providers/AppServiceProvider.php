<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\BookingRepository;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Repositories\RoomRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(RoomRepositoryInterface::class, RoomRepository::class);
    }

    public function boot(): void
    {
        //
    }
}