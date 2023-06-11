<x-unsecured-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('unsecured.login') }}">
            {{-- @csrf --}}
            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            @if (session()->has('query'))
                <div class="alert alert-success">
                    @foreach (session('query') as $user)
                        @foreach ($user as $param)
                            <p class="break-word">{{ $param }}</p>
                        @endforeach
                    @endforeach
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Get log in info') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-unsecured-layout>
