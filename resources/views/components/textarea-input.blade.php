{{-- resources/views/components/textarea.blade.php --}}
@props(['name', 'value' => '', 'attributes' => ''])

<textarea name='{{ $name }}' id='{{ $name }}' {{ $attributes }} class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 w-full mt-1 p-2 border rounded" rows="4">{{ $value }}</textarea>
