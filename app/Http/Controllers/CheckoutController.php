<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('tienda')->with('error', 'Tu carrito está vacío.');
        }

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('shop.checkout', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('tienda')->with('error', 'Tu carrito está vacío.');
        }

        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            // fake credit card validation
            'cc_number' => 'required|string|min:15|max:19',
            'cc_expiry' => 'required|string|size:5',
            'cc_cvc' => 'required|string|min:3|max:4',
        ]);

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        // Crear la orden
        $order = Order::create([
            'order_number' => 'VIN-'.strtoupper(Str::random(8)),
            'email' => $validated['email'],
            'name' => $validated['name'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'postal_code' => $validated['postal_code'],
            'total_amount' => $total,
            'status' => 'paid',
        ]);

        // Guardar los items
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'discogs_id' => $id,
                'name' => $item['name'],
                'artist' => $item['artist'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'cover_url' => $item['cover_url'],
            ]);
        }

        // Vaciar el carrito
        session()->forget('cart');

        return redirect()->route('checkout.success', ['order' => $order->order_number]);
    }

    public function success($orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        return view('shop.success', compact('order'));
    }
}
