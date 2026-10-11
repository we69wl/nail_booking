<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('vpn:sync')]
#[Description('Re-add all allowed VPN accounts to Xray')]
class VpnSync extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(\App\Services\VpnService $vpn): int
    {
        \App\Models\VpnAccount::whereHas('user', fn ($q) => $q->where('vpn_allowed', true))
        ->each(function ($a) use ($vpn) {
            try { $vpn->add($a); } catch (\Throwable $e) { $this->error($e->getMessage()); }
        });

        return self::SUCCESS;
    }
}
