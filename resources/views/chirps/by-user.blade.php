<x-layout>
    <x-slot:title>
        {{ $user ? $user->name : "Anonymous"}} Chirps
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 mt-8">
            <div class="card-body">
                <div class="flex items-center gap-4">
                    <div class="avatar">
                        <div class="size-16 rounded-full">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}'s avatar" class="rounded-full" />
                        </div>
                    </div>

                    <div class="flex-1">
                        <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                        <span class="text-sm text-base-content/60">
                            {{ $user->followers()->count() }} followers · {{ $user->following()->count() }} following
                        </span>
                    </div>

                    @auth
                        @if (auth()->id() !== $user->id)
                            <form method="POST" action="{{ route('users.follow', $user) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ auth()->user()->following->contains($user->id) ? 'btn-ghost' : 'btn-primary' }}">
                                    {{ auth()->user()->following->contains($user->id) ? 'Unfollow' : 'Follow' }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <h2 class="text-3xl font-bold mt-8">{{ $user ? $user->name : "Anonymous"}} Chirps</h2>

        <div class="mt-6 space-y-4">
            <x-list :chirps="$chirps" />
        </div>
    </div>
</x-layout>
