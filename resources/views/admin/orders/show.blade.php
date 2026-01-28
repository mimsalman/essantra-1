@extends('layouts.app')
@section('title','Admin - Order Details')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold">Order #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:underline">Back</a>
</div>

@include('admin.partials.tabs')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">

    <div class="lg:col-span-5">
        <div class="bg-white border rounded-2xl p-6 shadow-sm space-y-3">
            <h2 class="font-semibold text-lg">Customer & Delivery</h2>

            <p><span class="font-semibold">Customer:</span> {{ $order->user->name ?? 'N/A' }}</p>
            <p><span class="font-semibold">Email:</span> {{ $order->user->email ?? 'N/A' }}</p>
            <p><span class="font-semibold">Phone:</span> {{ $order->phone }}</p>

            <p class="pt-2"><span class="font-semibold">Address:</span><br>
                {{ $order->address_line1 }}<br>
                @if($order->address_line2) {{ $order->address_line2 }}<br>@endif
                {{ $order->city }}, {{ $order->postal_code }}
            </p>

            <p class="pt-2"><span class="font-semibold">Payment:</span> {{ strtoupper($order->payment_method) }}</p>
            <div class="pt-2">
    <p class="flex items-center justify-between">
        <span class="font-semibold">Status:</span>

        <span class="px-2 py-1 rounded-full text-xs font-semibold
            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
            {{ $order->status === 'paid' ? 'bg-blue-100 text-blue-800' : '' }}
            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
        ">
            {{ ucfirst($order->status) }}
        </span>
    </p>

    @if($order->status === 'pending')
        <form method="POST" action="{{ route('admin.orders.markPaid', $order) }}" class="mt-3">
            @csrf
            @method('PATCH')
            <button
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow transition"
                onclick="return confirm('Mark Order #{{ $order->id }} as PAID?')"
            >
                Mark Paid
            </button>
        </form>
    @endif
</div>

        </div>
    </div>

    <div class="lg:col-span-7">
        <div class="bg-white border rounded-2xl p-6 shadow-sm">
            <h2 class="font-semibold text-lg mb-4">Items</h2>

            <div class="overflow-hidden rounded-xl border">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Perfume</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-right">Price</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-3 font-semibold">{{ $item->perfume->name ?? 'Deleted item' }}</td>
                                <td class="px-4 py-3 text-right">{{ $item->qty }}</td>
                                <td class="px-4 py-3 text-right">LKR {{ number_format($item->price,2) }}</td>
                                <td class="px-4 py-3 text-right font-semibold">LKR {{ number_format($item->subtotal,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-right font-bold text-lg">
                Total: LKR {{ number_format($order->total,2) }}
            </div>
        </div>
    </div>

</div>
@endsection
