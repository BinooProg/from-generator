<div class="flex items-center space-x-3 px-4 py-3">
    <div
        class="w-10 h-10 rounded-full bg-neutral-200 dark:bg-neutral-800 flex items-center justify-center font-medium text-sm">
        {{ strtoupper(substr($userName, 0, 1)) }}
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium truncate">{{ $userName }}</p>
        <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate">{{ $userEmail }}</p>
    </div>
</div>
