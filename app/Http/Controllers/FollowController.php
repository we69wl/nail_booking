<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(Request $request, User $user)
    {
        $follower = $request->user();

        abort_if($follower->id === $user->id, 403, "You can't follow yourself");

        if ($follower->following()->where('followed_id', $user->id)->exists()) {
            $follower->following()->detach($user->id);
        } else {
            $follower->following()->attach($user->id);
        }

        return redirect()->back();
    }
}
