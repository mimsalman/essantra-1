<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []); // [id => ['qty'=>1,'name'=>...]]
        $items = [];
        $total = 0;

        foreach ($cart as $id => $row) {
            $subtotal = $row['price'] * $row['qty'];
            $total += $subtotal;

            $items[] = [
                'id' => $id,
                'name' => $row['name'],
                'price' => $row['price'],
                'qty' => $row['qty'],
                'subtotal' => $subtotal,
                'image' => $row['image'] ?? null,
            ];
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Perfume $perfume)
    {
        $qty = max(1, (int) $request->input('qty', 1));

        $cart = session()->get('cart', []);

        if (isset($cart[$perfume->id])) {
            $cart[$perfume->id]['qty'] += $qty;
        } else {
            $cart[$perfume->id] = [
                'name' => $perfume->name,
                'price' => (float) $perfume->price,
                'qty' => $qty,
                'image' => $perfume->image,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Added to cart!');
    }

    public function update(Request $request, $id)
    {
        $qty = max(1, (int) $request->input('qty', 1));

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item removed!');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared!');
    }

    public function buyNow(Perfume $perfume)
    {
        // Put only this item in cart (optional: clear existing cart)
        session()->put('cart', [
            $perfume->id => [
                'name' => $perfume->name,
                'price' => (float) $perfume->price,
                'qty' => 1,
                'image' => $perfume->image,
            ]
        ]);

        // Go directly to checkout (orders module)
        return redirect()->route('orders.checkout')->with('success', 'Ready to checkout!');
    }

}
