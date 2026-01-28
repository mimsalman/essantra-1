@extends('layouts.app')
@section('title','Cart')

@section('content')
<div class="bg-white border rounded-2xl shadow-sm p-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Your Cart</h1>
        <form method="POST" action="{{ route('cart.clear') }}">
            @csrf
            <button class="text-sm text-red-600 hover:underline">Clear Cart</button>
        </form>
    </div>

    @if(count($items) === 0)
        <div class="mt-6 bg-gray-50 border rounded-xl p-6 text-center text-gray-600">
            Your cart is empty.
        </div>
        <div class="mt-4">
            <a href="{{ route('shop.index') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-xl shadow hover:bg-black">
                Go to Shop
            </a>
        </div>
    @else
        <div class="mt-6 space-y-4">
            @foreach($items as $item)
                <div class="border rounded-xl p-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl bg-gray-100 overflow-hidden">
                            @if($item['image'])
                                <img src="{{ asset('storage/'.$item['image']) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-600">LKR {{ number_format($item['price'],2) }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <form method="POST" action="{{ route('cart.update', $item['id']) }}" class="flex items-center gap-2">
                            @csrf
                            <input type="number" name="qty" value="{{ $item['qty'] }}" min="1"
                                   class="w-20 border rounded-lg px-3 py-2">
                            <button class="border px-3 py-2 rounded-lg hover:bg-gray-50">Update</button>
                        </form>

                        <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                            @csrf
                            <button class="text-red-600 hover:underline">Remove</button>
                        </form>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-gray-500">Subtotal</p>
                        <p class="font-bold">LKR {{ number_format($item['subtotal'],2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center justify-between border-t pt-6">
            <p class="text-lg font-bold">Total: LKR {{ number_format($total,2) }}</p>
            <a href="{{ route('orders.checkout') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow">
                Checkout
            </a>
        </div>
    @endif
</div>
@endsection
