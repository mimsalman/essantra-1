<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()
            ->with(['user', 'items.perfume'])
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.perfume']);
        return view('admin.orders.show', compact('order'));
    }

    // ✅ Mark Pending → Paid
    public function markPaid(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be marked as paid.');
        }

        $order->update(['status' => 'paid']);
        return back()->with('success', "Order #{$order->id} marked as PAID.");
    }

    public function markCompleted(Order $order)
    {
        if (!in_array($order->status, ['paid'])) {
            return back()->with('error', 'Only paid orders can be marked as completed.');
        }

        $order->update(['status' => 'completed']);
        return back()->with('success', "Order #{$order->id} marked as COMPLETED.");
    }

    public function markCancelled(Order $order)
    {
        if ($order->status === 'completed') {
            return back()->with('error', 'Completed orders cannot be cancelled.');
        }

        $order->update(['status' => 'cancelled']);
        return back()->with('success', "Order #{$order->id} marked as CANCELLED.");
    }
}
