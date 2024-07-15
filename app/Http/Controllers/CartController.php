<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->get();

        $cart = $cart->map(function ($cart) {
            return [
                'id' => $cart->id,
                'title' => $cart->book->title,
                'author' => $cart->book->author,
                'priceString' => getPriceString($cart->book->price),
                'price' => $cart->book->price,
                'image' => $cart->book->image,
            ];
        });

        $orderSummary = $cart->reduce(function ($carry, $item) {
            $carry['total'] += $item['price'];
            return $carry;
        }, ['total' => 0]);

        $orderSummary['subTotal'] = getPriceString($orderSummary['total']);
        $orderSummary['shipping'] =  getShippingCharges();
        $orderSummary['shippingString'] =  getPriceString($orderSummary['shipping']);
        $orderSummary['tax'] = calculateTax($orderSummary['total']);
        $orderSummary['taxString'] = getPriceString($orderSummary['tax']);
        $orderSummary['grandTotal'] = $orderSummary['total'] + $orderSummary['shipping'] + $orderSummary['tax'];
        $orderSummary['grandTotalString'] = getPriceString($orderSummary['grandTotal']);

        return inertia('Cart/Index', [
            'cartItems' => $cart,
            'orderSummary' => $orderSummary,
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        Cart::create([
            'book_id' => $request->book_id,
            'user_id' => auth()->id(),
            'quantity' => 1,
        ]);

        return redirect()->route('books.index');
    }

    public function show(Cart $cart)
    {
    }

    public function edit(Cart $cart)
    {
    }

    public function update(Request $request, Cart $cart)
    {
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back();
    }
}
