@extends('layouts.app')
@section('title','Admin - Orders')

@section('content')

<!-- BG image-->
    <div class="fixed inset-0 -z-10">
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('images/perfume-bg3.jpg') }}');">
        </div>

        <!-- overlay contrast-->
        <!--<div class="absolute inset-0 bg-white/20"></div>-->
    </div>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-4xl font-bold text-white">Admin: Orders</h1>
</div>

@include('admin.partials.tabs')

<div class="bg-white border rounded-2xl p-6 shadow-sm mt-6">
    <h2 class="font-semibold text-lg mb-4">All Orders</h2>

    <div class="overflow-hidden rounded-xl border">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Order</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Payment</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($orders as $o)
                    <tr>
                        <td class="px-4 py-3 font-semibold">#{{ $o->id }}</td>
                        <td class="px-4 py-3">{{ $o->user->name ?? 'Guest' }}</td>
                        <td class="px-4 py-3 uppercase text-xs font-semibold">{{ $o->payment_method }}</td>
                        <td class="px-4 py-3">
                            @php
                                $badge = match($o->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'paid' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp

                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                {{ ucfirst($o->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right font-semibold">LKR {{ number_format($o->total,2) }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.orders.show',$o) }}" class="text-gray-900 font-semibold hover:underline">
                                View
                            </a>

                            @if($o->status === 'pending')
                                <form method="POST" action="{{ route('admin.orders.markPaid', $o) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700"
                                            onclick="return confirm('Mark Order #{{ $o->id }} as PAID?')">
                                        Mark Paid
                                    </button>
                                </form>
                            @endif

                            @if($o->status === 'paid')
                                <form method="POST" action="{{ route('admin.orders.markCompleted', $o) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg bg-green-600 text-white text-xs font-semibold hover:bg-green-700"
                                            onclick="return confirm('Mark Order #{{ $o->id }} as COMPLETED?')">
                                        Complete
                                    </button>
                                </form>
                            @endif

                            @if($o->status !== 'cancelled' && $o->status !== 'completed')
                                <form method="POST" action="{{ route('admin.orders.markCancelled', $o) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs font-semibold hover:bg-red-700"
                                            onclick="return confirm('Cancel Order #{{ $o->id }} ?')">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
