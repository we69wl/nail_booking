@props(['chirp'])

<div class="card bg-base-100">
    <div class="card-body">
        <div class="flex space-x-3">
            @if ($chirp->user)
                <a href="{{ route('chirps.by_user', $chirp->user) }}">
                    <div class="avatar">
                        <div class="size-10 rounded-full">
                            <img
                                src="{{ $chirp->user->avatar_url }}"
                                alt="{{ $chirp->user->name }}'s avatar"
                                class="rounded-full"
                            />
                        </div>
                    </div>
                </a>
            @else
                <div class="avatar placeholder">
                    <div class="size-10 rounded-full">
                        <img
                            src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=stealth"
                            alt="Anonymous User"
                            class="rounded-full"
                        />
                    </div>
                </div>
            @endif

            <div class="min-w-0 flex-1">
                <div class="flex justify-between w-full">
                    <div class="flex items-center gap-1">
                        <span class="text-sm font-semibold">{{ $chirp->user ? $chirp->user->name : 'Anonymous' }}</span>
                        <span class="text-base-content/60">·</span>
                        <span class="text-sm text-base-content/60">{{ $chirp->created_at->diffForHumans() }}</span>
                        @if ($chirp->updated_at->gt($chirp->created_at->addSeconds(5)))
                            <span class="text-base-content/60">·</span>
                            <span class="text-sm text-base-content/60 italic">edited</span>
                        @endif
                    </div>

                    @can('update', $chirp)
                        <div class="flex gap-1">
                            <a href="/chirps/{{ $chirp->id }}/edit" class="btn btn-ghost btn-xs">
                                Edit
                            </a>
                            <form method="POST" action="/chirps/{{ $chirp->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this chirp?')"
                                    class="btn btn-ghost btn-xs text-error">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
                <p class="mt-1">{{ $chirp->message }}</p>
                <div class="mt-2">
                    @auth
                        <form method="POST" action="{{ route('chirps.like', $chirp) }}">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-xs gap-1">
                                @if ($chirp->likedByUsers->contains(auth()->id()))
                                    <span class="text-error">♥</span>
                                @else
                                    <span>♡</span>
                                @endif
                                {{ $chirp->likes->count() }}
                            </button>
                        </form>
                    @else
                        <span class="text-sm text-base-content/60">♡ {{ $chirp->likes->count() }}</span>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
