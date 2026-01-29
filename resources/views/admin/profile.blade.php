@extends('layouts.app')
@section('title','Admin Profile')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <h1 class="text-3xl font-bold tracking-tight">Admin Profile</h1>
        <p class="text-gray-600 mt-1">Manage your account security.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border rounded-2xl shadow-sm p-6 space-y-8">

        {{-- 2FA --}}
        <div>
            <h2 class="text-lg font-semibold">2-Step Verification</h2>
            <p class="text-sm text-gray-500 mt-1">Extra security with email OTP.</p>

            <div class="mt-4 flex items-center justify-between gap-3">
                <div>
                    <p class="font-medium">
                        Status:
                        @if(auth()->user()->two_factor_enabled)
                            <span class="text-green-600">Enabled</span>
                        @else
                            <span class="text-gray-500">Disabled</span>
                        @endif
                    </p>
                </div>

                <div class="flex gap-2">
                    @if(!auth()->user()->two_factor_enabled)
                        <form method="POST" action="{{ route('admin.profile.2fa.enable') }}">
                            @csrf
                            <button class="px-4 py-2 rounded-xl bg-gray-900 text-white hover:bg-gray-800">
                                Enable
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.profile.2fa.disable') }}">
                            @csrf
                            <button class="px-4 py-2 rounded-xl bg-gray-100 border hover:bg-gray-200">
                                Disable
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <hr>

        {{-- Change Password --}}
        <div>
            <h2 class="text-lg font-semibold">Change Password</h2>
            <p class="text-sm text-gray-500 mt-1">Use a strong password (min 8 characters).</p>

            <form method="POST" action="{{ route('admin.profile.password') }}" class="mt-4 space-y-3">
                @csrf

                <input type="password" name="current_password" placeholder="Current password"
                    class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10" required>

                <input type="password" name="password" placeholder="New password"
                    class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10" required>

                <input type="password" name="password_confirmation" placeholder="Confirm new password"
                    class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10" required>

                <button class="w-full bg-gray-900 text-white font-semibold py-3 rounded-xl hover:bg-gray-800 transition">
                    Update Password
                </button>
            </form>
        </div>

    </div>
</div>
@endsection