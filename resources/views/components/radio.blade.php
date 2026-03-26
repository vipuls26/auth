@props(['name', 'value', 'label', 'checked' => false])

<input type="radio" name="{{ $name }}" id="{{ $name . '-' . $value }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }} {{ $attributes }}
    class="peer h-5 w-5 cursor-pointer rounded-full border border-cyan-500 transition-all ml-4">
<label for="{{ $name . '-' . $value }}" class="relative flex items-center cursor-pointer ml-2">{{ $label }}</label>
