@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset($item->image) }}" class="img-fluid" alt="{{ $item->name }}">
        </div>
        <div class="col-md-6">
            <h1>{{ $item->name }}</h1>
            <p>{{ $item->description }}</p>
            <p>${{ $item->price }}</p>
            <form action="{{ route('cart.add', $item->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="number" name="quantity" value="1" class="form-control" min="1">
                </div>
                </br>
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
@endsection
