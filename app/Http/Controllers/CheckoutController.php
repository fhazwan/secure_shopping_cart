<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('item')->get();
        return view('checkout.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('item')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->total = $cartItems->sum(function ($cartItem) {
            return $cartItem->item->price * $cartItem->quantity;
        });
        $order->status = 'pending';
        $order->name = $request->input('name'); // Save user details
        $order->address = $request->input('address'); // Save user details
        $order->save();

        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->item_id = $cartItem->item_id;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->price = $cartItem->item->price;
            $orderItem->save();

            $cartItem->delete();
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully.');
    }

    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->with('orderItems.item')->firstOrFail();
        return view('orders.show', compact('order'));
    }
}
