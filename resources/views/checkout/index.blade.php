@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout</h1>
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
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->item->name }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>${{ $cartItem->item->price }}</td>
                        <td>${{ $cartItem->item->price * $cartItem->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Place Order</button>
        </form>
    @endif
</div>
@endsection
