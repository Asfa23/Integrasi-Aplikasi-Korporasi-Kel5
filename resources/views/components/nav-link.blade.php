@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-5 pt-5 bg-[#7B4F85] border-indigo-400 text-sm text-white font-medium transition duration-150 ease-in-out rounded-[2vw]'
            : 'inline-flex items-center px-5 pt-5 border-indigo-400 text-sm text-white font-medium transition duration-150 ease-in-out rounded-[2vw] hover:bg-white hover:text-black';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
