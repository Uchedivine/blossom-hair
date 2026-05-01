@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-rose-50 to-pink-100 px-4">
    <div class="max-w-2xl w-full text-center">
        <!-- 404 Illustration -->
        <div class="mb-8">
            <h1 class="font-playfair text-9xl font-bold text-rose-500 mb-4">404</h1>
            <div class="relative">
                <svg class="mx-auto h-64 w-64 text-rose-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Content -->
        <h2 class="font-playfair text-4xl font-bold text-gray-900 mb-4">Oops! Page Not Found</h2>
        <p class="text-xl text-gray-600 mb-8">
            The page you're looking for seems to have wandered off. Let's get you back on track!
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" 
               class="inline-block bg-rose-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-rose-600 transition transform hover:scale-105 shadow-lg">
                Go Home
            </a>
            <a href="{{ route('shop.index') }}" 
               class="inline-block bg-white text-rose-500 border-2 border-rose-500 px-8 py-4 rounded-full font-semibold hover:bg-rose-50 transition">
                Shop Now
            </a>
        </div>

        <!-- Helpful Links -->
        <div class="mt-12 pt-8 border-t border-rose-200">
            <p class="text-gray-600 mb-4">You might be looking for:</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('shop.index') }}" class="text-rose-500 hover:text-rose-600 font-semibold">Shop</a>
                <span class="text-gray-300">•</span>
                <a href="{{ route('cart.index') }}" class="text-rose-500 hover:text-rose-600 font-semibold">Cart</a>
                <span class="text-gray-300">•</span>
                <a href="{{ route('wishlist.index') }}" class="text-rose-500 hover:text-rose-600 font-semibold">Wishlist</a>
                <span class="text-gray-300">•</span>
                <a href="{{ route('contact') }}" class="text-rose-500 hover:text-rose-600 font-semibold">Contact</a>
            </div>
        </div>
    </div>
</div>
@endsection
