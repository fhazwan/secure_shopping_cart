@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order #{{ $order->id }}</h1>
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
            @foreach ($order->orderItems as $orderItem)
                <tr>
                    <td>{{ $orderItem->item->name }}</td>
                    <td>{{ $orderItem->quantity }}</td>
                    <td>${{ $orderItem->price }}</td>
                    <td>${{ $orderItem->price * $orderItem->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total: ${{ $order->total }}</p>
</div>
@endsection
