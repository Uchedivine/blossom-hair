<div class="product-card group" style="cursor:pointer;">
    <a href="{{ route('shop.show', $product->slug) }}" class="block">

        {{-- Product Image --}}
        <div class="glass" style="position:relative;overflow:hidden;aspect-ratio:1;margin-bottom:14px;border-radius:20px;">
            @php
                $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
            @endphp

            @if($primaryImage)
                <img src="{{ str_starts_with($primaryImage->image_path, 'http') ? $primaryImage->image_path : Storage::url($primaryImage->image_path) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-600"
                     loading="lazy"
                     style="border-radius:20px;">
            @else
                <div class="w-full h-full flex items-center justify-center"
                     style="background:linear-gradient(135deg,rgba(244,63,94,0.15),rgba(251,113,133,0.06));border-radius:20px;">
                    <span style="font-family:'Playfair Display',serif;font-size:52px;color:rgba(253,164,175,0.3);">
                        {{ substr($product->name, 0, 1) }}
                    </span>
                </div>
            @endif

            {{-- Quick View Overlay --}}
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300"
                 style="background:rgba(0,0,0,0.35);border-radius:20px;">
                <span class="btn-ghost"
                      style="padding:8px 20px;font-size:12px;transform:translateY(8px);transition:transform 0.3s;"
                      class="group-hover:translate-y-0">
                    Quick View
                </span>
            </div>

            {{-- Badges --}}
            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                @if($product->is_featured)
                    <span class="badge-rose">✦ Featured</span>
                @endif
                @if($product->compare_at_price && $product->compare_at_price > $product->base_price)
                    @php $discount = round((($product->compare_at_price - $product->base_price) / $product->compare_at_price) * 100); @endphp
                    <span class="badge-amber">-{{ $discount }}%</span>
                @endif
            </div>

            {{-- Wishlist Button --}}
            <button onclick="toggleWishlist({{ $product->id }}, event)"
                    class="absolute top-3 right-3 flex items-center justify-center transition-all duration-200 opacity-0 group-hover:opacity-100"
                    style="width:36px;height:36px;background:rgba(17,5,8,0.7);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.12);border-radius:50%;"
                    data-product-id="{{ $product->id }}"
                    aria-label="Add to wishlist">
                <svg class="w-4 h-4 wishlist-icon"
                     fill="{{ isset($inWishlist) && $inWishlist ? 'currentColor' : 'none' }}"
                     stroke="{{ isset($inWishlist) && $inWishlist ? '#fda4af' : 'rgba(255,255,255,0.7)' }}"
                     stroke-width="1.75"
                     viewBox="0 0 24 24"
                     style="{{ isset($inWishlist) && $inWishlist ? 'color:#fda4af;' : '' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        </div>

        {{-- Product Info --}}
        <div style="padding:0 4px;">
            {{-- Category --}}
            <p style="font-size:10px;color:#fda4af;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:5px;font-weight:500;">
                {{ $product->category->name }}
            </p>

            {{-- Name --}}
            <h3 style="font-size:14px;font-weight:500;color:rgba(255,255,255,0.88);line-height:1.4;margin-bottom:8px;"
                class="line-clamp-2 group-hover:text-rose-300 transition-colors duration-200">
                {{ $product->name }}
            </h3>

            {{-- Rating --}}
            <div style="display:flex;align-items:center;gap:5px;margin-bottom:8px;">
                <div style="display:flex;gap:1px;">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-3 h-3" style="fill:#fbbf24;" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    @endfor
                </div>
                <span style="font-size:11px;color:rgba(255,255,255,0.3);">({{ $product->reviews->count() }})</span>
            </div>

            {{-- Price --}}
            <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:6px;">
                <span class="price-main" style="font-size:18px;">₦{{ number_format($product->base_price, 0) }}</span>
                @if($product->compare_at_price && $product->compare_at_price > $product->base_price)
                    <span class="price-old">₦{{ number_format($product->compare_at_price, 0) }}</span>
                @endif
            </div>

            {{-- Stock --}}
            @php $totalStock = $product->variants->sum('stock_quantity'); @endphp
            @if($totalStock > 0)
                <p style="font-size:11px;color:rgba(74,222,128,0.8);display:flex;align-items:center;gap:4px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:rgba(74,222,128,0.8);display:inline-block;"></span>
                    In Stock
                </p>
            @else
                <p style="font-size:11px;color:rgba(239,68,68,0.7);display:flex;align-items:center;gap:4px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:rgba(239,68,68,0.7);display:inline-block;"></span>
                    Out of Stock
                </p>
            @endif
        </div>
    </a>
</div>