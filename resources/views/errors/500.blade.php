@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-rose-50 to-pink-100 px-4">
    <div class="max-w-2xl w-full text-center">
        <!-- 500 Illustration -->
        <div class="mb-8">
            <h1 class="font-playfair text-9xl font-bold text-rose-500 mb-4">500</h1>
            <div class="relative">
                <svg class="mx-auto h-64 w-64 text-rose-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>

        <!-- Content -->
        <h2 class="font-playfair text-4xl font-bold text-gray-900 mb-4">Something Went Wrong</h2>
        <p class="text-xl text-gray-600 mb-8">
            We're experiencing technical difficulties. Our team has been notified and is working on it!
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="window.location.reload()" 
                    class="inline-block bg-rose-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-rose-600 transition transform hover:scale-105 shadow-lg">
                Try Again
            </button>
            <a href="{{ route('home') }}" 
               class="inline-block bg-white text-rose-500 border-2 border-rose-500 px-8 py-4 rounded-full font-semibold hover:bg-rose-50 transition">
                Go Home
            </a>
        </div>

        <!-- Support -->
        <div class="mt-12 pt-8 border-t border-rose-200">
            <p class="text-gray-600 mb-4">Need immediate assistance?</p>
            <a href="{{ route('contact') }}" class="text-rose-500 hover:text-rose-600 font-semibold">
                Contact Support →
            </a>
        </div>
    </div>
</div>
@endsection
