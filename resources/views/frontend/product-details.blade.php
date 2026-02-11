@extends('frontend.layout.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            @if($product->images && $product->images->count() > 0)
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="img-fluid" alt="{{ $product->name }}">
            @else
                <div class="bg-light p-5 text-center">
                    <p>No image available</p>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <h3 class="text-primary">${{ number_format($product->price, 2) }}</h3>
            
            @if($product->sale_price)
                <p class="text-danger">Sale Price: ${{ number_format($product->sale_price, 2) }}</p>
            @endif
            
            <p>{{ $product->description }}</p>
            
            @if($product->colors && $product->colors->count() > 0)
                <div class="mb-3">
                    <label class="form-label">Colors:</label>
                    <div>
                        @foreach($product->colors as $color)
                            <span class="badge bg-secondary me-1">{{ $color->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            @if($product->sizes && $product->sizes->count() > 0)
                <div class="mb-3">
                    <label class="form-label">Sizes:</label>
                    <div>
                        @foreach($product->sizes as $size)
                            <span class="badge bg-info me-1">{{ $size->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <div class="mb-3">
                <p><strong>Stock:</strong> {{ $product->stock_quantity }} items available</p>
            </div>
            
            <button class="btn btn-primary btn-lg">Add to Cart</button>
            <button class="btn btn-outline-secondary btn-lg ms-2">Add to Wishlist</button>
        </div>
    </div>
    
    @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="mt-5">
            <h3>Related Products</h3>
            <div class="row">
                @foreach($relatedProducts as $related)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $related->name }}</h5>
                                <p class="card-text">${{ number_format($related->price, 2) }}</p>
                                <a href="{{ route('product.details', $related->id) }}" class="btn btn-sm btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection