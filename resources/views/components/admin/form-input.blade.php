@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'help' => null,
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
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        placeholder="{{ $placeholder }}"
        @if ($type === 'number') min="{{ $attributes->get('min') }}" max="{{ $attributes->get('max') }}" @endif
        @if ($type === 'date' || $type === 'time') data-custom-picker="{{ $type }}" @endif
        @if (str_contains($name, 'phone') || str_contains($name, 'whatsapp')) maxlength="15" inputmode="tel" @endif
        {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 shadow-sm transition-colors placeholder:text-slate-400 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 ' . ($errors->has($name) ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : '')]) }}
        autocomplete="off">
    @error($name)
        <p class="field-error">{{ $message }}</p>
    @enderror
    @if ($help)
        <p class="mt-1.5 text-xs text-slate-500">{{ $help }}</p>
    @endif
</div>