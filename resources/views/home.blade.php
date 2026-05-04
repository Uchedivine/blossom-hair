@extends('layouts.app')

@section('title', 'Premium Human Hair — Your Crown Deserves The Best')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden" style="padding:120px 16px 80px;">

    {{-- Background image with dark overlay --}}
    <div class="absolute inset-0" style="z-index:0;">
        <div class="absolute inset-0"
             style="background-image:url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=1920');background-size:cover;background-position:center;opacity:0.08;">
        </div>
        <div class="absolute inset-0"
             style="background:radial-gradient(ellipse 80% 60% at 50% 0%,rgba(244,63,94,0.18),transparent 65%);">
        </div>
    </div>

    <div class="relative max-w-4xl mx-auto text-center" style="z-index:1;">
        <div class="badge-rose animate-fade-up" style="display:inline-block;margin-bottom:20px;font-size:11px;letter-spacing:0.1em;">
            ✦ &nbsp;Premium Collection 2026&nbsp; ✦
        </div>

        <h1 class="animate-fade-up delay-100"
            style="font-family:'Playfair Display',serif;font-size:clamp(42px,8vw,88px);font-weight:700;line-height:1.08;margin-bottom:24px;background:linear-gradient(145deg,#ffffff 0%,#fda4af 50%,#fb7185 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            Your Crown<br>
            <em>Deserves The Best</em>
        </h1>

        <p class="animate-fade-up delay-200"
           style="font-size:clamp(15px,2.5vw,20px);color:rgba(255,255,255,0.5);max-width:520px;margin:0 auto 36px;line-height:1.7;">
            Premium 100% human hair that makes you feel beautiful, confident, and unstoppable.
        </p>

        <div class="animate-fade-up delay-300 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('shop.index') }}" class="btn-rose" style="padding:14px 36px;font-size:15px;text-decoration:none;">
                Shop Now
            </a>
            <a href="{{ route('shop.index') }}" class="btn-ghost" style="padding:14px 36px;font-size:15px;text-decoration:none;">
                View Collection
            </a>
        </div>

        {{-- Stats Row --}}
        <div class="animate-fade-up delay-400 glass"
             style="display:inline-flex;gap:0;margin-top:60px;border-radius:50px;overflow:hidden;padding:0;">
            <div style="padding:18px 32px;text-align:center;border-right:1px solid rgba(255,255,255,0.08);">
                <div style="font-family:'Playfair Display',serif;font-size:26px;color:#fda4af;line-height:1;">500+</div>
                <div style="font-size:10px;color:rgba(255,255,255,0.3);letter-spacing:0.1em;margin-top:4px;">HAPPY QUEENS</div>
            </div>
            <div style="padding:18px 32px;text-align:center;border-right:1px solid rgba(255,255,255,0.08);">
                <div style="font-family:'Playfair Display',serif;font-size:26px;color:#fda4af;line-height:1;">100%</div>
                <div style="font-size:10px;color:rgba(255,255,255,0.3);letter-spacing:0.1em;margin-top:4px;">HUMAN HAIR</div>
            </div>
            <div style="padding:18px 32px;text-align:center;">
                <div style="font-family:'Playfair Display',serif;font-size:26px;color:#fda4af;line-height:1;">7-Day</div>
                <div style="font-size:10px;color:rgba(255,255,255,0.3);letter-spacing:0.1em;margin-top:4px;">RETURNS</div>
            </div>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce" style="z-index:1;">
        <svg class="w-5 h-5" style="color:rgba(253,164,175,0.4);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

{{-- ===== CATEGORIES ===== --}}
<section style="padding:80px 16px;">
    <div class="max-w-7xl mx-auto">
        <div style="text-align:center;margin-bottom:48px;">
            <p class="label-sm" style="margin-bottom:10px;">Explore</p>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,48px);color:white;margin:0 0 12px;">Shop By Category</h2>
            <p style="font-size:15px;color:rgba(255,255,255,0.38);">Find your perfect style</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($categories as $category)
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="group block" style="text-decoration:none;">
                <div class="glass product-card" style="position:relative;overflow:hidden;aspect-ratio:3/4;border-radius:24px;">
                    @php
                        $imageUrl = null;
                        if ($category->image) {
                            $imageUrl = str_starts_with($category->image, 'http') ? $category->image : Storage::url($category->image);
                        } else {
                            $sampleProduct = $category->products->first();
                            $sampleImage = $sampleProduct?->images->first();
                            if ($sampleImage) {
                                $imageUrl = str_starts_with($sampleImage->image_path, 'http') ? $sampleImage->image_path : Storage::url($sampleImage->image_path);
                            }
                        }
                    @endphp

                    @if($imageUrl)
                        <img src="{{ $imageUrl }}"
                             alt="{{ $category->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                             style="border-radius:24px;opacity:0.75;">
                    @else
                        <div class="w-full h-full flex items-center justify-center"
                             style="background:linear-gradient(135deg,rgba(244,63,94,0.12),rgba(251,113,133,0.05));">
                            <span style="font-family:'Playfair Display',serif;font-size:64px;color:rgba(253,164,175,0.3);">
                                {{ $category->name[0] }}
                            </span>
                        </div>
                    @endif

                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(17,5,8,0.85) 0%,rgba(17,5,8,0.1) 55%,transparent 100%);border-radius:24px;"></div>

                    <div class="absolute bottom-0 left-0 right-0" style="padding:20px;">
                        <h3 style="font-family:'Playfair Display',serif;font-size:20px;color:white;margin:0 0 4px;">{{ $category->name }}</h3>
                        <p style="font-size:11px;color:rgba(255,255,255,0.45);margin:0;">{{ $category->products_count ?? 0 }} products</p>
                    </div>
                </div>
            </a>
            @empty
                @for($i = 0; $i < 4; $i++)
                <div class="glass animate-shimmer" style="aspect-ratio:3/4;border-radius:24px;"></div>
                @endfor
            @endforelse
        </div>
    </div>
</section>

{{-- ===== TRENDING PRODUCTS ===== --}}
<section style="padding:80px 16px;">
    <div class="max-w-7xl mx-auto">
        <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:48px;flex-wrap:wrap;gap:16px;">
            <div>
                <p class="label-sm" style="margin-bottom:10px;">This Week</p>
                <h2 style="font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,48px);color:white;margin:0;">Trending Now</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="btn-ghost" style="padding:10px 22px;font-size:13px;text-decoration:none;">View All →</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($trendingProducts as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                @for($i = 0; $i < 6; $i++)
                @include('components.product-card-skeleton')
                @endfor
            @endforelse
        </div>
    </div>
</section>

{{-- ===== TRUST FEATURES ===== --}}
<section style="padding:60px 16px;">
    <div class="max-w-7xl mx-auto">
        <div class="glass" style="padding:40px;border-radius:28px;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div style="display:flex;gap:16px;align-items:flex-start;">
                    <div style="width:48px;height:48px;flex-shrink:0;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.22);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                        <svg class="w-5 h-5" style="color:#fda4af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size:15px;font-weight:500;color:white;margin:0 0 5px;">Free Shipping</h3>
                        <p style="font-size:12px;color:rgba(255,255,255,0.38);margin:0;line-height:1.6;">On all orders over ₦50,000 anywhere in Nigeria</p>
                    </div>
                </div>

                <div style="display:flex;gap:16px;align-items:flex-start;border-left:1px solid rgba(255,255,255,0.07);padding-left:24px;">
                    <div style="width:48px;height:48px;flex-shrink:0;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.22);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                        <svg class="w-5 h-5" style="color:#fda4af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size:15px;font-weight:500;color:white;margin:0 0 5px;">100% Human Hair</h3>
                        <p style="font-size:12px;color:rgba(255,255,255,0.38);margin:0;line-height:1.6;">Premium quality sourced and verified by experts</p>
                    </div>
                </div>

                <div style="display:flex;gap:16px;align-items:flex-start;border-left:1px solid rgba(255,255,255,0.07);padding-left:24px;">
                    <div style="width:48px;height:48px;flex-shrink:0;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.22);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                        <svg class="w-5 h-5" style="color:#fda4af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size:15px;font-weight:500;color:white;margin:0 0 5px;">7-Day Returns</h3>
                        <p style="font-size:12px;color:rgba(255,255,255,0.38);margin:0;line-height:1.6;">Not happy? Return it within 7 days, no questions asked</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== FEATURED PRODUCTS ===== --}}
<section style="padding:80px 16px;">
    <div class="max-w-7xl mx-auto">
        <div style="text-align:center;margin-bottom:48px;">
            <p class="label-sm" style="margin-bottom:10px;">Handpicked</p>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,48px);color:white;margin:0 0 12px;">Featured Collection</h2>
            <p style="font-size:15px;color:rgba(255,255,255,0.38);">Our most loved pieces, curated just for you</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                @for($i = 0; $i < 8; $i++)
                @include('components.product-card-skeleton')
                @endfor
            @endforelse
        </div>

        <div style="text-align:center;margin-top:48px;">
            <a href="{{ route('shop.index') }}" class="btn-rose" style="padding:14px 40px;font-size:14px;text-decoration:none;">
                View All Products
            </a>
        </div>
    </div>
</section>

{{-- ===== SOCIAL PROOF / INSTAGRAM ===== --}}
<section style="padding:80px 16px;">
    <div class="max-w-7xl mx-auto">
        <div style="text-align:center;margin-bottom:40px;">
            <p class="label-sm" style="margin-bottom:10px;">Community</p>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(24px,4vw,40px);color:white;margin:0 0 8px;">Our Queens Are Glowing 💕</h2>
            <a href="#" style="font-size:14px;color:#fda4af;text-decoration:none;letter-spacing:0.03em;">@BlossomHairNG</a>
        </div>

        <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
            @for($i = 0; $i < 6; $i++)
            <div class="glass group" style="aspect-ratio:1;border-radius:16px;overflow:hidden;cursor:pointer;position:relative;">
                <div class="w-full h-full animate-shimmer" style="border-radius:16px;"></div>
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                     style="background:rgba(244,63,94,0.25);border-radius:16px;">
                    <svg class="w-6 h-6" style="color:white;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07..."/>
                    </svg>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

@endsection