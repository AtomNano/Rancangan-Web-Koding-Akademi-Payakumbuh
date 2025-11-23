@props(['active'])

@php
$classes = ($active ?? false)
            ? 'group flex items-center px-4 py-3 text-sm font-medium rounded-lg text-white bg-white/10 backdrop-blur-sm shadow-lg shadow-white/5 border border-white/10 transition-all duration-200 ease-in-out'
            : 'group flex items-center px-4 py-3 text-sm font-medium rounded-lg text-slate-300 hover:text-white hover:bg-white/5 hover:backdrop-blur-sm transition-all duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}
   @click="if (window.innerWidth < 768) { sidebarOpen = false; }">
    {{ $slot }}
</a>
