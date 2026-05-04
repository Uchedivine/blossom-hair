@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="bg-gradient-to-br from-rose-50 to-pink-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="font-playfair text-5xl font-bold text-gray-900 mb-4">About Blossom Hair</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Your trusted source for premium 100% human hair extensions
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Our Story -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
        <div>
            <h2 class="font-playfair text-4xl font-bold text-[#fda4af] mb-6">Our Story</h2>
            <div class="prose prose-lg text-gray-600 space-y-4">
                <p>
                    Founded with a passion for beauty and quality, Blossom Hair has been serving customers across Nigeria with premium human hair extensions that make every woman feel confident and beautiful.
                </p>
                <p>
                    We believe that your crown deserves the best. That's why we source only the finest 100% human hair, ensuring each bundle meets our strict quality standards before reaching you.
                </p>
                <p>
                    Our commitment goes beyond just selling hair – we're here to help you find the perfect match for your style, provide expert advice, and ensure your complete satisfaction with every purchase.
                </p>
            </div>
        </div>
        <div class="relative">
            <div class="aspect-square bg-gradient-to-br from-rose-200 to-pink-200 rounded-2xl"></div>
        </div>
    </div>

    <!-- Our Values -->
    <div class="mb-20">
        <h2 class="font-playfair text-4xl font-bold text-[#fda4af] text-center mb-12">Our Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm text-center">
                <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl mb-3">Quality First</h3>
                <p class="text-gray-600">
                    We never compromise on quality. Every product is carefully inspected to ensure it meets our high standards.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm text-center">
                <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl mb-3">Customer Focused</h3>
                <p class="text-gray-600">
                    Your satisfaction is our priority. We're here to help you every step of the way.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm text-center">
                <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl mb-3">Fast Delivery</h3>
                <p class="text-gray-600">
                    Quick and reliable shipping across Nigeria, so you get your hair when you need it.
                </p>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-3xl p-12">
        <h2 class="font-playfair text-4xl font-bold text-gray-900 text-center mb-12">Why Choose Blossom Hair?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-rose-500 rounded-full flex items-center justify-center text-white font-bold">✓</div>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-2">100% Human Hair</h3>
                    <p class="text-gray-600">Authentic, premium quality human hair that looks and feels natural.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-rose-500 rounded-full flex items-center justify-center text-white font-bold">✓</div>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-2">Wide Selection</h3>
                    <p class="text-gray-600">From wigs to bundles, we have everything you need for your perfect look.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-rose-500 rounded-full flex items-center justify-center text-white font-bold">✓</div>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-2">Expert Support</h3>
                    <p class="text-gray-600">Our team is always ready to help you choose the right products.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-rose-500 rounded-full flex items-center justify-center text-white font-bold">✓</div>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-2">Secure Shopping</h3>
                    <p class="text-gray-600">Safe and secure payment options for your peace of mind.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="text-center mt-16">
        <h2 class="font-playfair text-3xl font-bold text-[#fda4af] mb-6">Ready to Find Your Perfect Hair?</h2>
        <a href="{{ route('shop.index') }}" class="inline-block bg-rose-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-rose-600 transition transform hover:scale-105 shadow-lg">
            Shop Now
        </a>
    </div>
</div>
@endsection
