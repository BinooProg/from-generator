@extends('layouts.app')

@section('title', 'Sign Up - Form Generator')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <!-- Title -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-light tracking-tight mb-3">
                    Create your <strong class="font-semibold">account</strong>
                </h1>
                <p class="text-neutral-600 dark:text-neutral-400 font-light">
                    Start building forms in minutes
                </p>
            </div>

            <!-- Session Status / Alert Messages -->
            <x-alert-messages class="mb-4" />

            <!-- Form Card -->
            <div
                class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-8 transition-colors duration-300">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">Full Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                            autocomplete="name" placeholder="John Doe"
                            class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 transition-all duration-200 placeholder:text-neutral-400" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                            autocomplete="username" placeholder="your@email.com"
                            class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 transition-all duration-200 placeholder:text-neutral-400" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium mb-2">Password</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 transition-all duration-200 placeholder:text-neutral-400" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium mb-2">Confirm
                            Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            autocomplete="new-password" placeholder="••••••••"
                            class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 transition-all duration-200 placeholder:text-neutral-400" />
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <input id="terms" name="terms" type="checkbox" required
                            class="w-4 h-4 mt-1 border-neutral-300 dark:border-neutral-700 rounded focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100" />
                        <label for="terms" class="ml-2 text-sm text-center text-neutral-600 dark:text-neutral-400">
                            I agree to the <a href="#" class="font-medium hover:underline transition">Terms of
                                Service</a> and <a href="#" class="font-medium hover:underline transition">Privacy
                                Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 px-6 py-3 text-base font-medium border-2 border-neutral-900 dark:border-neutral-100 transition-all duration-300 hover:bg-transparent dark:hover:bg-transparent hover:text-neutral-900 dark:hover:text-neutral-100">
                        Create Account
                    </button>

                    <!-- Divider -->
                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-neutral-200 dark:border-neutral-800"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span
                                class="px-3 bg-white dark:bg-neutral-950 text-neutral-500 dark:text-neutral-400 font-light">or
                                sign up with</span>
                        </div>
                    </div>

                    <!-- Google Sign Up -->
                    <a href="{{ url('auth/google') }}"
                        class="w-full flex items-center justify-center space-x-3 px-6 py-3 border border-neutral-300 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-all duration-200 font-medium">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="currentColor"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="currentColor"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="currentColor"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span>Google</span>
                    </a>
                </form>
            </div>

            <!-- Login Link -->
            <div class="text-center mt-8">
                <p class="text-sm text-neutral-600 dark:text-neutral-400 font-light">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium hover:underline transition">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
