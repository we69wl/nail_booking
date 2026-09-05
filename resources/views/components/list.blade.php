@props(['chirps'])

<div class="space-y-4 mt-8">
    @forelse ($chirps as $chirp)
        <x-chirp :chirp="$chirp" />
    @empty
        <p class="text-center text-base-content/60 mt-8">No chirps yet.</p>
    @endforelse
</div>

<div class="mt-6">
    {{ $chirps->links() }}
</div>
