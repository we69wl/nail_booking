<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VpnAccount extends Model
{
    protected $fillable = ['user_id', 'uuid'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function email(): string
    {
        return "u{$this->user_id}@vpn";
    }

    public function link(): string
    {
        $host = config('vpn.host');

        return "vless://{$this->uuid}@{$host}:443"
            .'?encryption=none&type=ws&path=%2Fwebowl-wss&security=tls'
            ."&sni={$host}&fp=chrome&alpn=http%2F1.1#savin-wss";
    }
}
