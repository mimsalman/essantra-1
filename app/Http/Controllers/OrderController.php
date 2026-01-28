<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Perfume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart as $row) {
            $total += $row['price'] * $row['qty'];
        }

        return view('orders.checkout', compact('cart', 'total'));
    }

    public function place(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $data = $request->validate([
        'full_name'      => ['required','string','max:120'],
        'phone'          => ['required','string','max:30'],
        'address_line1'  => ['required','string','max:200'],
        'address_line2'  => ['nullable','string','max:200'],
        'city'           => ['required','string','max:100'],
        'postal_code'    => ['required','string','max:20'],
        'payment_method' => ['required','in:cod,card'],

        // ✅ Card fields required only if card selected
        'card_name'      => ['required_if:payment_method,card','nullable','string','max:120'],
        'card_number'    => ['required_if:payment_method,card','nullable','string','max:30'],
        'card_expiry'    => ['required_if:payment_method,card','nullable','string','max:5'],  // MM/YY
        'card_cvc'       => ['required_if:payment_method,card','nullable','string','max:4'],  // 3-4 digits
    ]);


       

        \DB::transaction(function () use ($cart, $data) {

            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => 0,
                'status' => 'pending',

                'full_name' => $data['full_name'],
                'phone' => $data['phone'],
                'address_line1' => $data['address_line1'],
                'address_line2' => $data['address_line2'] ?? null,
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'payment_method' => $data['payment_method'],

                // demo only
                'card_name' => $data['payment_method'] === 'card' ? $data['card_name'] : null,
                'card_last4' => $data['payment_method'] === 'card'
                    ? substr(preg_replace('/\D+/', '', $data['card_number']), -4)
                    : null,

            ]);

            $total = 0;

            foreach ($cart as $perfumeId => $row) {
                $perfume = Perfume::findOrFail($perfumeId);

                if ($perfume->stock < $row['qty']) {
                    abort(400, "Not enough stock for {$perfume->name}");
                }

                $subtotal = $row['price'] * $row['qty'];
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'perfume_id' => $perfume->id,
                    'qty' => $row['qty'],
                    'price' => $row['price'],
                    'subtotal' => $subtotal,
                ]);

                $perfume->decrement('stock', $row['qty']);
            }

            $order->update(['total' => $total]);

            session()->forget('cart');
        });

        return redirect()->route('orders.my')->with('success', 'Order placed successfully!');
    }


    public function myOrders()
    {
        $orders = auth()->user()->orders()->latest()->with('items.perfume')->get();
        return view('orders.my', compact('orders'));
    }
}
