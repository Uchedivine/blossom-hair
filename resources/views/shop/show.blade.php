@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-rose-500">Home</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('shop.index') }}" class="text-gray-500 hover:text-rose-500">Shop</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="text-gray-500 hover:text-rose-500">
            {{ $product->category->name }}
        </a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div x-data="{ activeImage: 0 }">
            <!-- Main Image -->
            <div class="relative aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-4">
                @forelse($product->images as $index => $image)
                <img 
                    x-show="activeImage === {{ $index }}"
                    src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : Storage::url($image->image_path) }}" 
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover"
                >
                @empty
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-rose-100 to-pink-100">
                    <span class="text-6xl text-rose-300">{{ substr($product->name, 0, 1) }}</span>
                </div>
                @endforelse

                <!-- Badges -->
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                    @if($product->is_featured)
                    <span class="bg-rose-500 text-white text-xs px-3 py-1 rounded-full font-semibold">
                        Featured
                    </span>
                    @endif
                    
                    @if($product->compare_at_price && $product->compare_at_price > $product->base_price)
                    @php
                        $discount = round((($product->compare_at_price - $product->base_price) / $product->compare_at_price) * 100);
                    @endphp
                    <span class="bg-amber-500 text-white text-xs px-3 py-1 rounded-full font-semibold">
                        -{{ $discount }}%
                    </span>
                    @endif
                </div>
            </div>

            <!-- Thumbnail Images -->
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 gap-4">
                @foreach($product->images as $index => $image)
                <button 
                    @click="activeImage = {{ $index }}"
                    :class="activeImage === {{ $index }} ? 'ring-2 ring-rose-500' : 'ring-1 ring-gray-200'"
                    class="aspect-square rounded-lg overflow-hidden hover:ring-rose-500 transition">
                    <img src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : Storage::url($image->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div x-data="productDetail()">
            <!-- Category -->
            <p class="text-rose-500 font-semibold mb-2">{{ $product->category->name }}</p>

            <!-- Title -->
            <h1 class="font-playfair text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

            <!-- Rating -->
            <div class="flex items-center gap-4 mb-6">
                <div class="flex text-amber-400">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-gray-600">({{ $product->reviews->count() }} reviews)</span>
            </div>

            <!-- Price -->
            <div class="flex items-center gap-4 mb-6">
                <span class="text-4xl font-bold text-gray-900">
                    ₦<span x-text="formatPrice(selectedVariant?.price || {{ $product->base_price }})"></span>
                </span>
                @if($product->compare_at_price && $product->compare_at_price > $product->base_price)
                <span class="text-xl text-gray-400 line-through">
                    ₦{{ number_format($product->compare_at_price, 0) }}
                </span>
                @endif
            </div>

            <!-- Description -->
            <div class="prose prose-sm mb-8">
                <p class="text-gray-600">{{ $product->description }}</p>
            </div>

            <!-- Variant Selection -->
            @if($product->variants->count() > 0)
            <div class="space-y-6 mb-8">
                <!-- Length Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        Length: <span x-text="selectedLength || 'Select'"></span>
                    </label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->variants->unique('length')->sortBy('length') as $variant)
                        <button 
                            @click="selectLength('{{ $variant->length }}')"
                            :class="selectedLength === '{{ $variant->length }}' ? 'bg-rose-500 text-white' : 'bg-white text-gray-900 hover:border-rose-500'"
                            class="px-4 py-2 border-2 rounded-lg font-semibold transition">
                            {{ $variant->length }}
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Texture Selection -->
                <div x-show="selectedLength">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        Texture: <span x-text="selectedTexture || 'Select'"></span>
                    </label>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="texture in availableTextures" :key="texture">
                            <button 
                                @click="selectTexture(texture)"
                                :class="selectedTexture === texture ? 'bg-rose-500 text-white' : 'bg-white text-gray-900 hover:border-rose-500'"
                                class="px-4 py-2 border-2 rounded-lg font-semibold transition capitalize"
                                x-text="texture">
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Color Selection -->
                <div x-show="selectedTexture">
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        Color: <span x-text="selectedColor || 'Select'"></span>
                    </label>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="color in availableColors" :key="color">
                            <button 
                                @click="selectColor(color)"
                                :class="selectedColor === color ? 'bg-rose-500 text-white' : 'bg-white text-gray-900 hover:border-rose-500'"
                                class="px-4 py-2 border-2 rounded-lg font-semibold transition capitalize"
                                x-text="color">
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Stock Status -->
                <div x-show="selectedVariant">
                    <template x-if="selectedVariant?.stock_quantity > 0">
                        <p class="text-green-600 font-semibold">
                            ✓ In Stock (<span x-text="selectedVariant.stock_quantity"></span> available)
                        </p>
                    </template>
                    <template x-if="selectedVariant?.stock_quantity === 0">
                        <p class="text-red-600 font-semibold">✗ Out of Stock</p>
                    </template>
                </div>
            </div>
            @endif

            <!-- Quantity -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-900 mb-3">Quantity</label>
                <div class="flex items-center gap-4">
                    <button @click="quantity = Math.max(1, quantity - 1)" class="w-10 h-10 border-2 rounded-lg hover:border-rose-500 transition">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                    <input type="number" x-model="quantity" min="1" class="w-20 text-center border-2 rounded-lg py-2 focus:border-rose-500 focus:outline-none">
                    <button @click="quantity++" class="w-10 h-10 border-2 rounded-lg hover:border-rose-500 transition">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Add to Cart -->
            <div class="flex gap-4 mb-8">
                <button 
                    @click="addToCart()"
                    :disabled="!selectedVariant || selectedVariant.stock_quantity === 0 || loading"
                    :class="!selectedVariant || selectedVariant.stock_quantity === 0 || loading ? 'bg-gray-300 cursor-not-allowed' : 'bg-rose-500 hover:bg-rose-600'"
                    class="flex-1 text-white px-8 py-4 rounded-full font-semibold transition transform hover:scale-105 relative">
                    <span x-show="!loading">Add to Cart</span>
                    <span x-show="loading" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Adding...
                    </span>
                </button>
                <button 
                    @click="toggleWishlist({{ $product->id }}, $event)"
                    :disabled="wishlistLoading"
                    class="w-14 h-14 border-2 border-gray-300 rounded-full hover:border-rose-500 hover:text-rose-500 transition relative"
                    data-product-id="{{ $product->id }}">
                    <svg x-show="!wishlistLoading" class="w-6 h-6 mx-auto wishlist-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <svg x-show="wishlistLoading" class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>

            <!-- Product Details -->
            <div class="border-t pt-8">
                <h3 class="font-semibold text-lg mb-4">Product Details</h3>
                <div class="prose prose-sm text-gray-600">
                    {!! $product->details !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-20">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-playfair text-3xl font-bold text-gray-900">Customer Reviews</h2>
            @auth
            <button onclick="document.getElementById('reviewForm').scrollIntoView({ behavior: 'smooth' })" 
                    class="bg-rose-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-rose-600 transition">
                Write a Review
            </button>
            @endauth
        </div>

        <!-- Review Summary -->
        @if($product->reviews->where('is_approved', true)->count() > 0)
        <div class="bg-white rounded-lg p-6 mb-8 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Average Rating -->
                <div class="text-center">
                    <div class="text-5xl font-bold text-gray-900 mb-2">
                        {{ number_format($product->reviews->where('is_approved', true)->avg('rating'), 1) }}
                    </div>
                    <div class="flex justify-center text-amber-400 mb-2">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600">Based on {{ $product->reviews->where('is_approved', true)->count() }} reviews</p>
                </div>

                <!-- Rating Breakdown -->
                <div class="space-y-2">
                    @for($i = 5; $i >= 1; $i--)
                    @php
                        $count = $product->reviews->where('is_approved', true)->where('rating', $i)->count();
                        $total = $product->reviews->where('is_approved', true)->count();
                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                    @endphp
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold w-12">{{ $i }} star</span>
                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                            <div class="bg-amber-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-sm text-gray-600 w-12 text-right">{{ $count }}</span>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
        @endif

        <!-- Review List -->
        <div class="space-y-4 mb-12">
            @forelse($product->reviews->where('is_approved', true)->sortByDesc('created_at') as $review)
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center">
                                <span class="text-rose-600 font-semibold">{{ substr($review->user->name ?? 'Guest', 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $review->user->name ?? 'Guest' }}</p>
                                <div class="flex text-amber-400">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 {{ $i < $review->rating ? 'fill-current' : 'stroke-current fill-none' }}" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                </div>
                <h4 class="font-semibold text-lg mb-2">{{ $review->title }}</h4>
                <p class="text-gray-600">{{ $review->body }}</p>
            </div>
            @empty
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <p class="text-gray-500 text-lg font-semibold mb-2">No reviews yet</p>
                <p class="text-gray-400">Be the first to review this product!</p>
            </div>
            @endforelse
        </div>

        <!-- Review Form -->
        @auth
        <div id="reviewForm" class="bg-white rounded-lg p-8 shadow-sm">
            <h3 class="font-playfair text-2xl font-bold text-gray-900 mb-6">Write a Review</h3>

            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Your Rating *</label>
                    <div x-data="{ rating: 0, hoverRating: 0 }" class="flex gap-2">
                        <input type="hidden" name="rating" x-model="rating" required>
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                @click="rating = {{ $i }}"
                                @mouseenter="hoverRating = {{ $i }}"
                                @mouseleave="hoverRating = 0"
                                class="focus:outline-none">
                            <svg class="w-10 h-10 transition"
                                 :class="(hoverRating >= {{ $i }} || rating >= {{ $i }}) ? 'text-amber-400 fill-current' : 'text-gray-300 stroke-current fill-none'"
                                 viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        </button>
                        @endfor
                    </div>
                    @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">Review Title *</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           placeholder="Sum up your experience"
                           required
                           maxlength="255"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-rose-500 focus:ring-2 focus:ring-rose-200 focus:outline-none transition">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Body -->
                <div>
                    <label for="body" class="block text-sm font-semibold text-gray-900 mb-2">Your Review *</label>
                    <textarea id="body" 
                              name="body" 
                              rows="5" 
                              required
                              maxlength="1000"
                              placeholder="Tell us what you think about this product..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-rose-500 focus:ring-2 focus:ring-rose-200 focus:outline-none transition resize-none">{{ old('body') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Maximum 1000 characters</p>
                    @error('body')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div x-data="{ submitting: false }">
                    <div class="flex gap-4">
                        <button type="submit" 
                                @click="submitting = true"
                                :disabled="submitting"
                                :class="submitting ? 'bg-gray-400 cursor-not-allowed' : 'bg-rose-500 hover:bg-rose-600'"
                                class="text-white px-8 py-3 rounded-full font-semibold transition transform hover:scale-105 relative">
                            <span x-show="!submitting">Submit Review</span>
                            <span x-show="submitting" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Submitting...
                            </span>
                        </button>
                        <button type="button" 
                                onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                                :disabled="submitting"
                                class="bg-gray-100 text-gray-700 px-8 py-3 rounded-full font-semibold hover:bg-gray-200 transition disabled:opacity-50">
                            Cancel
                        </button>
                    </div>
                </div>

                <p class="text-sm text-gray-500">
                    * Your review will be published after approval by our team.
                </p>
            </form>
        </div>
        @else
        <div class="bg-gray-50 rounded-lg p-8 text-center">
            <p class="text-gray-600 mb-4">Please log in to write a review</p>
            <a href="{{ route('login') }}" class="inline-block bg-rose-500 text-white px-8 py-3 rounded-full font-semibold hover:bg-rose-600 transition">
                Log In
            </a>
        </div>
        @endauth
    </div>
</div>

@push('scripts')
<script>
function productDetail() {
    return {
        variants: @json($product->variants),
        selectedLength: null,
        selectedTexture: null,
        selectedColor: null,
        selectedVariant: null,
        quantity: 1,
        loading: false,
        wishlistLoading: false,

        get availableTextures() {
            if (!this.selectedLength) return [];
            return [...new Set(this.variants
                .filter(v => v.length === this.selectedLength)
                .map(v => v.texture))];
        },

        get availableColors() {
            if (!this.selectedLength || !this.selectedTexture) return [];
            return [...new Set(this.variants
                .filter(v => v.length === this.selectedLength && v.texture === this.selectedTexture)
                .map(v => v.color))];
        },

        selectLength(length) {
            this.selectedLength = length;
            this.selectedTexture = null;
            this.selectedColor = null;
            this.selectedVariant = null;
        },

        selectTexture(texture) {
            this.selectedTexture = texture;
            this.selectedColor = null;
            this.updateSelectedVariant();
        },

        selectColor(color) {
            this.selectedColor = color;
            this.updateSelectedVariant();
        },

        updateSelectedVariant() {
            if (this.selectedLength && this.selectedTexture && this.selectedColor) {
                this.selectedVariant = this.variants.find(v => 
                    v.length === this.selectedLength && 
                    v.texture === this.selectedTexture && 
                    v.color === this.selectedColor
                );
            }
        },

        formatPrice(price) {
            return new Intl.NumberFormat('en-NG').format(price);
        },

        async addToCart() {
            if (!this.selectedVariant) {
                showToast({
                    type: 'warning',
                    title: 'Please select all options',
                    message: 'Choose length, texture, and color'
                });
                return;
            }

            if (this.selectedVariant.stock_quantity === 0) {
                showToast({
                    type: 'error',
                    title: 'Out of stock',
                    message: 'This variant is currently unavailable'
                });
                return;
            }

            this.loading = true;

            try {
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        variant_id: this.selectedVariant.id,
                        quantity: this.quantity
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Show success toast with undo option
                    showToast({
                        type: 'success',
                        title: 'Added to cart!',
                        message: `{{ $product->name }} - ${this.selectedLength}`,
                        actions: [
                            {
                                label: 'View Cart',
                                callback: () => window.location.href = '{{ route("cart.index") }}'
                            }
                        ]
                    });

                    // Update cart badge
                    updateCartBadge(data.cart_count);
                } else {
                    showToast({
                        type: 'error',
                        title: 'Failed to add to cart',
                        message: data.message || 'Please try again'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                showToast({
                    type: 'error',
                    title: 'Failed to add to cart',
                    message: 'Please try again'
                });
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush
@endsection
