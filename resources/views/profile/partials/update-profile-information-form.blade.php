<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-base text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center space-x-6">
            <div class="shrink-0">
                @if($user->avatar)
                    <img class="h-16 w-16 object-cover rounded-full shadow-sm" src="{{ Storage::url($user->avatar) }}" alt="Current avatar" />
                @else
                    <div class="h-16 w-16 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center">
                        <span class="text-blue-600 font-bold text-xl">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-0">
                <input type="file" name="avatar" id="avatar_file_input" accept="image/*" class="sr-only"
                       onchange="document.getElementById('avatar_filename_display').textContent = this.files[0] ? this.files[0].name : '{{ __('Tidak ada file yang dipilih') }}';">
                <label for="avatar_file_input" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold cursor-pointer transition select-none">
                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    {{ __('Pilih File') }}
                </label>
                <div id="avatar_filename_display" class="py-2 px-3 text-xs text-gray-500 border border-gray-300 rounded-r-lg bg-gray-50 min-w-[150px] truncate select-none">
                    {{ __('Tidak ada file yang dipilih') }}
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-base mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-base text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-base text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-base text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
