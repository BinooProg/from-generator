<div class="space-y-4 {{ $attributes->get('class') }}">
    @if (session('success'))
        <div class="border border-green-200 dark:border-green-900 bg-green-50 dark:bg-green-950 text-green-900 dark:text-green-100 px-6 py-4 rounded transition-colors duration-300 flex items-start justify-between group"
            role="alert">
            <div>
                <strong class="font-semibold">Success!</strong>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
            <button type="button"
                class="text-green-900 dark:text-green-100 hover:text-green-700 dark:hover:text-green-200 transition-colors ml-4 flex-shrink-0"
                aria-label="Close" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="border border-red-200 dark:border-red-900 bg-red-50 dark:bg-red-950 text-red-900 dark:text-red-100 px-6 py-4 rounded transition-colors duration-300 flex items-start justify-between group"
            role="alert">
            <div>
                <strong class="font-semibold">Error!</strong>
                <p class="text-sm mt-1">{{ session('error') }}</p>
            </div>
            <button type="button"
                class="text-red-900 dark:text-red-100 hover:text-red-700 dark:hover:text-red-200 transition-colors ml-4 flex-shrink-0"
                aria-label="Close" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif

    @if (session('warning'))
        <div class="border border-amber-200 dark:border-amber-900 bg-amber-50 dark:bg-amber-950 text-amber-900 dark:text-amber-100 px-6 py-4 rounded transition-colors duration-300 flex items-start justify-between group"
            role="alert">
            <div>
                <strong class="font-semibold">Warning!</strong>
                <p class="text-sm mt-1">{{ session('warning') }}</p>
            </div>
            <button type="button"
                class="text-amber-900 dark:text-amber-100 hover:text-amber-700 dark:hover:text-amber-200 transition-colors ml-4 flex-shrink-0"
                aria-label="Close" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif

    @if (session('info'))
        <div class="border border-blue-200 dark:border-blue-900 bg-blue-50 dark:bg-blue-950 text-blue-900 dark:text-blue-100 px-6 py-4 rounded transition-colors duration-300 flex items-start justify-between group"
            role="alert">
            <div>
                <strong class="font-semibold">Info!</strong>
                <p class="text-sm mt-1">{{ session('info') }}</p>
            </div>
            <button type="button"
                class="text-blue-900 dark:text-blue-100 hover:text-blue-700 dark:hover:text-blue-200 transition-colors ml-4 flex-shrink-0"
                aria-label="Close" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="border border-red-200 dark:border-red-900 bg-red-50 dark:bg-red-950 text-red-900 dark:text-red-100 px-6 py-4 rounded transition-colors duration-300 flex items-start justify-between group"
            role="alert">
            <div>
                <strong class="font-semibold">Validation Errors!</strong>
                <ul class="mt-3 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button type="button"
                class="text-red-900 dark:text-red-100 hover:text-red-700 dark:hover:text-red-200 transition-colors ml-4 flex-shrink-0"
                aria-label="Close" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif
</div>
