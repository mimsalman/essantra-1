@extends('layouts.app')
@section('title','Checkout')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold tracking-tight">Checkout</h1>
    <p class="text-gray-600 mt-1">Enter delivery details and choose a payment method.</p>
</div>

@php
    $items = [];
    $subtotal = 0;

    foreach ($cart as $id => $row) {
        $line = $row['price'] * $row['qty'];
        $subtotal += $line;
        $items[] = ['id'=>$id] + $row + ['line'=>$line];
    }

    $deliveryFee = 0; // you can change later
    $total = $subtotal + $deliveryFee;
@endphp

<form method="POST" action="{{ route('orders.place') }}">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    <!-- LEFT: Form -->
    <div class="lg:col-span-7">
        <div class="bg-white border rounded-2xl shadow-sm p-6 space-y-6">

            <!-- Delivery Details -->
            <div>
                <h2 class="text-lg font-semibold">Delivery Details</h2>
                <p class="text-sm text-gray-500 mt-1">We’ll deliver to this address.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Full Name</label>
                        <input name="full_name" value="{{ old('full_name', auth()->user()->name ?? '') }}"
                               class="mt-1 w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"
                               placeholder="Your full name" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Phone</label>
                        <input name="phone" value="{{ old('phone') }}"
                               class="mt-1 w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"
                               placeholder="+94 77 123 4567" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Address Line 1</label>
                        <input name="address_line1" value="{{ old('address_line1') }}"
                               class="mt-1 w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"
                               placeholder="House No, Street, Area" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Address Line 2 (optional)</label>
                        <input name="address_line2" value="{{ old('address_line2') }}"
                               class="mt-1 w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"
                               placeholder="Apartment, Landmark, etc.">
                    </div>

                    <div>
                        <label class="text-sm font-medium">City</label>
                        <input name="city" value="{{ old('city') }}"
                               class="mt-1 w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"
                               placeholder="Kandy / Colombo" required>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Postal Code</label>
                        <input name="postal_code" value="{{ old('postal_code') }}"
                               class="mt-1 w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10"
                               placeholder="20000" required>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="border-t pt-6">
                <h2 class="text-lg font-semibold">Payment Method</h2>
                <p class="text-sm text-gray-500 mt-1">Choose how you want to pay.</p>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Card -->
                    <label class="border rounded-2xl p-4 cursor-pointer hover:bg-gray-50 transition flex gap-3 items-start">
                        <input type="radio" name="payment_method" value="card" class="mt-1"
                               {{ old('payment_method','cod') === 'card' ? 'checked' : '' }}>
                        <div>
                            <p class="font-semibold">Credit / Debit Card</p>
                            <p class="text-sm text-gray-500">Pay with card.</p>
                        </div>
                    </label>

                    <!-- COD -->
                    <label class="border rounded-2xl p-4 cursor-pointer hover:bg-gray-50 transition flex gap-3 items-start">
                        <input type="radio" name="payment_method" value="cod" class="mt-1"
                               {{ old('payment_method','cod') === 'cod' ? 'checked' : '' }}>
                        <div>
                            <p class="font-semibold">Cash on Delivery</p>
                            <p class="text-sm text-gray-500">Pay when you receive.</p>
                        </div>
                    </label>
                </div>

                <!-- Card Fields (toggle) -->
                <div id="cardFields" class="mt-5 border rounded-2xl p-5 bg-gray-50 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Name on Card</label>
                            <input id="card_name" name="card_name" type="text"
                                placeholder="Name on card"
                                autocomplete="cc-name"
                                class="w-full border rounded-xl px-4 py-3" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Card Number</label>
                            <input id="card_number" name="card_number" type="text"
                                inputmode="numeric"
                                autocomplete="cc-number"
                                placeholder="1234 5678 9012 3456"
                                maxlength="19"
                                class="w-full border rounded-xl px-4 py-3" />
                        </div>

                        <div>
                            <label class="text-sm font-medium">Expiry</label>
                            <input id="card_expiry" name="card_expiry" type="text"
                                inputmode="numeric"
                                autocomplete="cc-exp"
                                placeholder="MM/YY"
                                maxlength="5"
                                class="w-full border rounded-xl px-4 py-3" />
                        </div>

                        <div>
                            <label class="text-sm font-medium">CVC</label>
                            <input id="card_cvc" name="card_cvc" type="text"
                                inputmode="numeric"
                                autocomplete="cc-csc"
                                placeholder="123"
                                maxlength="4"
                                class="w-full border rounded-xl px-4 py-3" />
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- RIGHT: Summary -->
    <div class="lg:col-span-5">
        <div class="bg-gray-900 text-white rounded-2xl shadow-lg p-6 sticky top-6">
            <h2 class="text-lg font-semibold">Summary</h2>

            <div class="mt-5 space-y-4">
                @foreach($items as $item)
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/10 overflow-hidden">
                                @if(!empty($item['image']))
                                    <img src="{{ asset('storage/'.$item['image']) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-sm">{{ $item['name'] }}</p>
                                <p class="text-xs text-white/70">Qty: {{ $item['qty'] }}</p>
                            </div>
                        </div>
                        <p class="font-semibold text-sm">LKR {{ number_format($item['line'],2) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 border-t border-white/15 pt-5 space-y-2 text-sm">
                <div class="flex justify-between text-white/80">
                    <span>Subtotal</span>
                    <span>LKR {{ number_format($subtotal,2) }}</span>
                </div>
                <div class="flex justify-between text-white/80">
                    <span>Delivery</span>
                    <span>{{ $deliveryFee == 0 ? 'Free' : 'LKR '.number_format($deliveryFee,2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold mt-3">
                    <span>Total</span>
                    <span>LKR {{ number_format($total,2) }}</span>
                </div>
            </div>

            <button class="mt-6 w-full bg-white text-gray-900 font-semibold py-3 rounded-xl hover:bg-gray-100 transition">
                Place Order
            </button>

            <a href="{{ route('cart.index') }}" class="block mt-3 text-center text-sm text-white/80 hover:text-white underline">
                Back to Cart
            </a>
        </div>
    </div>

</div>
</form>

<script>
    function toggleCardFields() {
        const selected = document.querySelector('input[name="payment_method"]:checked')?.value;
        const cardFields = document.getElementById('cardFields');
        if (!cardFields) return;

        if (selected === 'card') {
            cardFields.classList.remove('hidden');
        } else {
            cardFields.classList.add('hidden');
        }
    }

    document.querySelectorAll('input[name="payment_method"]').forEach(r => {
        r.addEventListener('change', toggleCardFields);
    });

    toggleCardFields();
</script>
@endsection
