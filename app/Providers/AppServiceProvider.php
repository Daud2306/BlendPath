<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Models\Tanya;
use App\Models\Jawab;
use App\Policies\TanyaPolicy;
use App\Policies\JawabPolicy;
use Illuminate\Support\Facades\Gate;

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
        Gate::policy(Tanya::class, TanyaPolicy::class);
        Gate::policy(Jawab::class, JawabPolicy::class);
    }
}
