<?php

namespace App\Providers;

use App\Models\Chirp;
use App\Policies\ChirpPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
    * The policy mappings for the application.
    *
    * @var array
     */
    protected $policies = [
        Chirp::class => ChirpPolicy::class,
    ];

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
        $this->registerPolicies();
    }
}
