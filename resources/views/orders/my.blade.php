@extends('layouts.app')
@section('title','My Orders')

@section('content')
<div class="bg-white border rounded-2xl shadow-sm p-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">My Orders</h1>
        <a href="{{ route('shop.index') }}" class="text-sm underline">Continue Shopping</a>
    </div>

    @if($orders->count() === 0)
        <div class="mt-6 bg-gray-50 border rounded-xl p-6 text-center text-gray-600">
            You have no orders yet.
        </div>
    @else
        <div class="mt-6 space-y-4">
            @foreach($orders as $order)
                <div class="border rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-bold">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-semibold">{{ ucfirst($order->status) }}</p>
                            <p class="font-bold mt-1">LKR {{ number_format($order->total,2) }}</p>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between text-sm">
                                <span>{{ $item->perfume->name }} (x{{ $item->qty }})</span>
                                <span class="font-semibold">LKR {{ number_format($item->subtotal,2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
