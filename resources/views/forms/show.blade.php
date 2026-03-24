@extends('layouts.app')

@section('title', $form->title . ' - Form Generator')

@section('content')
    <main class="min-h-screen py-16 px-4">
        <div class="max-w-2xl mx-auto">

            {{-- Form header --}}
            <div class="mb-10">
                <h1 class="text-3xl font-semibold tracking-tight mb-3">{{ $form->title }}</h1>
                @if ($form->description)
                    <p class="text-neutral-600 dark:text-neutral-400 text-base leading-relaxed">{{ $form->description }}</p>
                @endif
            </div>

            {{-- Success state --}}
            @if (session('success'))
                <div
                    class="rounded border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-950 px-6 py-5 text-green-800 dark:text-green-300 text-sm">
                    {{ session('success') }}
                </div>
            @else
                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="mb-6 rounded border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950 px-6 py-4">
                        <p class="text-sm font-medium text-red-800 dark:text-red-300 mb-2">Please fix the following errors:
                        </p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-700 dark:text-red-400">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('forms.submit', $form->slug) }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    <input type="text" name="_hp_website" tabindex="-1" autocomplete="off" class="hidden"
                        aria-hidden="true">
                    <input type="hidden" name="_hp_time"
                        value="{{ \Illuminate\Support\Facades\Crypt::encryptString((string) now()->timestamp) }}">

                    @foreach ($form->getFields() as $field)
                        @php $fieldId = 'field_' . $field['id']; @endphp

                        {{-- Layout elements --}}
                        @if ($field['type'] === 'heading')
                            <h2 class="text-xl font-semibold pt-2">{{ $field['label'] }}</h2>
                        @elseif ($field['type'] === 'paragraph')
                            <p class="text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed">{{ $field['label'] }}
                            </p>
                        @elseif ($field['type'] === 'divider')
                            <hr class="border-neutral-200 dark:border-neutral-800">

                            {{-- Input fields --}}
                        @elseif (in_array($field['type'], ['text', 'email', 'number', 'date', 'url']))
                            <div>
                                <label for="{{ $fieldId }}" class="block text-sm font-medium mb-1.5">
                                    {{ $field['label'] }}
                                    @if ($field['required'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <input type="{{ $field['type'] }}" id="{{ $fieldId }}" name="{{ $field['id'] }}"
                                    placeholder="{{ $field['placeholder'] ?? '' }}"
                                    @if ($field['required']) required @endif value="{{ old($field['id']) }}"
                                    class="w-full px-3.5 py-2.5 text-sm rounded border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 placeholder-neutral-400 dark:placeholder-neutral-600 focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 focus:border-transparent transition @error($field['id']) border-red-400 dark:border-red-600 @enderror">
                                @error($field['id'])
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif ($field['type'] === 'phone')
                            <div>
                                <label for="{{ $fieldId }}" class="block text-sm font-medium mb-1.5">
                                    {{ $field['label'] }}
                                    @if ($field['required'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <input type="tel" id="{{ $fieldId }}" name="{{ $field['id'] }}"
                                    placeholder="{{ $field['placeholder'] ?? '' }}"
                                    @if ($field['required']) required @endif value="{{ old($field['id']) }}"
                                    class="w-full px-3.5 py-2.5 text-sm rounded border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 placeholder-neutral-400 dark:placeholder-neutral-600 focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 focus:border-transparent transition @error($field['id']) border-red-400 dark:border-red-600 @enderror">
                                @error($field['id'])
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif ($field['type'] === 'textarea')
                            <div>
                                <label for="{{ $fieldId }}" class="block text-sm font-medium mb-1.5">
                                    {{ $field['label'] }}
                                    @if ($field['required'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <textarea id="{{ $fieldId }}" name="{{ $field['id'] }}" placeholder="{{ $field['placeholder'] ?? '' }}"
                                    @if ($field['required']) required @endif rows="4"
                                    class="w-full px-3.5 py-2.5 text-sm rounded border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 placeholder-neutral-400 dark:placeholder-neutral-600 focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 focus:border-transparent resize-y transition @error($field['id']) border-red-400 dark:border-red-600 @enderror">{{ old($field['id']) }}</textarea>
                                @error($field['id'])
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif ($field['type'] === 'select')
                            <div>
                                <label for="{{ $fieldId }}" class="block text-sm font-medium mb-1.5">
                                    {{ $field['label'] }}
                                    @if ($field['required'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <select id="{{ $fieldId }}" name="{{ $field['id'] }}"
                                    @if ($field['required']) required @endif
                                    class="w-full px-3.5 py-2.5 text-sm rounded border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900 dark:focus:ring-neutral-100 focus:border-transparent transition @error($field['id']) border-red-400 dark:border-red-600 @enderror">
                                    <option value="">{{ $field['placeholder'] ?? 'Select an option' }}</option>
                                    @foreach (array_filter(array_map('trim', is_array($field['options'] ?? '') ? $field['options'] ?? [] : explode("\n", $field['options'] ?? ''))) as $option)
                                        <option value="{{ $option }}" @selected(old($field['id']) === $option)>
                                            {{ $option }}</option>
                                    @endforeach
                                </select>
                                @error($field['id'])
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif ($field['type'] === 'radio')
                            <div>
                                <fieldset>
                                    <legend class="block text-sm font-medium mb-2">
                                        {{ $field['label'] }}
                                        @if ($field['required'])
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </legend>
                                    <div class="space-y-2">
                                        @foreach (array_filter(array_map('trim', is_array($field['options'] ?? '') ? $field['options'] ?? [] : explode("\n", $field['options'] ?? ''))) as $option)
                                            <label class="flex items-center gap-2.5 cursor-pointer">
                                                <input type="radio" name="{{ $field['id'] }}"
                                                    value="{{ $option }}"
                                                    @if ($field['required']) required @endif
                                                    @checked(old($field['id']) === $option)
                                                    class="accent-neutral-900 dark:accent-neutral-100">
                                                <span class="text-sm">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </fieldset>
                                @error($field['id'])
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif ($field['type'] === 'checkbox')
                            <div>
                                <fieldset>
                                    <legend class="block text-sm font-medium mb-2">
                                        {{ $field['label'] }}
                                        @if ($field['required'])
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </legend>
                                    <div class="space-y-2">
                                        @foreach (array_filter(array_map('trim', is_array($field['options'] ?? '') ? $field['options'] ?? [] : explode("\n", $field['options'] ?? ''))) as $option)
                                            <label class="flex items-center gap-2.5 cursor-pointer">
                                                <input type="checkbox" name="{{ $field['id'] }}[]"
                                                    value="{{ $option }}" @checked(in_array($option, (array) old($field['id'], [])))
                                                    class="accent-neutral-900 dark:accent-neutral-100">
                                                <span class="text-sm">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </fieldset>
                                @error($field['id'])
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif ($field['type'] === 'file')
                            <div>
                                <label for="{{ $fieldId }}" class="block text-sm font-medium mb-1.5">
                                    {{ $field['label'] }}
                                    @if ($field['required'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <input type="file" id="{{ $fieldId }}" name="{{ $field['id'] }}"
                                    @if ($field['required']) required @endif
                                    class="w-full text-sm text-neutral-600 dark:text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border file:border-neutral-200 dark:file:border-neutral-700 file:text-sm file:font-medium file:bg-white dark:file:bg-neutral-900 file:text-neutral-700 dark:file:text-neutral-300 hover:file:bg-neutral-50 dark:hover:file:bg-neutral-800 file:transition @error($field['id']) border-red-400 @enderror">
                                @error($field['id'])
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    @endforeach

                    {{-- Submit --}}
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full sm:w-auto px-8 py-3 bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 text-sm font-medium rounded hover:opacity-90 transition-opacity">
                            Submit
                        </button>
                    </div>
                </form>

            @endif

        </div>
    </main>
@endsection
