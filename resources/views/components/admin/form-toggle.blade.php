@props([
    'name',
    'label' => null,
    'help' => null,
    'checked' => false,
])

<div class="flex items-start gap-3">
    <input type="hidden" name="{{ $name }}" value="0">
    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1"
            class="peer sr-only"
            {{ old($name, $checked ? '1' : '0') ? 'checked' : '' }}
            {{ $attributes->merge([]) }}>
        <span class="h-6 w-11 rounded-full bg-slate-300 transition-colors peer-checked:bg-green-500! peer-focus-visible:ring-2 peer-focus-visible:ring-green-500! peer-focus-visible:ring-offset-2"></span>
        <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-5"></span>
    </label>
    @if ($label || $help)
        <div class="min-w-0">
            @if ($label)
                <label for="{{ $name }}" class="block cursor-pointer text-sm font-medium text-slate-700">{{ $label }}</label>
            @endif
            @if ($help)
                <p class="mt-0.5 text-xs text-slate-500">{{ $help }}</p>
            @endif
        </div>
    @endif
</div>
