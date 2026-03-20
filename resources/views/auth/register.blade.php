<x-guest-layout>
    <div class="animated-border">
        <div class="animated-border-content card card-pad">
            <h1 class="h1 mb-1" style="color: var(--text);">Create account</h1>
            <p class="muted mb-6">Register to start shopping 💗</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                        class="input mt-1"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email')"
                        required
                        autocomplete="username"
                        class="input mt-1"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="input mt-1"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirm Password --}}
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="input mt-1"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="pt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-6">
                    <a
                        href="{{ route('login') }}"
                        class="text-sm underline"
                        style="color: var(--secondary);"
                    >
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>