<x-layout>
    <x-slot:title>
        Feed
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <x-list :chirps="$chirps" />
    </div>
</x-layout>

