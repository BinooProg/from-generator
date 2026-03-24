<div class="flex h-full -m-6" x-data="{ showUnsavedModal: false }">

    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    {{-- UNSAVED CHANGES MODAL                                             --}}
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    <template x-teleport="body">
        <div x-show="showUnsavedModal" x-cloak class="fixed inset-0 z-9999 flex items-center justify-center">
            <div x-show="showUnsavedModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0 bg-black/40 dark:bg-black/60"
                @click="showUnsavedModal = false"></div>
            <div x-show="showUnsavedModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md mx-4 bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 shadow-2xl p-6">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Unsaved Changes</h3>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">
                    You have unsaved changes. Would you like to save before leaving?
                </p>
                <div class="mt-6 flex items-center justify-end gap-3">
                    <button @click="showUnsavedModal = false"
                        class="px-4 py-2 text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors duration-150">
                        Cancel
                    </button>
                    <a href="{{ route('dashboard', ['view' => 'forms']) }}"
                        @click="window.formBuilderAllowUnload = true"
                        class="px-4 py-2 text-sm font-medium border border-neutral-300 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors duration-150">
                        Leave Without Saving
                    </a>
                    <button
                        @click="$wire.saveForm().then(() => { window.location.href = '{{ route('dashboard', ['view' => 'forms']) }}' })"
                        class="px-4 py-2 text-sm font-medium bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 hover:opacity-90 transition-opacity duration-150">
                        Save & Leave
                    </button>
                </div>
            </div>
        </div>
    </template>

    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    {{-- LEFT PANEL — Field Palette                                        --}}
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    <aside
        class="w-72 shrink-0 bg-white dark:bg-neutral-950 border-r border-neutral-200 dark:border-neutral-800 flex flex-col overflow-hidden transition-colors duration-300">

        {{-- Panel Header --}}
        <div class="px-5 py-4 border-b border-neutral-200 dark:border-neutral-800">
            <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">
                Field Types
            </h3>
            <p class="text-[11px] text-neutral-400 dark:text-neutral-500 mt-1">Drag or click to add</p>
        </div>

        {{-- Field Type List --}}
        <div class="flex-1 overflow-y-auto px-3 py-3 space-y-4" id="field-palette">

            {{-- Basic Fields --}}
            <div>
                <p
                    class="text-[10px] font-semibold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 px-2 mb-2">
                    Input Fields
                </p>
                <div class="palette-group space-y-1">
                    @foreach ($this->fieldTypes as $ft)
                        @if ($ft['group'] === 'basic')
                            <div class="palette-item cursor-grab active:cursor-grabbing flex items-center gap-3 px-3 py-2.5 rounded-md border border-transparent hover:border-neutral-200 dark:hover:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-900/60 transition-all duration-150 group select-none"
                                data-type="{{ $ft['type'] }}" wire:click="addField('{{ $ft['type'] }}')">
                                <div
                                    class="w-8 h-8 rounded flex items-center justify-center bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-neutral-100 transition-colors duration-150">
                                    @include('livewire.partials.field-icon', ['icon' => $ft['icon']])
                                </div>
                                <span
                                    class="text-sm font-medium text-neutral-600 dark:text-neutral-300 group-hover:text-neutral-900 dark:group-hover:text-neutral-100 transition-colors duration-150">
                                    {{ $ft['label'] }}
                                </span>
                                <svg class="w-3.5 h-3.5 ml-auto opacity-0 group-hover:opacity-50 transition-opacity duration-150 text-neutral-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Choice Fields --}}
            <div>
                <p
                    class="text-[10px] font-semibold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 px-2 mb-2">
                    Choice Fields
                </p>
                <div class="palette-group space-y-1">
                    @foreach ($this->fieldTypes as $ft)
                        @if ($ft['group'] === 'choice')
                            <div class="palette-item cursor-grab active:cursor-grabbing flex items-center gap-3 px-3 py-2.5 rounded-md border border-transparent hover:border-neutral-200 dark:hover:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-900/60 transition-all duration-150 group select-none"
                                data-type="{{ $ft['type'] }}" wire:click="addField('{{ $ft['type'] }}')">
                                <div
                                    class="w-8 h-8 rounded flex items-center justify-center bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-neutral-100 transition-colors duration-150">
                                    @include('livewire.partials.field-icon', ['icon' => $ft['icon']])
                                </div>
                                <span
                                    class="text-sm font-medium text-neutral-600 dark:text-neutral-300 group-hover:text-neutral-900 dark:group-hover:text-neutral-100 transition-colors duration-150">
                                    {{ $ft['label'] }}
                                </span>
                                <svg class="w-3.5 h-3.5 ml-auto opacity-0 group-hover:opacity-50 transition-opacity duration-150 text-neutral-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Advanced Fields --}}
            <div>
                <p
                    class="text-[10px] font-semibold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 px-2 mb-2">
                    Advanced
                </p>
                <div class="palette-group space-y-1">
                    @foreach ($this->fieldTypes as $ft)
                        @if ($ft['group'] === 'advanced')
                            <div class="palette-item cursor-grab active:cursor-grabbing flex items-center gap-3 px-3 py-2.5 rounded-md border border-transparent hover:border-neutral-200 dark:hover:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-900/60 transition-all duration-150 group select-none"
                                data-type="{{ $ft['type'] }}" wire:click="addField('{{ $ft['type'] }}')">
                                <div
                                    class="w-8 h-8 rounded flex items-center justify-center bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-neutral-100 transition-colors duration-150">
                                    @include('livewire.partials.field-icon', ['icon' => $ft['icon']])
                                </div>
                                <span
                                    class="text-sm font-medium text-neutral-600 dark:text-neutral-300 group-hover:text-neutral-900 dark:group-hover:text-neutral-100 transition-colors duration-150">
                                    {{ $ft['label'] }}
                                </span>
                                <svg class="w-3.5 h-3.5 ml-auto opacity-0 group-hover:opacity-50 transition-opacity duration-150 text-neutral-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Layout Elements --}}
            <div>
                <p
                    class="text-[10px] font-semibold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 px-2 mb-2">
                    Layout
                </p>
                <div class="palette-group space-y-1">
                    @foreach ($this->fieldTypes as $ft)
                        @if ($ft['group'] === 'layout')
                            <div class="palette-item cursor-grab active:cursor-grabbing flex items-center gap-3 px-3 py-2.5 rounded-md border border-transparent hover:border-neutral-200 dark:hover:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-900/60 transition-all duration-150 group select-none"
                                data-type="{{ $ft['type'] }}" wire:click="addField('{{ $ft['type'] }}')">
                                <div
                                    class="w-8 h-8 rounded flex items-center justify-center bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-neutral-100 transition-colors duration-150">
                                    @include('livewire.partials.field-icon', ['icon' => $ft['icon']])
                                </div>
                                <span
                                    class="text-sm font-medium text-neutral-600 dark:text-neutral-300 group-hover:text-neutral-900 dark:group-hover:text-neutral-100 transition-colors duration-150">
                                    {{ $ft['label'] }}
                                </span>
                                <svg class="w-3.5 h-3.5 ml-auto opacity-0 group-hover:opacity-50 transition-opacity duration-150 text-neutral-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </aside>

    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    {{-- CENTER — Form Canvas                                              --}}
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col overflow-hidden bg-neutral-100 dark:bg-neutral-900/50"
        x-on:click.self="$wire.deselectField()">

        {{-- Top Bar --}}
        <div
            class="shrink-0 flex items-center justify-between px-6 py-3 bg-white dark:bg-neutral-950 border-b border-neutral-200 dark:border-neutral-800">
            <div class="flex items-center gap-3">
                <button
                    @click="@this.isDirty ? showUnsavedModal = true : window.location.href = '{{ route('dashboard', ['view' => 'forms']) }}'"
                    class="p-2 -ml-2 rounded hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <div class="h-5 w-px bg-neutral-200 dark:bg-neutral-700"></div>
                <span class="text-xs font-medium text-neutral-400 dark:text-neutral-500 uppercase tracking-wider">
                    Form Builder
                </span>
            </div>
            <div class="flex items-center gap-2">
                {{-- Field count badge --}}
                <span class="text-xs text-neutral-400 dark:text-neutral-500 tabular-nums">
                    {{ count($fields) }} {{ Str::plural('field', count($fields)) }}
                </span>
                <div class="h-5 w-px bg-neutral-200 dark:bg-neutral-700"></div>
                {{-- Save Button --}}
                <button wire:click="saveForm" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 text-sm font-medium bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 border-2 border-neutral-900 dark:border-neutral-100 transition-all duration-200 hover:bg-transparent dark:hover:bg-transparent hover:text-neutral-900 dark:hover:text-neutral-100 disabled:opacity-50">
                    <span wire:loading.remove wire:target="saveForm">Save Form</span>
                    <span wire:loading wire:target="saveForm">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                            </path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        {{-- Save notification --}}
        @if ($showSaveNotification)
            <div x-data="{ show: true }" x-init="setTimeout(() => {
                show = false;
                $wire.set('showSaveNotification', false)
            }, 3000)" x-show="show"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="mx-6 mt-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm">
                Form saved successfully.
            </div>
        @endif

        {{-- Canvas Scroll Area --}}
        <div class="flex-1 overflow-y-auto p-6" x-on:click.self="$wire.deselectField()">
            <div class="max-w-2xl mx-auto">

                {{-- Form Title & Description --}}
                <div
                    class="mb-6 bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 p-8 transition-colors duration-300">
                    <input type="text" wire:model.blur="title"
                        class="w-full text-2xl font-light tracking-tight bg-transparent border-0 border-b-2 border-transparent focus:border-neutral-300 dark:focus:border-neutral-600 focus:ring-0 px-0 pb-2 placeholder-neutral-300 dark:placeholder-neutral-600 transition-colors duration-200"
                        placeholder="Form Title">
                    <textarea wire:model.blur="description" rows="2"
                        class="w-full mt-3 text-sm font-light bg-transparent border-0 border-b-2 border-transparent focus:border-neutral-300 dark:focus:border-neutral-600 focus:ring-0 px-0 pb-2 placeholder-neutral-300 dark:placeholder-neutral-600 resize-none transition-colors duration-200 text-neutral-600 dark:text-neutral-400"
                        placeholder="Add a description for your form (optional)"></textarea>
                </div>

                {{-- Fields Drop Zone --}}
                <div id="form-canvas" class="space-y-3 min-h-50 relative">

                    @forelse ($fields as $index => $field)
                        <div class="canvas-field group relative" data-field-id="{{ $field['id'] }}"
                            wire:key="field-{{ $field['id'] }}">

                            {{-- Field Card --}}
                            <div class="relative bg-white dark:bg-neutral-950 border transition-all duration-200 cursor-pointer
                                {{ $activeFieldIndex === $index
                                    ? 'border-neutral-900 dark:border-neutral-100 shadow-[4px_4px_0_0_rgba(0,0,0,0.1)] dark:shadow-[4px_4px_0_0_rgba(255,255,255,0.05)]'
                                    : 'border-neutral-200 dark:border-neutral-800 hover:border-neutral-400 dark:hover:border-neutral-600' }}"
                                wire:click="selectField({{ $index }})">

                                {{-- Drag Handle --}}
                                <div
                                    class="drag-handle absolute left-0 top-0 bottom-0 w-8 flex items-center justify-center cursor-grab active:cursor-grabbing opacity-0 group-hover:opacity-100 transition-opacity duration-150 bg-neutral-50 dark:bg-neutral-900/50 border-r border-neutral-200 dark:border-neutral-800">
                                    <svg class="w-4 h-4 text-neutral-400" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="9" cy="6" r="1.5" />
                                        <circle cx="15" cy="6" r="1.5" />
                                        <circle cx="9" cy="12" r="1.5" />
                                        <circle cx="15" cy="12" r="1.5" />
                                        <circle cx="9" cy="18" r="1.5" />
                                        <circle cx="15" cy="18" r="1.5" />
                                    </svg>
                                </div>

                                {{-- Field Content Preview --}}
                                <div class="pl-8 pr-20 py-5 px-6">
                                    @include('livewire.partials.field-preview', ['field' => $field])
                                </div>

                                {{-- Action Buttons --}}
                                <div
                                    class="absolute right-3 top-3 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                    <button wire:click.stop="duplicateField({{ $index }})"
                                        class="p-1.5 rounded hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors duration-150"
                                        title="Duplicate">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                    <button wire:click.stop="removeField({{ $index }})"
                                        class="p-1.5 rounded hover:bg-red-50 dark:hover:bg-red-950/30 text-neutral-400 hover:text-red-500 transition-colors duration-150"
                                        title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- Active indicator --}}
                                @if ($activeFieldIndex === $index)
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-neutral-900 dark:bg-neutral-100">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        {{-- Empty State --}}
                        <div class="empty-canvas-state flex flex-col items-center justify-center py-20 border-2 border-dashed border-neutral-300 dark:border-neutral-700 rounded-sm bg-white/50 dark:bg-neutral-950/30"
                            id="empty-canvas-drop">
                            <div
                                class="w-16 h-16 mb-4 flex items-center justify-center rounded-full bg-neutral-100 dark:bg-neutral-800">
                                <svg class="w-8 h-8 text-neutral-400 dark:text-neutral-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <p class="text-neutral-500 dark:text-neutral-400 font-medium mb-1">Drop fields here</p>
                            <p class="text-sm text-neutral-400 dark:text-neutral-500">
                                Drag from the left panel or click to add fields
                            </p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    {{-- RIGHT PANEL — Field Properties                                    --}}
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    <aside
        class="w-80 shrink-0 bg-white dark:bg-neutral-950 border-l border-neutral-200 dark:border-neutral-800 flex flex-col overflow-hidden transition-all duration-300"
        x-show="$wire.activeFieldIndex !== null" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-full opacity-0" x-cloak>

        {{-- Properties Header --}}
        <div class="px-5 py-4 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between">
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">
                    Field Properties
                </h3>
                @if ($activeFieldIndex !== null && isset($fields[$activeFieldIndex]))
                    <p class="text-[11px] text-neutral-400 dark:text-neutral-500 mt-1 capitalize">
                        {{ $fields[$activeFieldIndex]['type'] ?? '' }} Field
                    </p>
                @endif
            </div>
            <button wire:click="deselectField"
                class="p-1.5 rounded hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Properties Form --}}
        @if ($activeFieldIndex !== null && isset($fields[$activeFieldIndex]))
            <div class="flex-1 overflow-y-auto p-5 space-y-5">

                {{-- Label --}}
                <div>
                    <label
                        class="block text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-1.5">
                        Label
                    </label>
                    <input type="text" wire:model.live.debounce.300ms="editLabel"
                        class="w-full px-3 py-2 text-sm bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:focus:ring-neutral-100/10 focus:border-neutral-400 dark:focus:border-neutral-500 transition-all duration-150">
                </div>

                {{-- Placeholder (not for layout types) --}}
                @if (!in_array($fields[$activeFieldIndex]['type'], ['heading', 'paragraph', 'divider', 'radio', 'checkbox']))
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-1.5">
                            Placeholder
                        </label>
                        <input type="text" wire:model.live.debounce.300ms="editPlaceholder"
                            class="w-full px-3 py-2 text-sm bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:focus:ring-neutral-100/10 focus:border-neutral-400 dark:focus:border-neutral-500 transition-all duration-150">
                    </div>
                @endif

                {{-- Options (for select, radio, checkbox) --}}
                @if (in_array($fields[$activeFieldIndex]['type'], ['select', 'radio', 'checkbox']))
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 mb-1.5">
                            Options <span class="font-normal normal-case tracking-normal">(one per line)</span>
                        </label>
                        <textarea wire:model.live.debounce.500ms="editOptions" rows="5"
                            class="w-full px-3 py-2 text-sm bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 dark:focus:ring-neutral-100/10 focus:border-neutral-400 dark:focus:border-neutral-500 transition-all duration-150 resize-none font-mono"
                            placeholder="Option 1&#10;Option 2&#10;Option 3"></textarea>
                    </div>
                @endif

                {{-- Required toggle (not for layout types) --}}
                @if (!in_array($fields[$activeFieldIndex]['type'], ['heading', 'paragraph', 'divider']))
                    <div
                        class="flex items-center justify-between py-3 border-t border-neutral-200 dark:border-neutral-800">
                        <label
                            class="text-xs font-semibold uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Required
                        </label>
                        <button wire:click="$toggle('editRequired')"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none
                                {{ $editRequired ? 'bg-neutral-900 dark:bg-neutral-100' : 'bg-neutral-200 dark:bg-neutral-700' }}">
                            <span
                                class="inline-block h-4 w-4 transform rounded-full bg-white dark:bg-neutral-900 transition-transform duration-200 shadow-sm
                                {{ $editRequired ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                    </div>
                @endif

                {{-- Danger Zone --}}
                <div class="pt-4 border-t border-neutral-200 dark:border-neutral-800">
                    <button wire:click="removeField({{ $activeFieldIndex }})"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-red-500 hover:text-white hover:bg-red-500 border border-red-200 dark:border-red-900/50 hover:border-red-500 rounded-sm transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Field
                    </button>
                </div>
            </div>
        @endif
    </aside>

    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    {{-- SORTABLE.JS — Drag & Drop Engine                                  --}}
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    @assets
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
        <style>
            .sortable-ghost {
                opacity: 0.2;
            }

            .sortable-drag {
                opacity: 1 !important;
                box-shadow: 0 12px 40px -8px rgba(0, 0, 0, 0.15);
            }
        </style>
    @endassets

    @script
        <script>
            const root = $wire.$el;
            let canvasSortable = null;
            let paletteInstances = [];

            function initPalette() {
                paletteInstances.forEach(s => {
                    try {
                        s.destroy();
                    } catch (e) {}
                });
                paletteInstances = [];

                root.querySelectorAll('.palette-group').forEach(group => {
                    const s = new Sortable(group, {
                        group: {
                            name: 'formfields',
                            pull: 'clone',
                            put: false
                        },
                        sort: false,
                        draggable: '.palette-item',
                        ghostClass: 'opacity-30',
                        animation: 150,
                    });
                    paletteInstances.push(s);
                });
            }

            function initCanvas() {
                const canvas = root.querySelector('#form-canvas');
                if (!canvas) return;

                if (canvasSortable) {
                    try {
                        canvasSortable.destroy();
                    } catch (e) {}
                    canvasSortable = null;
                }

                canvasSortable = new Sortable(canvas, {
                    group: {
                        name: 'formfields',
                        pull: false,
                        put: true
                    },
                    draggable: '.canvas-field',
                    handle: '.drag-handle',
                    filter: '.empty-canvas-state',
                    preventOnFilter: false,
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag',
                    animation: 200,

                    onEnd(evt) {
                        // Reorder existing fields
                        if (evt.from === canvas && evt.to === canvas && !evt.item.classList.contains('palette-item')) {
                            const ids = [...canvas.querySelectorAll('.canvas-field')]
                                .map(el => el.dataset.fieldId).filter(Boolean);
                            if (ids.length) $wire.reorderFields(ids);
                        }
                    },

                    onAdd(evt) {
                        const type = evt.item.dataset?.type;
                        const pos = evt.newIndex;
                        evt.item.remove();
                        if (type) $wire.fieldDropped(type, pos);
                    }
                });
            }

            // Boot
            initPalette();
            initCanvas();

            // Re-init after Livewire DOM updates
            Livewire.hook('morph.updated', ({
                el
            }) => {
                if (el === root || root.contains(el)) {
                    queueMicrotask(() => initCanvas());
                }
            });

            // Warn on browser back / tab close when dirty
            window.formBuilderAllowUnload = false;
            const beforeUnloadHandler = (e) => {
                if ($wire.isDirty && !window.formBuilderAllowUnload) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            };
            window.addEventListener('beforeunload', beforeUnloadHandler);

            // Clean up when component is destroyed
            document.addEventListener('livewire:navigating', () => {
                window.removeEventListener('beforeunload', beforeUnloadHandler);
            }, {
                once: true
            });
        </script>
    @endscript
</div>
