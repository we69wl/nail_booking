<x-layout>
    <x-slot:title>
        Edit Profile
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">Edit Profile</h1>

        <div class="card bg-base-100 mt-8">
            <div class="card-body">
                <form method="POST" action="/user/profile">
                    @csrf
                    @method('PATCH')

                    <div class="form-control w-full">
                        <label class="floating-label mb-6" for="name">
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Anonymous"
                                class="input input-bordered w-full @error('name') input-error @enderror"
                                required
                                id="name"
                                autofocus
                            />
                            <span class="label-text">Name</span>
                        </label>

                        @error('name')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="floating-label mb-6" for="email">
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                placeholder="mail@example.com"
                                class="input input-bordered w-full @error('email') input-error @enderror"
                                required
                                id="email"
                            />
                            <span class="label-text">Email</span>
                        </label>

                        @error('email')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="form-control w-full">
                        <label class="floating-label mb-6" for="password">
                            <input
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                class="input input-bordered w-full @error('password') input-error @enderror"
                                id="password"
                            />
                            <span class="label-text">Password</span>
                        </label>

                        @error('password')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="form-control w-full">
                        <label class="floating-label mb-6" for="password_confirmation">
                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="••••••••"
                                class="input input-bordered w-full"
                                id="password_confirmation"
                            />
                            <span class="label-text">Confirm Password</span>
                        </label>

                    </div>

                    <div class="card-actions justify-between mt-4">
                        <a href="/" class="btn btn-ghost btn-sm">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
