@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="font-playfair text-4xl font-bold text-gray-900 mb-8">Checkout</h1>

    <div class="bg-white rounded-lg shadow-sm p-8 text-center">
        <svg class="mx-auto h-24 w-24 text-rose-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <h2 class="font-playfair text-3xl font-bold text-gray-900 mb-4">Checkout Coming Soon!</h2>
        <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
            We're working on the checkout process. This will include address selection, payment integration with Paystack, and order confirmation.
        </p>
        <div class="space-y-4">
            <a href="{{ route('cart.index') }}" class="inline-block bg-rose-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-rose-600 transition transform hover:scale-105 shadow-lg">
                Back to Cart
            </a>
            <br>
            <a href="{{ route('shop.index') }}" class="inline-block text-rose-500 font-semibold hover:text-rose-600">
                Continue Shopping
            </a>
        </div>
    </div>

    <!-- What's Coming -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="font-semibold text-lg mb-2">Shipping Address</h3>
            <p class="text-gray-600 text-sm">Select or add delivery address</p>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <h3 class="font-semibold text-lg mb-2">Payment</h3>
            <p class="text-gray-600 text-sm">Secure payment with Paystack</p>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="font-semibold text-lg mb-2">Order Confirmation</h3>
            <p class="text-gray-600 text-sm">Email confirmation & tracking</p>
        </div>
    </div>
</div>
@endsection
