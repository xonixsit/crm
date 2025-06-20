<x-guest-layout>
        <div class="w-full max-w-md bg-white/20 backdrop-blur-md border border-white/30 dark:bg-gray-900/30 dark:border-gray-700/50 rounded-3xl shadow-xl p-8 space-y-6 transition-all duration-300">

            <div class="text-center">
                <!-- <img src="{{ asset('images/crm-logo.png') }}" alt="CRM Logo" class="mx-auto h-14 w-auto mb-4"> -->
                <h2 class="text-3xl font-extrabold text-white dark:text-white tracking-tight">
                    {{ __('Welcome Back!') }}
                </h2>
                <p class="mt-1 text-sm text-gray-200">
                    {{ __('Please sign in to your CRM dashboard') }}
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div class="relative">
                    <label for="email" class="block text-sm font-medium text-white">
                        {{ __('Email') }}
                    </label>
                    <div class="mt-1 relative">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full px-4 py-2 rounded-lg bg-white/90 text-gray-900 placeholder-gray-500 shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                            placeholder="you@example.com"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-200" />
                </div>

                <!-- Password -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-white">
                        {{ __('Password') }}
                    </label>
                    <div class="mt-1">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full px-4 py-2 rounded-lg bg-white/90 text-gray-900 placeholder-gray-500 shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                            placeholder="••••••••"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-200" />
                </div>

                <!-- Remember Me + Forgot -->
                <div class="flex items-center justify-between text-white">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-pink-500 shadow-sm focus:ring-pink-500">
                        <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium hover:underline text-pink-200 hover:text-white">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div>
                    <x-primary-button class="w-full justify-center py-2 text-lg bg-pink-600 hover:bg-pink-700 text-white rounded-lg">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Footer CTA -->
            <div class="text-center text-sm text-white">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="text-pink-200 font-semibold hover:underline">
                    {{ __('Register') }}
                </a>
            </div>
        </div>
</x-guest-layout>
