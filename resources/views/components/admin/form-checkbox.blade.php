@props([
    'name',
    'label' => null,
    'checked' => false,
])

<div class="flex items-start gap-3">
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1"
        {{ old($name, $checked ? '1' : '0') ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'mt-0.5 h-4 w-4 rounded border-slate-300 text-navy-600 focus:ring-navy-500']) }}>
    @if ($label)
        <label for="{{ $name }}" class="text-sm text-slate-700">{{ $label }}</label>
    @endif
</div>