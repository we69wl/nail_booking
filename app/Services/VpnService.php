<?php

namespace App\Services;

use App\Models\VpnAccount;
use Illuminate\Support\Facades\Process;
use RuntimeException;

class VpnService
{
    public function __construct(
        private readonly string $api,
        private readonly string $tag,
    ) {}

    public function add(VpnAccount $a): void
    {
        $cfg = ['inbounds' => [[
            'tag'      => $this->tag,
            'protocol' => 'vless',
            'settings' => [
                'clients'    => [['id' => $a->uuid, 'email' => $a->email()]],
                'decryption' => 'none',
            ],
        ]]];

        $file = tempnam(sys_get_temp_dir(), 'xr');
        file_put_contents($file, json_encode($cfg));

        $r = Process::timeout(10)->run(['xray', 'api', 'adu', '-s', $this->api, $file]);
        @unlink($file);

        $out = $r->output().$r->errorOutput();
        if ($r->failed() && ! str_contains($out, 'already exists')) {
            throw new RuntimeException('Xray API: '.trim($out));
        }
    }

    public function remove(VpnAccount $a): void
    {
        Process::timeout(10)->run([
            'xray', 'api', 'rmu', '-s', $this->api,
            '-tag='.$this->tag, $a->email(),
        ]);
    }
}
