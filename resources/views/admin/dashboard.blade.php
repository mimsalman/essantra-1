@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')

<div class="relative">

    <!-- BG image-->
    <div class="fixed inset-0 -z-10">
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('images/perfume-bg3.jpg') }}');">
        </div>

        <!-- overlay contrast-->
        <!--<div class="absolute inset-0 bg-white/20"></div>-->
    </div>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-4xl font-extrabold tracking-tight text-white">Admin Dashboard</h1>
                @php
            $tabClass = "inline-flex items-center gap-2 px-4 py-2 rounded-xl border text-sm font-semibold transition";
            $activeClass = "bg-gray-900 text-white border-gray-900";
            $inactiveClass = "bg-white text-gray-700 hover:bg-gray-50";
        @endphp

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.users.index') }}"
            class="{{ $tabClass }} {{ request()->routeIs('admin.users.*') ? $activeClass : $inactiveClass }}">
                <!-- Users Icon -->
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
                <!-- Orders Icon -->
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <path d="M9 5a3 3 0 0 1 6 0"/>
                    <path d="M9 12h6M9 16h6"/>
                </svg>
                Orders
            </a>

            <a href="{{ route('admin.perfumes.index') }}"
            class="{{ $tabClass }} {{ request()->routeIs('admin.perfumes.*') ? $activeClass : $inactiveClass }}">
                <!-- Perfume Icon -->
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 3h6"/>
                    <path d="M10 3v4l-3 3v11h10V10l-3-3V3"/>
                    <path d="M9 14h6"/>
                </svg>
                Perfumes
            </a>
        </div>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border rounded-2xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Registered Users</p>
            <p class="text-3xl font-extrabold mt-2">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white border rounded-2xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Orders</p>
            <p class="text-3xl font-extrabold mt-2">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white border rounded-2xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Pending Orders</p>
            <p class="text-3xl font-extrabold mt-2">{{ $pendingOrders }}</p>
        </div>

        <div class="bg-white border rounded-2xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Revenue</p>
            <p class="text-3xl font-extrabold mt-2">LKR {{ number_format($revenue, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white border rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">Recent Orders</h2>
                <a class="text-sm text-gray-600 hover:underline" href="{{ route('admin.orders.index') }}">View all</a>
            </div>

            <div class="overflow-hidden rounded-xl border">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-gray-600">
                            <th class="px-4 py-3">Order</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($recentOrders as $o)
                            <tr>
                                <td class="px-4 py-3 font-semibold">
                                    <a class="hover:underline" href="{{ route('admin.orders.show',$o) }}">#{{ $o->id }}</a>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $o->user->name ?? 'User' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100">
                                        {{ ucfirst($o->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold">
                                    LKR {{ number_format($o->total,2) }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white border rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">Low Stock Alerts</h2>
                <a class="text-sm text-gray-600 hover:underline" href="{{ route('admin.perfumes.index') }}">Manage</a>
            </div>

            <div class="space-y-3">
                @forelse($lowStock as $p)
                    <div class="border rounded-xl p-4 flex items-center justify-between">
                        <div>
                            <p class="font-semibold">{{ $p->name }}</p>
                            <p class="text-sm text-gray-600">{{ $p->brand }} • {{ $p->category }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                            Stock: {{ $p->stock }}
                        </span>
                    </div>
                @empty
                    <div class="text-sm text-gray-600 bg-gray-50 border rounded-xl p-4 text-center">
                        No low stock perfumes 🎉
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
