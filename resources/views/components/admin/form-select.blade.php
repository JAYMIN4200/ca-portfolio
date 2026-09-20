@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'required' => false,
    'placeholder' => null,
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
    <select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }} data-custom-select
        {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 shadow-sm transition-colors focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 ' . ($errors->has($name) ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : '')]) }}>
        @if ($placeholder)
            <option value="" {{ old($name, $value) === null || old($name, $value) === '' ? 'selected' : '' }}>{{ $placeholder }}</option>
        @endif
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>