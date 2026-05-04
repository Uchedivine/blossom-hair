@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top:48px;padding-bottom:80px;">

    {{-- Breadcrumb --}}
    <nav style="display:flex;align-items:center;gap:8px;margin-bottom:36px;flex-wrap:wrap;" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" style="font-size:12px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.2s;"
           onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">Home</a>
        <span style="color:rgba(255,255,255,0.2);font-size:12px;">/</span>
        <a href="{{ route('shop.index') }}" style="font-size:12px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.2s;"
           onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">Shop</a>
        <span style="color:rgba(255,255,255,0.2);font-size:12px;">/</span>
        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}"
           style="font-size:12px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.2s;"
           onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">
            {{ $product->category->name }}
        </a>
        <span style="color:rgba(255,255,255,0.2);font-size:12px;">/</span>
        <span style="font-size:12px;color:#fda4af;">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

        {{-- ===== IMAGES ===== --}}
        <div x-data="{ activeImage: 0 }">
            {{-- Main Image --}}
            <div class="glass" style="position:relative;aspect-ratio:1;overflow:hidden;border-radius:28px;margin-bottom:12px;">
                @forelse($product->images as $index => $image)
                    <img x-show="activeImage === {{ $index }}"
                         src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : Storage::url($image->image_path) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover"
                         style="border-radius:28px;">
                @empty
                    <div class="w-full h-full flex items-center justify-center"
                         style="background:linear-gradient(135deg,rgba(244,63,94,0.15),rgba(251,113,133,0.06));">
                        <span style="font-family:'Playfair Display',serif;font-size:96px;color:rgba(253,164,175,0.25);">
                            {{ substr($product->name, 0, 1) }}
                        </span>
                    </div>
                @endforelse

                {{-- Badges --}}
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                    @if($product->is_featured)
                        <span class="badge-rose">✦ Featured</span>
                    @endif
                    @if($product->compare_at_price && $product->compare_at_price > $product->base_price)
                        @php $discount = round((($product->compare_at_price - $product->base_price) / $product->compare_at_price) * 100); @endphp
                        <span class="badge-amber">-{{ $discount }}% OFF</span>
                    @endif
                </div>
            </div>

            {{-- Thumbnails --}}
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 gap-3">
                @foreach($product->images as $index => $image)
                <button @click="activeImage = {{ $index }}"
                        class="glass"
                        style="aspect-ratio:1;border-radius:14px;overflow:hidden;padding:0;border:none;cursor:pointer;transition:all 0.2s;"
                        :style="activeImage === {{ $index }} ? 'border:1.5px solid rgba(244,63,94,0.6);box-shadow:0 0 20px rgba(244,63,94,0.2);' : 'border:1px solid rgba(255,255,255,0.08);'">
                    <img src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : Storage::url($image->image_path) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover"
                         style="border-radius:14px;">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ===== PRODUCT INFO ===== --}}
        <div x-data="productDetail()">

            <p style="font-size:11px;color:#fda4af;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:8px;font-weight:500;">
                {{ $product->category->name }}
            </p>

            <h1 style="font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,44px);color:white;margin:0 0 16px;line-height:1.1;">
                {{ $product->name }}
            </h1>

            {{-- Rating --}}
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <div style="display:flex;gap:2px;">
                    @for($i = 0; $i < 5; $i++)
                        <svg style="width:16px;height:16px;fill:#fbbf24;" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    @endfor
                </div>
                <span style="font-size:13px;color:rgba(255,255,255,0.38);">({{ $product->reviews->count() }} reviews)</span>
            </div>

            {{-- Price --}}
            <div style="display:flex;align-items:baseline;gap:12px;margin-bottom:20px;">
                <span class="price-main" style="font-size:36px;">
                    ₦<span x-text="formatPrice(selectedVariant?.price || {{ $product->base_price }})"></span>
                </span>
                @if($product->compare_at_price && $product->compare_at_price > $product->base_price)
                    <span class="price-old" style="font-size:18px;">₦{{ number_format($product->compare_at_price, 0) }}</span>
                @endif
            </div>

            {{-- Description --}}
            <p style="font-size:14px;color:rgba(255,255,255,0.48);line-height:1.75;margin-bottom:24px;">
                {{ $product->description }}
            </p>

            <div class="divider-glass"></div>

            {{-- Variant Selection --}}
            @if($product->variants->count() > 0)
            <div style="display:flex;flex-direction:column;gap:20px;margin-bottom:24px;">

                {{-- Length --}}
                <div>
                    <span class="label-sm">Length: <span x-text="selectedLength || 'Select a length'" style="color:rgba(255,255,255,0.6);text-transform:none;letter-spacing:0;"></span></span>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        @foreach($product->variants->unique('length')->sortBy('length') as $variant)
                        <button @click="selectLength('{{ $variant->length }}')"
                                class="chip"
                                :class="selectedLength === '{{ $variant->length }}' ? 'chip-active' : ''"
                                style="font-size:13px;">
                            {{ $variant->length }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Texture --}}
                <div x-show="selectedLength" x-cloak>
                    <span class="label-sm">Texture: <span x-text="selectedTexture || 'Select a texture'" style="color:rgba(255,255,255,0.6);text-transform:none;letter-spacing:0;"></span></span>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        <template x-for="texture in availableTextures" :key="texture">
                            <button @click="selectTexture(texture)"
                                    class="chip"
                                    :class="selectedTexture === texture ? 'chip-active' : ''"
                                    x-text="texture"
                                    style="font-size:13px;text-transform:capitalize;">
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Color --}}
                <div x-show="selectedTexture" x-cloak>
                    <span class="label-sm">Color: <span x-text="selectedColor || 'Select a color'" style="color:rgba(255,255,255,0.6);text-transform:none;letter-spacing:0;"></span></span>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        <template x-for="color in availableColors" :key="color">
                            <button @click="selectColor(color)"
                                    class="chip"
                                    :class="selectedColor === color ? 'chip-active' : ''"
                                    x-text="color"
                                    style="font-size:13px;text-transform:capitalize;">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            @endif

            {{-- Stock Status --}}
            <div class="glass-dark" style="display:flex;align-items:center;gap:8px;padding:12px 16px;margin-bottom:20px;border-radius:14px;">
                <template x-if="selectedVariant && selectedVariant.stock_quantity > 0">
                    <div style="display:flex;align-items:center;gap:8px;width:100%;">
                        <span style="width:8px;height:8px;border-radius:50%;background:rgba(74,222,128,0.8);display:inline-block;flex-shrink:0;"></span>
                        <span style="font-size:13px;color:rgba(255,255,255,0.6);">In Stock — Ready to ship</span>
                    </div>
                </template>
                <template x-if="selectedVariant && selectedVariant.stock_quantity === 0">
                    <div style="display:flex;align-items:center;gap:8px;width:100%;">
                        <span style="width:8px;height:8px;border-radius:50%;background:rgba(239,68,68,0.7);display:inline-block;flex-shrink:0;"></span>
                        <span style="font-size:13px;color:rgba(255,255,255,0.5);">Out of Stock</span>
                    </div>
                </template>
                <template x-if="!selectedVariant">
                    <div style="display:flex;align-items:center;gap:8px;width:100%;">
                        <svg style="width:14px;height:14px;color:rgba(253,164,175,0.5);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                        </svg>
                        <span style="font-size:13px;color:rgba(255,255,255,0.4);">Select options above to check availability</span>
                    </div>
                </template>
            </div>

            {{-- Quantity + Add to Cart --}}
            <div style="display:flex;gap:10px;margin-bottom:12px;align-items:center;">
                {{-- Quantity --}}
                <div class="glass-dark" style="display:flex;align-items:center;border-radius:50px;overflow:hidden;flex-shrink:0;">
                    <button @click="quantity = Math.max(1, quantity - 1)"
                            style="width:40px;height:44px;background:none;border:none;color:rgba(255,255,255,0.6);cursor:pointer;font-size:18px;display:flex;align-items:center;justify-content:center;transition:color 0.2s;"
                            onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">−</button>
                    <span x-text="quantity" style="min-width:32px;text-align:center;font-size:14px;color:white;font-weight:500;"></span>
                    <button @click="quantity = quantity + 1"
                            style="width:40px;height:44px;background:none;border:none;color:rgba(255,255,255,0.6);cursor:pointer;font-size:18px;display:flex;align-items:center;justify-content:center;transition:color 0.2s;"
                            onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">+</button>
                </div>

                {{-- Add to Cart --}}
                <button @click="addToCart()"
                        :disabled="loading"
                        :class="loading ? 'btn-loading' : ''"
                        class="btn-rose flex-1"
                        style="padding:13px 24px;font-size:14px;">
                    <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span x-show="!loading">Add to Cart</span>
                    <span x-show="loading" x-cloak>Adding…</span>
                </button>
            </div>

            {{-- Wishlist --}}
            <button onclick="toggleWishlist({{ $product->id }}, event)"
                    class="btn-ghost w-full"
                    style="padding:12px;font-size:13px;"
                    data-product-id="{{ $product->id }}">
                <svg class="w-4 h-4 wishlist-icon" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                Add to Wishlist
            </button>

            {{-- Product Meta --}}
            @if($product->weight || $product->sku)
            <div class="divider-glass"></div>
            <div style="display:flex;flex-direction:column;gap:6px;">
                @if($product->sku)
                <div style="display:flex;gap:10px;">
                    <span style="font-size:11px;color:rgba(255,255,255,0.28);width:60px;">SKU</span>
                    <span style="font-size:11px;color:rgba(255,255,255,0.45);">{{ $product->sku }}</span>
                </div>
                @endif
                @if($product->weight)
                <div style="display:flex;gap:10px;">
                    <span style="font-size:11px;color:rgba(255,255,255,0.28);width:60px;">Weight</span>
                    <span style="font-size:11px;color:rgba(255,255,255,0.45);">{{ $product->weight }}g</span>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- ===== REVIEWS ===== --}}
    <div style="margin-top:80px;">
        <div class="divider-glass"></div>

        {{-- Reviews Header --}}
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:16px;">
            <h2 style="font-family:'Playfair Display',serif;font-size:28px;color:white;margin:0;">
                Customer Reviews <span style="font-size:16px;color:rgba(255,255,255,0.35);font-family:'DM Sans',sans-serif;">({{ $product->reviews->count() }})</span>
            </h2>
        </div>

        {{-- Reviews List --}}
        @if($product->reviews->count() > 0)
        <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:48px;">
            @foreach($product->reviews->take(5) as $review)
            <div class="glass" style="padding:24px;border-radius:20px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;flex-wrap:wrap;gap:10px;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:40px;height:40px;background:rgba(244,63,94,0.15);border:1px solid rgba(244,63,94,0.22);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="font-size:15px;color:#fda4af;font-weight:500;">{{ substr($review->user->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div>
                            <p style="font-size:14px;font-weight:500;color:rgba(255,255,255,0.85);margin:0;">{{ $review->user->name ?? 'Anonymous' }}</p>
                            <p style="font-size:11px;color:rgba(255,255,255,0.3);margin:0;">{{ $review->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div style="display:flex;gap:2px;">
                        @for($i = 0; $i < $review->rating; $i++)
                            <svg style="width:14px;height:14px;fill:#fbbf24;" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                        @for($i = $review->rating; $i < 5; $i++)
                            <svg style="width:14px;height:14px;fill:rgba(255,255,255,0.15);" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                    </div>
                </div>
                @if($review->title)
                    <h4 style="font-size:14px;font-weight:500;color:white;margin:0 0 6px;">{{ $review->title }}</h4>
                @endif
                <p style="font-size:13px;color:rgba(255,255,255,0.5);margin:0;line-height:1.7;">{{ $review->body }}</p>
            </div>
            @endforeach
        </div>
        @else
        <div class="glass" style="padding:40px;text-align:center;border-radius:20px;margin-bottom:48px;">
            <p style="font-size:14px;color:rgba(255,255,255,0.35);margin:0;">No reviews yet — be the first to share your experience!</p>
        </div>
        @endif

        {{-- Write a Review --}}
        @auth
        <div class="glass" style="padding:32px;border-radius:24px;">
            <h3 style="font-family:'Playfair Display',serif;font-size:22px;color:white;margin:0 0 24px;">Write a Review</h3>
            <form method="POST" action="{{ route('reviews.store', $product->slug) }}" style="display:flex;flex-direction:column;gap:18px;">
                @csrf

                {{-- Rating Stars --}}
                <div>
                    <span class="label-sm">Your Rating</span>
                    <div x-data="{ rating: 0, hovered: 0 }" style="display:flex;gap:6px;">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                @click="rating = {{ $i }}"
                                @mouseenter="hovered = {{ $i }}"
                                @mouseleave="hovered = 0"
                                style="background:none;border:none;cursor:pointer;padding:2px;">
                            <svg style="width:28px;height:28px;transition:fill 0.1s;"
                                 :style="(hovered >= {{ $i }} || rating >= {{ $i }}) ? 'fill:#fbbf24' : 'fill:rgba(255,255,255,0.15)'"
                                 viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        </button>
                        <input type="hidden" name="rating" :value="rating">
                        @endfor
                    </div>
                    @error('rating')<p style="font-size:12px;color:rgba(239,68,68,0.8);margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>

                <div>
                    <span class="label-sm">Review Title</span>
                    <input type="text" name="title" value="{{ old('title') }}" required maxlength="255"
                           placeholder="Summarise your experience"
                           class="input-glass {{ $errors->has('title') ? 'input-error' : '' }}">
                    @error('title')<p style="font-size:12px;color:rgba(239,68,68,0.8);margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>

                <div>
                    <span class="label-sm">Your Review</span>
                    <textarea name="body" rows="5" required maxlength="1000"
                              placeholder="Tell us what you think about this product…"
                              class="input-glass {{ $errors->has('body') ? 'input-error' : '' }}"
                              style="resize:none;">{{ old('body') }}</textarea>
                    @error('body')<p style="font-size:12px;color:rgba(239,68,68,0.8);margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>

                <div x-data="{ submitting: false }" style="display:flex;gap:10px;">
                    <button type="submit"
                            @click="submitting = true"
                            :disabled="submitting"
                            :class="submitting ? 'btn-loading' : ''"
                            class="btn-rose"
                            style="padding:12px 28px;font-size:13px;">
                        <svg x-show="submitting" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span x-show="!submitting">Submit Review</span>
                        <span x-show="submitting" x-cloak>Submitting…</span>
                    </button>
                    <button type="button"
                            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                            class="btn-ghost"
                            style="padding:12px 24px;font-size:13px;">
                        Cancel
                    </button>
                </div>

                <p style="font-size:11px;color:rgba(255,255,255,0.28);">* Reviews are published after approval by our team.</p>
            </form>
        </div>
        @else
        <div class="glass" style="padding:32px;text-align:center;border-radius:20px;">
            <p style="font-size:14px;color:rgba(255,255,255,0.45);margin:0 0 16px;">Please sign in to write a review</p>
            <a href="{{ route('login') }}" class="btn-rose" style="padding:10px 28px;font-size:13px;text-decoration:none;">Sign In</a>
        </div>
        @endauth
    </div>

</div>

@push('scripts')
<script>
function productDetail() {
    return {
        variants: @json($product->variants),
        selectedLength: null, selectedTexture: null, selectedColor: null, selectedVariant: null,
        quantity: 1, loading: false,

        get availableTextures() {
            if (!this.selectedLength) return [];
            return [...new Set(this.variants.filter(v => v.length === this.selectedLength).map(v => v.texture))];
        },
        get availableColors() {
            if (!this.selectedLength || !this.selectedTexture) return [];
            return [...new Set(this.variants.filter(v => v.length === this.selectedLength && v.texture === this.selectedTexture).map(v => v.color))];
        },
        selectLength(length) { this.selectedLength = length; this.selectedTexture = null; this.selectedColor = null; this.selectedVariant = null; },
        selectTexture(texture) { this.selectedTexture = texture; this.selectedColor = null; this.updateSelectedVariant(); },
        selectColor(color) { this.selectedColor = color; this.updateSelectedVariant(); },
        updateSelectedVariant() {
            if (this.selectedLength && this.selectedTexture && this.selectedColor) {
                this.selectedVariant = this.variants.find(v => v.length === this.selectedLength && v.texture === this.selectedTexture && v.color === this.selectedColor);
            }
        },
        formatPrice(price) { return new Intl.NumberFormat('en-NG').format(price); },
        async addToCart() {
            if (!this.selectedVariant) { showToast({ type: 'warning', title: 'Please select all options', message: 'Choose length, texture and color' }); return; }
            if (this.selectedVariant.stock_quantity === 0) { showToast({ type: 'error', title: 'Out of stock', message: 'This variant is currently unavailable' }); return; }
            this.loading = true;
            try {
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ variant_id: this.selectedVariant.id, quantity: this.quantity })
                });
                const data = await response.json();
                if (data.success) {
                    showToast({ type: 'success', title: 'Added to cart!', message: '{{ $product->name }}', actions: [{ label: 'View Cart', callback: () => window.location.href = '{{ route("cart.index") }}' }] });
                    updateCartBadge(data.cart_count);
                } else {
                    showToast({ type: 'error', title: 'Failed to add to cart', message: data.message || 'Please try again' });
                }
            } catch (e) {
                showToast({ type: 'error', title: 'Failed to add to cart', message: 'Please try again' });
            } finally { this.loading = false; }
        }
    }
}
</script>
@endpush
@endsection