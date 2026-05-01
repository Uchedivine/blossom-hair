@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="font-playfair text-4xl font-bold text-gray-900 mb-2">My Wishlist</h1>
    <p class="text-gray-600 mb-8">{{ $products->count() }} {{ Str::plural('item', $products->count()) }}</p>

    @if($products->count() > 0)
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="group relative">
                    @include('components.product-card', ['product' => $product, 'showWishlist' => true])
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <svg class="mx-auto h-32 w-32 text-rose-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <h2 class="font-playfair text-3xl font-bold text-gray-900 mb-3">Your wishlist is empty</h2>
            <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">
                Save items you love for later. Start adding products to your wishlist!
            </p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-rose-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-rose-600 transition transform hover:scale-105 shadow-lg">
                Continue Shopping
            </a>
        </div>
    @endif
</div>
@endsection
