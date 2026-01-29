@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    @php
    $user = auth()->user();
    $photoUrl = $user->profilePhotoUrl();
    $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
    

    $initial = strtoupper(substr($user->name ?? 'U', 0, 1));

    $totalOrders   = $totalOrders   ?? 0;
    $pendingOrders = $pendingOrders ?? 0;
    $totalReviews  = $totalReviews  ?? 0;
    $recentOrders  = $recentOrders  ?? collect();
@endphp


<!-- Header -->
<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="p-8 lg:p-10 bg-gradient-to-r from-gray-900 to-gray-700 text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-4">
                <!-- Avatar -->
                <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center overflow-hidden border border-white/20">
                    @if($photoUrl)
                        <img src="{{ $photoUrl }}" class="w-full h-full object-cover" alt="Profile photo">
                    @else
                        <span class="text-xl font-bold">{{ $initial }}</span>
                    @endif
                </div>

                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight">Welcome, {{ $user->name }} 👋</h1>
                    <p class="text-white/80 mt-1 text-sm">
                        Manage your account, track orders, and keep your perfume reviews in one place.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('home') }}"
                   class="bg-white text-gray-900 font-semibold px-5 py-2.5 rounded-xl shadow hover:bg-gray-100 transition">
                    Go to Home
                </a>

                <a href="{{ route('shop.index') }}"
                   class="bg-white/10 border border-white/20 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-white/15 transition">
                    Browse Shop
                </a>

                @if($user->is_admin)
                    <a href="{{ route('admin.perfumes.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow transition">
                        Admin Panel
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="p-6 lg:p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-gray-50 border rounded-2xl p-5">
                <p class="text-sm text-gray-500">Total Orders</p>
                <p class="text-2xl font-extrabold mt-1">{{ $totalOrders }}</p>
                <p class="text-xs text-gray-500 mt-1">Order history</p>
            </div>

            <div class="bg-gray-50 border rounded-2xl p-5">
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="text-2xl font-extrabold mt-1">{{ $pendingOrders }}</p>
                <p class="text-xs text-gray-500 mt-1">Processing / shipping</p>
            </div>

            <div class="bg-gray-50 border rounded-2xl p-5">
                <p class="text-sm text-gray-500">My Reviews</p>
                <p class="text-2xl font-extrabold mt-1">{{ $totalReviews }}</p>
                <p class="text-xs text-gray-500 mt-1">Your perfume ratings</p>
            </div>

            <div class="bg-gray-50 border rounded-2xl p-5">
                <p class="text-sm text-gray-500">Account Status</p>
                <p class="text-lg font-bold mt-2">
                    {{ $user->is_admin ? 'Admin' : 'Customer' }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Signed in as {{ $user->email }}
                </p>
            </div>

        </div>
    </div>
</div>

<!-- Main Grid -->
<div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-6">

    <!-- Left: Profile -->
    <div class="lg:col-span-4 space-y-6">

        <!-- Profile Card (SINGLE) -->
        <div class="bg-white border rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-bold">Profile</h2>

            <div class="mt-4 flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 overflow-hidden flex items-center justify-center shrink-0">
                    @if($photoUrl)
                        <img src="{{ $photoUrl }}" class="w-full h-full object-cover" alt="Profile photo">
                    @else
                        <span class="text-2xl font-bold text-gray-700">{{ $initial }}</span>
                    @endif
                </div>

                <div class="min-w-0">
                    <p class="font-semibold truncate">{{ $user->name }}</p>
                    <p class="text-sm text-gray-600 truncate">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Flash message-->
            @if(session('success'))
                <div class="mt-4 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl p-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div class="mt-4 bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl p-3">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Update Profile Photo -->
            <div class="mt-6">
                <p class="text-sm font-semibold mb-2">Update Profile Photo</p>

                <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <input type="file" name="photo" class="w-full border rounded-xl px-4 py-2.5 text-sm bg-white" required>
                    <button class="w-full bg-gray-900 hover:bg-black text-white font-semibold px-4 py-2.5 rounded-xl shadow transition">
                        Save Photo
                    </button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="mt-7">
                <p class="text-sm font-semibold mb-2">Change Password</p>

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf

                    <div><input type="password" name="current_password" placeholder="Current password" class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"required></div>
                    <div><input type="password" name="password" placeholder="New password" class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"required></div>
                    <div><input type="password" name="password_confirmation" placeholder="Confirm new password" class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"required></div>

                    <button type="submit" class="w-full mt-2 bg-gray-900 hover:bg-black text-white font-semibold py-3 rounded-xl shadow transition">Update Password</button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white border rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-bold">Quick Actions</h2>
            <div class="mt-4 grid grid-cols-1 gap-3">
                <a href="{{ route('shop.index') }}"
                   class="border rounded-xl px-4 py-3 hover:bg-gray-50 transition">
                    <p class="font-semibold">Browse perfumes</p>
                    <p class="text-sm text-gray-600">Explore products & leave reviews</p>
                </a>

                <a href="{{ route('home') }}"
                   class="border rounded-xl px-4 py-3 hover:bg-gray-50 transition">
                    <p class="font-semibold">View featured</p>
                    <p class="text-sm text-gray-600">See what’s trending</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Right: Orders + Reviews -->
    <div class="lg:col-span-8 space-y-6">

        <!-- My Orders -->
        <div class="bg-white border rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">My Orders</h2>

                <a href="{{ route('orders.my') }}" class="text-sm text-gray-600 hover:underline">
                    View all
                </a>
            </div>

            @if($recentOrders->count() > 0)
                <div class="overflow-hidden rounded-xl border">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-gray-600">
                                <th class="px-4 py-3">Order</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($recentOrders as $order)
                                <tr class="bg-white">
                                    <td class="px-4 py-3 font-semibold">#{{ $order->id }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $badge = match($order->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'paid' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold">
                                        LKR {{ number_format($order->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-gray-50 border rounded-xl p-4 text-sm text-gray-700 text-center">
                    No orders yet. Start shopping to place your first order.
                </div>
            @endif

            <div class="mt-4 flex gap-3">
                <a href="{{ route('shop.index') }}"
                   class="bg-gray-900 hover:bg-black text-white font-semibold px-5 py-2.5 rounded-xl shadow transition">
                    Start Shopping
                </a>
                <button disabled
                        class="border border-gray-300 text-gray-500 font-semibold px-5 py-2.5 rounded-xl">
                    Track Order (coming soon)
                </button>
            </div>
        </div>

        <!-- My Reviews -->
        <div class="bg-white border rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold">My Reviews</h2>
                <a href="{{ route('shop.index') }}" class="text-sm underline text-gray-700 hover:text-gray-900">
                    Write a review
                </a>
            </div>

            @if(method_exists($user, 'reviews') && $user->reviews()->count() > 0)
                @php
                    $latestReviews = $user->reviews()->latest()->take(3)->get();
                @endphp

                <div class="mt-4 space-y-3">
                    @foreach($latestReviews as $review)
                        <div class="border rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold">Rating: {{ $review->rating }}/5</p>
                                <p class="text-xs text-gray-500">{{ $review->created_at?->format('d M Y') }}</p>
                            </div>

                            @if($review->comment)
                                <p class="text-sm text-gray-700 mt-2">{{ $review->comment }}</p>
                            @else
                                <p class="text-sm text-gray-400 mt-2 italic">No comment</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-4 bg-gray-50 border rounded-xl p-6 text-center text-gray-600">
                    You haven’t written any reviews yet.
                </div>
            @endif
        </div>

        <!-- 2 Step verification on off-->
        <div class="mt-6 border-t pt-6">
            <p class="text-sm font-semibold mb-2">2-Step Verification (Email OTP)</p>

            @php $enabled = auth()->user()->two_factor_enabled; @endphp

            @if($enabled)
                <div class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl p-3">
                    ✅ 2-step verification is ON
                </div>

                <form method="POST" action="{{ route('2fa.disable') }}" class="mt-3">
                    @csrf
                    <button class="w-full bg-gray-900 hover:bg-black text-white font-semibold py-3 rounded-xl">
                        Turn OFF
                    </button>
                </form>
            @else
                <div class="text-sm text-gray-700 bg-gray-50 border rounded-xl p-3">
                    Add extra protection: we send a code to your email during login.
                </div>

                <form method="POST" action="{{ route('2fa.enable') }}" class="mt-3">
                    @csrf
                    <button class="w-full bg-gray-900 hover:bg-black text-white font-semibold py-3 rounded-xl">
                        Turn ON
                    </button>
                </form>
            @endif
        </div>


        <!-- Suggestions -->
        <div class="bg-white border rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-bold">Recommended Next Steps</h2>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('shop.index') }}" class="border rounded-xl p-4 hover:bg-gray-50 transition">
                    <p class="font-semibold">Explore new arrivals</p>
                    <p class="text-sm text-gray-600 mt-1">Find your next signature scent</p>
                </a>
                <a href="{{ route('home') }}" class="border rounded-xl p-4 hover:bg-gray-50 transition">
                    <p class="font-semibold">Check featured perfumes</p>
                    <p class="text-sm text-gray-600 mt-1">Popular picks selected by admin</p>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
