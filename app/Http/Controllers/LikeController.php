<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Chirp $chirp)
    {
        $user = $request->user();

        $exists = $chirp->likes()->where('user_id', $user->id)->first();

        if ($exists) {
            $exists->delete();
        } else {
            $chirp->likes()->create(['user_id' => $user->id]);
        }

        return redirect()->back();
    }
}
