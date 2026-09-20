@props([
    'name',
    'label' => null,
    'required' => false,
    'accept' => null,
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    <div class="flex flex-col gap-3">
        <div class="flex cursor-pointer items-center gap-3 rounded-lg border border-dashed border-slate-300 bg-slate-50 px-3 py-3 transition-colors hover:border-navy-400 hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0 text-slate-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            <span class="text-xs text-slate-500">Choose a file to upload</span>
            <input type="file" name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}
                accept="{{ $accept }}"
                class="preview-image-input block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-navy-900 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-navy-800"
                data-preview-target="{{ $name }}_preview" {{ $attributes->merge(['class' => '']) }}>
        </div>
        <div id="{{ $name }}_preview" class="{{ str_contains($accept ?? '', 'image') ? 'hidden' : 'hidden' }}">
            <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-2">
                <img class="h-16 w-16 rounded-lg object-cover" src="" alt="Preview">
                <span class="text-xs text-slate-500">Current selection</span>
            </div>
        </div>
    </div>
    @error($name)
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>