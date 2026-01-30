@extends('layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Admin Profile</h1>
        <p class="text-gray-600">Manage your password and 2-step verification.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">

        {{-- Change Password --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Change Password</h2>

            <form method="POST" action="{{ url('user/password') }}">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password"
                               class="w-full mt-1 rounded-xl border-gray-300 focus:ring-black focus:border-black"
                               required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password"
                               class="w-full mt-1 rounded-xl border-gray-300 focus:ring-black focus:border-black"
                               required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full mt-1 rounded-xl border-gray-300 focus:ring-black focus:border-black"
                               required>
                    </div>

                    <button class="w-full mt-2 bg-gray-900 text-white py-2.5 rounded-xl hover:bg-gray-800">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        {{-- Two Factor Auth (Jetstream/Fortify) --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-2">2-Step Verification</h2>
            <p class="text-sm text-gray-600 mb-4">
                Protect your admin account using an authenticator app (Google Authenticator etc.).
            </p>

            @php
                $enabled = !empty(auth()->user()->two_factor_secret);
            @endphp

            @if(!$enabled)
                <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                    @csrf
                    <button class="w-full bg-gray-900 text-white py-2.5 rounded-xl hover:bg-gray-800">
                        Enable 2-Step Verification
                    </button>
                </form>
            @else
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-3 mb-4 text-sm">
                    2-Step Verification is currently <b>Enabled</b>.
                </div>

                {{-- Show QR code + secret --}}
                <div class="space-y-3 mb-4">
                    <form method="GET" action="{{ url('user/two-factor-qr-code') }}">
                        <button class="w-full border border-gray-300 py-2.5 rounded-xl hover:bg-gray-50">
                            View QR Code
                        </button>
                    </form>

                    <form method="GET" action="{{ url('user/two-factor-secret-key') }}">
                        <button class="w-full border border-gray-300 py-2.5 rounded-xl hover:bg-gray-50">
                            View Secret Key
                        </button>
                    </form>

                    <form method="GET" action="{{ url('user/two-factor-recovery-codes') }}">
                        <button class="w-full border border-gray-300 py-2.5 rounded-xl hover:bg-gray-50">
                            View Recovery Codes
                        </button>
                    </form>

                    <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
                        @csrf
                        <button class="w-full border border-gray-300 py-2.5 rounded-xl hover:bg-gray-50">
                            Regenerate Recovery Codes
                        </button>
                    </form>
                </div>

                {{-- Disable --}}
                <form method="POST" action="{{ url('user/two-factor-authentication') }}"
                      onsubmit="return confirm('Disable 2-step verification?')">
                    @csrf
                    @method('DELETE')

                    <button class="w-full bg-red-600 text-white py-2.5 rounded-xl hover:bg-red-700">
                        Disable 2-Step Verification
                    </button>
                </form>
            @endif
        </div>

    </div>
</div>
@endsection