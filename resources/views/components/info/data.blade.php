@props(['title'])

<div>
    <div class="text-gray-500 text-xs">{{ $title }}</div>
    {{ $slot }}
</div>
