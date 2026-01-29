<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Notifications\OrderStatusUpdated;

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

    // ✅ Pending → Paid
    public function markPaid(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be marked as paid.');
        }

        return $this->setStatusAndNotify($order, 'paid');
    }

    // ✅ Paid → Completed
    public function markCompleted(Order $order)
    {
        if ($order->status !== 'paid') {
            return back()->with('error', 'Only paid orders can be marked as completed.');
        }

        return $this->setStatusAndNotify($order, 'completed');
    }

    // ✅ Cancel (allowed unless completed)
    public function markCancelled(Order $order)
    {
        if ($order->status === 'completed') {
            return back()->with('error', 'Completed orders cannot be cancelled.');
        }

        return $this->setStatusAndNotify($order, 'cancelled');
    }

    /**
     * ✅ Updates order status and sends email to customer
     */
    private function setStatusAndNotify(Order $order, string $newStatus)
    {
        $oldStatus = $order->status;

        $order->update(['status' => $newStatus]);

        // ✅ send mail if order belongs to a user
        if ($order->user) {
            $order->user->notify(new OrderStatusUpdated($order, $oldStatus, $newStatus));
        }

        return back()->with('success', "Order #{$order->id} marked as " . strtoupper($newStatus) . ".");
    }
}
