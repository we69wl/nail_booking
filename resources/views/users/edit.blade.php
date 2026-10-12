<x-layout>
    <x-slot:title>
        Edit Profile
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">Edit Profile</h1>

        <div class="card bg-base-100 mt-8">
            <div class="card-body">
                <form method="POST" action="/user/profile" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-control w-full mb-6">
                        <div class="flex items-center gap-4">
                            <div class="avatar">
                                <div class="size-16 rounded-full">
                                    <img src="{{ $user->avatar_url }}" alt="Current avatar" class="rounded-full" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <label class="label" for="avatar">
                                    <span class="label-text">Avatar</span>
                                </label>
                                <input
                                    type="file"
                                    name="avatar"
                                    accept="image/*"
                                    class="file-input file-input-bordered w-full @error('avatar', 'updateProfile') input-error @enderror"
                                    id="avatar"
                                />
                                @error('avatar', 'updateProfile')
                                <div class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-control w-full">
                        <label class="floating-label mb-6" for="name">
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Anonymous"
                                class="input input-bordered w-full @error('name', 'updateProfile') input-error @enderror"
                                required
                                id="name"
                                autofocus
                            />
                            <span class="label-text">Name</span>
                        </label>

                        @error('name', 'updateProfile')
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
                                class="input input-bordered w-full @error('email', 'updateProfile') input-error @enderror"
                                required
                                id="email"
                            />
                            <span class="label-text">Email</span>
                        </label>

                        @error('email', 'updateProfile')
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
                                class="input input-bordered w-full @error('password', 'updateProfile') input-error @enderror"
                                id="password"
                            />
                            <span class="label-text">Password</span>
                        </label>

                        @error('password', 'updateProfile')
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

        <h2 class="text-3xl font-bold mt-8">Delete Profile</h2>
        <div class="card bg-base-100 mt-8">
            <div class="card-body">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete your account?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                </p>

                <div class="card-actions justify-end mt-4">
                    <button type="button" class="btn btn-error btn-sm" onclick="delete_account_modal.showModal()">
                        Delete Profile
                    </button>
                </div>
            </div>
        </div>

        <dialog id="delete_account_modal" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold">Confirm account deletion</h3>
                <p class="py-4 text-sm text-gray-600">
                    This action cannot be undone. Please enter your password to confirm.
                </p>

                <form method="post" action="/user/profile">
                    @csrf
                    @method('DELETE')

                    <div class="form-control w-full">
                        <label class="floating-label mb-6" for="delete_password">
                            <input
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                class="input input-bordered w-full @error('password', 'deleteAccount') input-error @enderror"
                                id="delete_password"
                                required
                            />
                            <span class="label-text">Password</span>
                        </label>

                        @error('password', 'deleteAccount')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="modal-action">
                        <button type="button" class="btn btn-ghost" onclick="delete_account_modal.close()">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-error">
                            Yes, delete my account
                        </button>
                    </div>
                </form>
            </div>

            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </div>
</x-layout>

@error('password', 'deleteAccount')
<script>
    document.addEventListener('DOMContentLoaded', () => delete_account_modal.showModal());
</script>
@enderror
