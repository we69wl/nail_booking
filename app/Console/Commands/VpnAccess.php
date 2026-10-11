<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('vpn:access {email} {state : on|off}')]
#[Description('Grant or revoke VPN access for a user')]
class VpnAccess extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(\App\Services\VpnService $vpn): int
    {
        $user = \App\Models\User::where('email', $this->argument('email'))->firstOrFail();
        $on = $this->argument('state') === 'on';

        $user->forceFill(['vpn_allowed' => $on])->save();

        if (! $on && $user->vpnAccount) {
            $vpn->remove($user->vpnAccount);
            $user->vpnAccount->delete();
        }

        $this->info($user->email.': vpn '.($on ? 'on' : 'off'));

        return self::SUCCESS;
    }
}
