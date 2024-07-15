<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
//        $orders = Order::where('user_id', auth()->id())->get();
        if (auth()->user()->type === 'admin') {
            $orders = Order::all();
        } else {
            $orders = Order::where('user_id', auth()->id())->get();
        }

        $orders = $orders->map(function ($order) {
            $books = Book::whereIn('id', collect($order->items)->pluck('book_id'))->get();
            $books = $books->map(function ($book) use ($order) {
                $book->image = 'https://placehold.co/400x400?text=' . Str::limit($book->title, 10, '...');
                $book->priceString = getPriceString($book->price);
                return $book;
            });
            return [
                'id' => $order->id,
                'number' => 'ORD-' .$order->id,
                'total' => getPriceString(getCartTotal($books)),
                'status' => $order->status,
                'full_address' => $order->full_address,
                'items' => $order->items,
                'books' => $books,
                'createdDatetime' => Carbon::parse($order->created_at)->format('Y-m-d H:i:s'),
                'createdDate' => Carbon::parse($order->created_at)->format('Y-m-d'),
                'userName' => $order->user->name ?? 'N/A',
                'statusColor' => $order->status,
            ];
        });

        if (auth()->user()->type === 'admin') {
            return inertia('Admin/Orders/Index', [
                'orders' => $orders,
            ]);
        }

        return inertia('Orders/Index', [
            'orders' => $orders,
        ]);

    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $cart = auth()->user()->cart;

        $cartItems = Book::whereIn('id', $cart->pluck('book_id'))->get();

        $cartTotal = getCartTotal($cartItems);
        $fullAddress = getFullAddress($request->shippingInfo);

        $order = new Order();
        $order->user_id = auth()->id();
        $order->total = $cartTotal;
        $order->status = 'pending';
        $order->full_address = $fullAddress;
        $order->items = $cartItems->map(function ($item) {
            return [
                'book_id' => $item->id,
                'price' => $item->price,
            ];
        });

        $order->save();

        if ($order) {
            Cart::whereIn('id', $cart->pluck('id'))->delete();
        }

        return redirect()->route('orders.index');
    }

    public function show(Order $order)
    {
    }

    public function edit(Order $order)
    {
    }

    public function update(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('message', 'Order updated successfully');
    }

    public function destroy(Order $order)
    {
    }
}
