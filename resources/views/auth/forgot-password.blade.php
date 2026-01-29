@extends('layouts.app')
@section('title','Forgot Password')

@section('content')
@php
  $bg = asset('images/perfume-bg1.jpg'); // put image at public/images/perfume-bg.jpg
@endphp

<div class="min-h-[calc(100vh-80px)] flex items-center justify-center px-4 py-10">
  <div class="w-full max-w-5xl overflow-hidden rounded-3xl border shadow-sm bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-2">

      <!-- Left: image -->
      <div class="relative hidden lg:block">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ $bg }}');"></div>
        <div class="absolute inset-0 bg-black/55"></div>
        <div class="relative p-10 text-white">
          <h1 class="text-4xl font-extrabold tracking-tight">Forgot Password?</h1>
          <p class="mt-3 text-white/85">
            Enter your email and we’ll send you a password reset link.
          </p>
        </div>
      </div>

      <!-- Right: form -->
      <div class="p-8 lg:p-10">
        <h2 class="text-2xl font-extrabold tracking-tight">Reset link</h2>
        <p class="mt-1 text-gray-600">We will send a reset link to your email.</p>

        @if (session('status'))
          <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('status') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc ml-5 space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
          @csrf

          <div>
            <label class="text-sm font-semibold">Email</label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              class="mt-1 w-full rounded-xl border px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"
              placeholder="you@example.com"
              required
              autofocus
            />
          </div>

          <button
            type="submit"
            class="w-full rounded-xl bg-gray-900 py-3 font-semibold text-white shadow hover:bg-black transition"
          >
            Email Password Reset Link
          </button>

          <div class="text-center text-sm text-gray-600">
            Back to
            <a class="font-semibold text-gray-900 hover:underline" href="{{ route('login') }}">Login</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
