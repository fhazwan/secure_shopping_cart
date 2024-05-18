@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Items for Sale</h1>

    <!-- Search Form -->
    <form action="{{ route('items.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search for items..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach ($items as $item)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset($item->image) }}" class="card-img-top" alt="{{ $item->name }}">
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
