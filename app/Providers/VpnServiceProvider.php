<?php

namespace App\Providers;

use App\Services\VpnService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class VpnServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(VpnService::class, function ($app) {
            return new VpnService(
                api: config('vpn.api'),
                tag: config('vpn.tag'),
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function provides(): array
    {
        return [VpnService::class];
    }
}
