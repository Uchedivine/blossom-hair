@extends('layouts.app')

@section('title', 'Premium Human Hair - Your Crown Deserves The Best')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-rose-50 to-pink-100">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=1920')] bg-cover bg-center opacity-20"></div>
    
    <div class="relative z-10 text-center px-4">
        <h1 class="font-playfair text-5xl md:text-7xl font-bold text-gray-900 mb-6">
            Your Crown Deserves <br>
            <span class="text-rose-500">The Best</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-700 mb-8 max-w-2xl mx-auto">
            Premium 100% human hair that makes you feel beautiful, confident, and unstoppable
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('shop.index') }}" class="bg-rose-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-rose-600 transform hover:scale-105 transition duration-300 shadow-lg hover:shadow-xl">
                Shop Now
            </a>
            <a href="{{ route('shop.index') }}" class="bg-white text-rose-500 px-8 py-4 rounded-full font-semibold hover:bg-gray-50 transform hover:scale-105 transition duration-300 shadow-lg">
                View Collection
            </a>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-20 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="font-playfair text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Shop By Category
            </h2>
            <p class="text-gray-600 text-lg">Find your perfect style</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($categories as $category)
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="group">
                <div class="relative overflow-hidden rounded-2xl aspect-square bg-gradient-to-br from-rose-100 to-pink-50">
                    @php
                        // Priority: 1. Category image, 2. First product's image, 3. Fallback
                        $imageUrl = null;
                        
                        if ($category->image) {
                            $imageUrl = str_starts_with($category->image, 'http') 
                                ? $category->image 
                                : Storage::url($category->image);
                        } else {
                            $sampleProduct = $category->products->first();
                            $sampleImage = $sampleProduct?->images->first();
                            if ($sampleImage) {
                                $imageUrl = str_starts_with($sampleImage->image_path, 'http') 
                                    ? $sampleImage->image_path 
                                    : Storage::url($sampleImage->image_path);
                            }
                        }
                    @endphp
                    
                    @if($imageUrl)
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $category->name }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-rose-200 to-pink-200">
                        <span class="text-6xl font-playfair text-white">{{ $category->name[0] }}</span>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                        <div>
                            <h3 class="font-playfair text-2xl font-bold text-white mb-1">{{ $category->name }}</h3>
                            <p class="text-white/90 text-sm">{{ $category->products_count }} products</p>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <!-- Shimmer Loading -->
            @for($i = 0; $i < 4; $i++)
            <div class="animate-pulse">
                <div class="bg-gray-200 rounded-2xl aspect-square"></div>
            </div>
            @endfor
            @endforelse
        </div>
    </div>
</section>

<!-- Trending Products -->
<section class="py-20 px-4 bg-rose-50/30">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="font-playfair text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                ✨ Trending This Week
            </h2>
            <p class="text-gray-600 text-lg">Our most loved products</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($trendingProducts as $product)
            @include('components.product-card', ['product' => $product])
            @empty
            <!-- Shimmer Loading -->
            @for($i = 0; $i < 6; $i++)
            @include('components.product-card-skeleton')
            @endfor
            @endforelse
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-20 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl mb-2">Free Shipping</h3>
                <p class="text-gray-600">On orders over ₦50,000</p>
            </div>

            <div class="text-center p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl mb-2">100% Human Hair</h3>
                <p class="text-gray-600">Premium quality guaranteed</p>
            </div>

            <div class="text-center p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl mb-2">Easy Returns</h3>
                <p class="text-gray-600">7-day money back guarantee</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-20 px-4 bg-gradient-to-br from-rose-50 to-pink-50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="font-playfair text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Featured Collection
            </h2>
            <p class="text-gray-600 text-lg">Handpicked just for you</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
            @include('components.product-card', ['product' => $product])
            @empty
            @for($i = 0; $i < 8; $i++)
            @include('components.product-card-skeleton')
            @endfor
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('shop.index') }}" class="inline-block bg-rose-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-rose-600 transform hover:scale-105 transition duration-300 shadow-lg">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Instagram Feed -->
<section class="py-20 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="font-playfair text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                💕 Our Queens Are Glowing
            </h2>
            <p class="text-gray-600 text-lg mb-4">Join our community</p>
            <a href="#" class="text-rose-500 font-semibold hover:text-rose-600">@BlossomHairNG</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @for($i = 0; $i < 6; $i++)
            <div class="aspect-square bg-gradient-to-br from-rose-100 to-pink-100 rounded-lg overflow-hidden group cursor-pointer">
                <div class="w-full h-full bg-gray-200 group-hover:scale-110 transition duration-500"></div>
            </div>
            @endfor
        </div>
    </div>
</section>
@endsection
