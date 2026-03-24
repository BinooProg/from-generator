@extends('layouts.dashboard')

@section('dashboard-content')
    <div x-data="dashboardNav" x-init="init()" x-on:switch-view.window="switchView($event.detail)">

        <!-- Dashboard View -->
        <div x-show="currentView === 'dashboard'" x-cloak x-transition.duration.200ms>

            <!-- Welcome Card -->
            <div
                class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-8 mb-6 transition-colors duration-300">
                <h2 class="text-3xl font-light tracking-tight mb-3">
                    Welcome <strong class="font-semibold">back</strong>
                </h2>
                <p class="text-neutral-600 dark:text-neutral-400 font-light mb-8">
                    You're all set. Start building beautiful forms and collect meaningful data.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Create Form Card -->
                    <button @click="switchView('forms')" class="block group focus:outline-none text-left w-full">
                        <div
                            class="h-full p-6 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 transition-all duration-300 hover:border-neutral-900 dark:hover:border-neutral-100">
                            <div
                                class="flex items-center justify-center w-12 h-12 border-2 border-neutral-900 dark:border-neutral-100 mb-4 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2 transition-colors duration-300">
                                Create Form
                            </h3>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 font-light">
                                Start building your first form with our intuitive builder
                            </p>
                        </div>
                    </button>

                    <!-- Analytics Card -->
                    <button @click="switchView('analytics')" class="block group focus:outline-none text-left w-full">
                        <div
                            class="h-full p-6 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 transition-all duration-300 hover:border-neutral-900 dark:hover:border-neutral-100">
                            <div
                                class="flex items-center justify-center w-12 h-12 border-2 border-neutral-900 dark:border-neutral-100 mb-4 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2 transition-colors duration-300">
                                Analytics
                            </h3>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 font-light">
                                Track form submissions and analyze your data
                            </p>
                        </div>
                    </button>

                    <!-- Submissions Card -->
                    <button @click="switchView('submissions')" class="block group focus:outline-none text-left w-full">
                        <div
                            class="h-full p-6 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 transition-all duration-300 hover:border-neutral-900 dark:hover:border-neutral-100">
                            <div
                                class="flex items-center justify-center w-12 h-12 border-2 border-neutral-900 dark:border-neutral-100 mb-4 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2 transition-colors duration-300">
                                Submissions
                            </h3>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 font-light">
                                View and manage all form submissions
                            </p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div
                    class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 transition-colors duration-300">
                    <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-2">Total Forms</p>
                    <p class="text-3xl font-light tracking-tight">{{ $totalForms }} </p>
                </div>
                <div
                    class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 transition-colors duration-300">
                    <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-2">Submissions</p>
                    <p class="text-3xl font-light tracking-tight">{{ $totalSubmissions }} </p>
                </div>
                <div
                    class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 transition-colors duration-300">
                    <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-2">This Week</p>
                    <p class="text-3xl font-light tracking-tight">{{ $thisWeekSubmissions }}</p>
                </div>
                <div
                    class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-6 transition-colors duration-300">
                    <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-2">Active Forms</p>
                    <p class="text-3xl font-light tracking-tight">{{ $activeForms }}</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div
                class="bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-8 transition-colors duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-light tracking-tight">
                        Recent <strong class="font-semibold">Activity</strong>
                    </h3>
                    @if ($recentActivity->isNotEmpty())
                        <a href="{{ route('dashboard', ['view' => 'submissions']) }}"
                            class="text-xs font-medium text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors duration-200 underline underline-offset-4">
                            View all submissions
                        </a>
                    @endif
                </div>

                @if ($recentActivity->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto mb-4 text-neutral-300 dark:text-neutral-700" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-neutral-600 dark:text-neutral-400 font-light mb-4">
                            No recent activity yet
                        </p>
                        <a href="{{ route('forms.create') }}"
                            class="inline-block bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 px-6 py-3 text-sm font-medium border-2 border-neutral-900 dark:border-neutral-100 transition-all duration-300 hover:bg-transparent dark:hover:bg-transparent hover:text-neutral-900 dark:hover:text-neutral-100">
                            Create Your First Form
                        </a>
                    </div>
                @else
                    <ol class="relative border-l border-neutral-200 dark:border-neutral-800 ml-3 space-y-0">
                        @foreach ($recentActivity as $event)
                            <li class="mb-0 pl-6 pb-6 last:pb-0 relative group">

                                {{-- Timeline dot --}}
                                @if ($event['type'] === 'submission')
                                    {{-- Inbox dot --}}
                                    <span
                                        class="absolute -left-[11px] top-0.5 flex items-center justify-center w-5 h-5 rounded-full border-2 bg-white dark:bg-neutral-950 border-neutral-900 dark:border-neutral-100 transition-colors duration-300">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4" />
                                        </svg>
                                    </span>
                                @elseif ($event['type'] === 'form_created')
                                    {{-- Plus dot --}}
                                    <span
                                        class="absolute -left-[11px] top-0.5 flex items-center justify-center w-5 h-5 rounded-full border-2 bg-white dark:bg-neutral-950 border-neutral-300 dark:border-neutral-700 transition-colors duration-300">
                                        <svg class="w-2.5 h-2.5 text-neutral-500 dark:text-neutral-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </span>
                                @else
                                    {{-- Pencil dot --}}
                                    <span
                                        class="absolute -left-[11px] top-0.5 flex items-center justify-center w-5 h-5 rounded-full border-2 bg-white dark:bg-neutral-950 border-neutral-300 dark:border-neutral-700 transition-colors duration-300">
                                        <svg class="w-2.5 h-2.5 text-neutral-500 dark:text-neutral-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828 8 17l1.172-3.828z" />
                                        </svg>
                                    </span>
                                @endif

                                {{-- Content --}}
                                <a href="{{ $event['url'] }}" class="flex items-start justify-between gap-4 group/item">
                                    <div>
                                        <p
                                            class="text-sm font-medium text-neutral-900 dark:text-neutral-100 leading-snug group-hover/item:underline underline-offset-2">
                                            @if ($event['type'] === 'submission')
                                                New submission on
                                                <span class="font-semibold">{{ $event['label'] }}</span>
                                            @elseif ($event['type'] === 'form_created')
                                                Created form
                                                <span class="font-semibold">{{ $event['label'] }}</span>
                                            @else
                                                Updated form
                                                <span class="font-semibold">{{ $event['label'] }}</span>
                                            @endif
                                        </p>
                                        <time class="text-xs text-neutral-500 dark:text-neutral-500 mt-0.5 block"
                                            datetime="{{ $event['timestamp']->toIso8601String() }}"
                                            title="{{ $event['timestamp']->format('M d, Y \a\t g:i A') }}">
                                            {{ $event['timestamp']->diffForHumans() }}
                                        </time>
                                    </div>

                                    {{-- Badge --}}
                                    @if ($event['type'] === 'submission')
                                        <span
                                            class="shrink-0 mt-0.5 inline-flex items-center px-2 py-0.5 text-xs font-medium border border-neutral-900 dark:border-neutral-100 text-neutral-900 dark:text-neutral-100">
                                            Submission
                                        </span>
                                    @elseif ($event['type'] === 'form_created')
                                        <span
                                            class="shrink-0 mt-0.5 inline-flex items-center px-2 py-0.5 text-xs font-medium border border-neutral-200 dark:border-neutral-700 text-neutral-500 dark:text-neutral-400">
                                            New form
                                        </span>
                                    @else
                                        <span
                                            class="shrink-0 mt-0.5 inline-flex items-center px-2 py-0.5 text-xs font-medium border border-neutral-200 dark:border-neutral-700 text-neutral-500 dark:text-neutral-400">
                                            Updated
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>

        <!-- Forms View -->
        @include('dashboard.forms')

        <!-- Submissions View -->
        @include('dashboard.submissions')

        <!-- Analytics View -->
        <div x-show="currentView === 'analytics'" x-cloak x-transition.duration.200ms>
            @livewire('analytics')
        </div>

        <!-- Settings View -->
        <div x-show="currentView === 'settings'" x-cloak x-transition.duration.200ms style="min-height: 400px;">
            <livewire:profile-settings />
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('dashboardNav', {
                    currentView: '{{ request('view', 'dashboard') }}'
                });

                Alpine.data('dashboardNav', () => ({
                    currentView: '{{ request('view', 'dashboard') }}',

                    init() {
                        this.currentView = Alpine.store('dashboardNav').currentView;
                        this.$watch('currentView', value => {
                            Alpine.store('dashboardNav').currentView = value;
                        });
                    },

                    switchView(view) {
                        this.currentView = view;

                        // Keep the URL in sync so a reload restores the active tab.
                        // Preserve ?page when on forms, strip it for other views.
                        const url = new URL(window.location.href);
                        url.searchParams.set('view', view);
                        if (view !== 'forms') {
                            url.searchParams.delete('page');
                        }
                        history.replaceState(null, '', url.toString());
                    }
                }));
            });
        </script>
    @endpush
@endsection
