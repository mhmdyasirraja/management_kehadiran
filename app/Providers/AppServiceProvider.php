<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use App\Contracts\IKehadiran;
use App\Services\KehadiranService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IKehadiran::class, KehadiranService::class);
    }

    public function boot()
    {
        //
    }
}