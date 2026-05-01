<div class="group">
    <a href="{{ route('shop.show', $product->slug) }}" class="block">
        <!-- Image -->
        <div class="relative overflow-hidden rounded-2xl aspect-square bg-gray-100 mb-4">
            @php
                $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
            @endphp
            
            @if($primaryImage)
            <img 
                src="{{ str_starts_with($primaryImage->image_path, 'http') ? $primaryImage->image_path : Storage::url($primaryImage->image_path) }}" 
                alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                loading="lazy"
            >
            @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-rose-100 to-pink-100">
                <span class="text-4xl text-rose-300">{{ substr($product->name, 0, 1) }}</span>
            </div>
            @endif

            <!-- Quick View Button -->
            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                <button class="bg-white text-gray-900 px-6 py-2 rounded-full font-semibold transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                    Quick View
                </button>
            </div>

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

            <!-- Wishlist Button -->
            <button onclick="toggleWishlist({{ $product->id }}, event)" 
                    class="wishlist-btn absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center {{ isset($inWishlist) && $inWishlist ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition duration-300 hover:bg-rose-50"
                    data-product-id="{{ $product->id }}">
                <svg class="w-5 h-5 text-rose-500 wishlist-icon" 
                     fill="{{ isset($inWishlist) && $inWishlist ? 'currentColor' : 'none' }}" 
                     stroke="currentColor" 
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        </div>

        <!-- Product Info -->
        <div class="space-y-2">
            <!-- Category -->
            <p class="text-sm text-rose-500 font-medium">{{ $product->category->name }}</p>

            <!-- Name -->
            <h3 class="font-semibold text-gray-900 group-hover:text-rose-500 transition line-clamp-2">
                {{ $product->name }}
            </h3>

            <!-- Rating -->
            <div class="flex items-center gap-2">
                <div class="flex text-amber-400">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-sm text-gray-500">({{ $product->reviews->count() }})</span>
            </div>

            <!-- Price -->
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold text-gray-900">
                    ₦{{ number_format($product->base_price, 0) }}
                </span>
                @if($product->compare_at_price && $product->compare_at_price > $product->base_price)
                <span class="text-sm text-gray-400 line-through">
                    ₦{{ number_format($product->compare_at_price, 0) }}
                </span>
                @endif
            </div>

            <!-- Stock Status -->
            @php
                $totalStock = $product->variants->sum('stock_quantity');
            @endphp
            @if($totalStock > 0)
            <p class="text-sm text-green-600 font-medium">In Stock</p>
            @else
            <p class="text-sm text-red-600 font-medium">Out of Stock</p>
            @endif
        </div>
    </a>
</div>
