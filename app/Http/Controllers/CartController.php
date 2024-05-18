<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('item')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        $cartItem = CartItem::firstOrNew(['user_id' => Auth::id(), 'item_id' => $itemId]);
        $cartItem->quantity += $request->input('quantity', 1);
        $cartItem->save();

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cartItem->delete();

        return redirect()->route('cart.index');
    }
}
