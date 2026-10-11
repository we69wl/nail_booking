<?php

namespace App\Http\Controllers;

use App\Models\VpnAccount;
use App\Services\VpnService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class VpnController extends Controller
{
    public function store(Request $request, VpnService $vpn)
    {
        $user = $request->user();
        abort_unless($user->vpn_allowed, 403);

        $account = VpnAccount::firstOrCreate(
            ['user_id' => $user->id],
            ['uuid' => (string) Str::uuid()]
        );

        return $this->run(fn () => $vpn->add($account));
    }

    public function regenerate(Request $request, VpnService $vpn)
    {
        $user = $request->user();
        abort_unless($user->vpn_allowed, 403);

        $account = $user->vpnAccount;
        abort_unless($account, 404);

        return $this->run(function () use ($vpn, $account) {
            $vpn->remove($account);
            $account->update(['uuid' => (string) Str::uuid()]);
            $vpn->add($account);
        });
    }

    public function destroy(Request $request, VpnService $vpn)
    {
        if ($account = $request->user()->vpnAccount) {
            $vpn->remove($account);
            $account->delete();
        }

        return back();
    }

    private function run(callable $fn)
    {
        try {
            $fn();
        } catch (Throwable $e) {
            report($e);

            return back()->withErrors(['vpn' => 'Не удалось связаться с VPN-сервером. Попробуйте позже.'], 'vpn');
        }

        return back();
    }
}
