@php
    $tabClass = "inline-flex items-center gap-2 px-4 py-2 rounded-xl border text-sm font-semibold transition";
    $activeClass = "bg-gray-900 text-white border-gray-900";
    $inactiveClass = "bg-white text-gray-700 hover:bg-gray-50";
@endphp

<div class="flex flex-wrap gap-2">
    <a href="{{ route('admin.users.index') }}"
       class="{{ $tabClass }} {{ request()->routeIs('admin.users.*') ? $activeClass : $inactiveClass }}">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Users
    </a>

    <a href="{{ route('admin.orders.index') }}"
       class="{{ $tabClass }} {{ request()->routeIs('admin.orders.*') ? $activeClass : $inactiveClass }}">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 5H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
            <path d="M9 5a3 3 0 0 1 6 0"/>
            <path d="M9 12h6M9 16h6"/>
        </svg>
        Orders
    </a>

    <a href="{{ route('admin.perfumes.index') }}"
       class="{{ $tabClass }} {{ request()->routeIs('admin.perfumes.*') ? $activeClass : $inactiveClass }}">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 3h6"/>
            <path d="M10 3v4l-3 3v11h10V10l-3-3V3"/>
            <path d="M9 14h6"/>
        </svg>
        Perfumes
    </a>
</div>
