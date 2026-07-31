<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {

            $cart[$product->id]['qty']++;

        } else {

            $cart[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->ProNameKh,
                'price' => $product->price,
                'qty'   => 1
            ];

        }

        session()->put('cart', $cart);

        return view('sale.cart', compact('cart'));
    }
}
