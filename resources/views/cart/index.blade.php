@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>
    @if ($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->item->name }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>${{ $cartItem->item->price }}</td>
                        <td>${{ $cartItem->item->price * $cartItem->quantity }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('checkout.index') }}" class="btn btn-primary">Checkout</a>
    @endif
</div>
@endsection
