<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('shop.cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('id');

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $request->input('name'),
                'artist' => $request->input('artist'),
                'price' => $request->input('price'),
                'cover_url' => $request->input('cover_url'),
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', '¡Vinilo añadido al carrito!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Vinilo eliminado del carrito');
    }

    public function checkout()
    {
        session()->forget('cart');

        return redirect()->route('tienda')->with('success', '¡Compra realizada con éxito! Gracias por tu pedido.');
    }
}
