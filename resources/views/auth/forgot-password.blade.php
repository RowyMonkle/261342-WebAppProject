<x-guest-layout>
    <div class="animated-border">
        <div class="animated-border-content card card-pad">
            <h1 class="h1 mb-1" style="color: var(--text);">
                Forgot password?
            </h1>

            <p class="muted mb-6">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email')"
                        required
                        autofocus
                        class="input mt-1"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="btn-primary">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>