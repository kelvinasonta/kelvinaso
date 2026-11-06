@php
    $ouths = [];
@endphp

<x-auth-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    <div class="auth-card">
        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-subtitle">Sign in to your account to continue.</p>

        <form class="auth-form" action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <x-input-label class="form-label" for="email" :value="__('Email address')" />
                <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>


            <div class="form-group">
                <x-input-label class="form-label" for="password" :value="__('Password')" />
                <x-text-input id="password" class="form-input" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="auth-links">

                <label for="remember_me"
                    style="display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; color:var(--muted); cursor:pointer;">
                    <input id="remember_me" name="remember" type="checkbox"> {{ __('Remember me') }}
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button style="width: 100%; justify-content: center; margin-top: 0.5rem;">
                {{ __('Log In') }}
            </x-primary-button>

        </form>

        <x-oauth-component :oAuth="$ouths" />

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</x-auth-layout>
