@extends('layouts.app')

@section('title', 'Verify Email - Form Generator')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <!-- Title -->
            <div class="text-center mb-12">
                <!-- Email Icon -->
                <div
                    class="inline-flex items-center justify-center w-16 h-16 border-2 border-neutral-900 dark:border-neutral-100 rounded-full mb-6 transition-colors duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>

                <h1 class="text-4xl font-light tracking-tight mb-3">
                    Verify your <strong class="font-semibold">email</strong>
                </h1>
                <p class="text-neutral-600 dark:text-neutral-400 font-light">
                    Thanks for signing up! Before getting started, please verify your email address by clicking on the
                    link we just emailed to you.
                </p>
            </div>

            <!-- Status Messages -->
            <x-alert-messages class="mb-4" />

            <!-- Email Info Card -->
            <div
                class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-8 mb-6 transition-colors duration-300">
                <div class="flex items-start space-x-3 mb-6">
                    <svg class="w-5 h-5 text-neutral-600 dark:text-neutral-400 mt-0.5 flex-shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400 font-light">
                        <p class="font-medium text-neutral-900 dark:text-neutral-100 mb-2">Check your inbox</p>
                        <p>We sent an email to <strong
                                class="font-semibold text-neutral-900 dark:text-neutral-100">{{ auth()->user()->email }}</strong>
                        </p>
                        <p class="mt-2">Click the link in the email to verify your account.</p>
                    </div>
                </div>

                <!-- Resend Form -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 px-6 py-3 text-base font-medium border-2 border-neutral-900 dark:border-neutral-100 transition-all duration-300 hover:bg-transparent dark:hover:bg-transparent hover:text-neutral-900 dark:hover:text-neutral-100">
                        Resend Verification Email
                    </button>
                </form>

                <!-- Help Text -->
                <div class="mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-800">
                    <p class="text-xs text-center text-neutral-500 dark:text-neutral-400 font-light mb-4">
                        Didn't receive the email? Check your spam folder or try resending.
                    </p>

                    <!-- Logout Link -->
                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit"
                            class="text-sm text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 transition font-medium hover:underline">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>

            <!-- Support Link -->
            <div class="text-center">
                <p class="text-sm text-neutral-600 dark:text-neutral-400 font-light">
                    Need help? <a href="#" class="font-medium hover:underline transition">Contact support</a>
                </p>
            </div>
        </div>
    </div>
@endsection
