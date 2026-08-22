<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Http\Request;

class ChirpController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with(['user', 'likes', 'likedByUsers'])
            ->latest()
            ->paginate(20);

        return view('home', ['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ], [
            'message.required' => 'Please write something to chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
        ]);

        // Create the chirp (no user for now - we'll add auth later)
        // Use the authenticated user
        auth()->user()->chirps()->create($validated);

        // Redirect back to the feed
        return redirect('/')->with('success', 'Your chirp has been posted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        // We'll add authorization in lesson 11
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        // Validate
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Update
        $chirp->update($validated);

        return redirect('/')->with('success', 'Chirp updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect('/')->with('success', 'Chirp deleted!');
    }

    public function byUser(User $user)
    {
        $chirps = $user->chirps()
            ->with(['user', 'likes', 'likedByUsers'])
            ->latest()
            ->paginate(20);

        return view('chirps.by-user', compact('user', 'chirps'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $chirps = Chirp::with(['user', 'likes', 'likedByUsers'])
            ->when($query, function ($builder, $query) {
                $builder->where('message', 'LIKE', '%' . $query . '%');
            })
            ->latest()
            ->paginate(20);

        return view('chirps.search', [
            'chirps' => $chirps,
            'query' => $query,
        ]);
    }

    public function liked(Request $request)
    {
        $chirps = $request->user()
            ->likedChirps()
            ->with(['user', 'likes', 'likedByUsers'])
            ->latest()
            ->paginate(20);

        return view('chirps.liked', ['chirps' => $chirps]);
    }

    public function feed(Request $request)
    {
        $followingIds = $request->user()->following()->pluck('users.id');

        $chirps = Chirp::with(['user', 'likes', 'likedByUsers'])
            ->whereIn('user_id', $followingIds)
            ->latest()
            ->paginate(20);

        return view('chirps.feed', ['chirps' => $chirps]);
    }
}
