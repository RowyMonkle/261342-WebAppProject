<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--secondary);">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="page-wrap">
        <div class="container space-y-6">

            {{-- Profile info --}}
            <div class="card card-pad">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Profile photo --}}
            <div class="card card-pad">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-photo-form')
                </div>
            </div>

            {{-- Password --}}
            <div class="card card-pad">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete user (make this one animated / highlighted) --}}
            <div class="animated-border">
                <div class="animated-border-content card card-pad">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
