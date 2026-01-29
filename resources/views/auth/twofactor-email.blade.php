@extends('layouts.app')
@section('title','Verify Login')

@section('content')
<div class="max-w-lg mx-auto bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="p-8 bg-gray-900 text-white">
        <h1 class="text-3xl font-bold">2-step verification</h1>
        <p class="mt-2 text-white/80">
            We will send a 6-digit code to your email. Enter it to continue.
        </p>
    </div>

    <div class="p-8">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.send') }}">
            @csrf
            <button class="w-full bg-gray-900 hover:bg-black text-white font-semibold py-3 rounded-xl">
                Send Code to Email
            </button>
        </form>

        <form method="POST" action="{{ route('2fa.verify') }}" class="mt-6 space-y-3">
            @csrf

            <label class="text-sm font-semibold">Enter 6-digit code</label>
            <input name="otp" inputmode="numeric" maxlength="6"
                   class="w-full border rounded-xl px-4 py-3"
                   placeholder="123456" required>

            @error('otp')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror

            <button class="w-full border border-gray-300 hover:bg-gray-50 text-gray-900 font-semibold py-3 rounded-xl">
                Verify & Continue
            </button>
        </form>

        <p class="text-xs text-gray-500 mt-5">
            Didn’t get the code? Click “Send Code” again.
        </p>
    </div>
</div>
@endsection
