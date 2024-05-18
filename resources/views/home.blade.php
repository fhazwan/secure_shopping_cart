@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Items for Sale</h1>
    <div class="row">
        @foreach ($items as $item)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                        <p class="card-text">${{ $item->price }}</p>
                        <a href="{{ route('items.show', $item->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
