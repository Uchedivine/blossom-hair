@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top:60px;padding-bottom:80px;">

    {{-- Header --}}
    <div style="margin-bottom:40px;">
        <p class="label-sm" style="margin-bottom:8px;">Your Selection</p>
        <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;">
            <h1 style="font-family:'Playfair Display',serif;font-size:clamp(28px,5vw,52px);margin:0;background:linear-gradient(135deg,#fff,#fda4af);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.1;">
                Shopping Cart
            </h1>
            @if(isset($summary['item_count']) && $summary['item_count'] > 0)
            <p style="font-size:13px;color:rgba(255,255,255,0.35);margin:0;">
                <span id="cart-page-item-count">{{ $summary['item_count'] }}</span>
                {{ Str::plural('item', $summary['item_count']) }} in your cart
            </p>
            @endif
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="glass" style="padding:14px 18px;margin-bottom:20px;border:1px solid rgba(74,222,128,0.2)!important;display:flex;align-items:center;gap:10px;border-radius:14px;">
        <svg class="w-4 h-4 flex-shrink-0" style="color:rgba(74,222,128,0.8);" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span style="font-size:13px;color:rgba(255,255,255,0.75);">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="glass" style="padding:14px 18px;margin-bottom:20px;border:1px solid rgba(239,68,68,0.2)!important;display:flex;align-items:center;gap:10px;border-radius:14px;">
        <svg class="w-4 h-4 flex-shrink-0" style="color:rgba(239,68,68,0.8);" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <span style="font-size:13px;color:rgba(255,255,255,0.75);">{{ session('error') }}</span>
    </div>
    @endif

    @if(!$cart || !isset($summary['items']) || $summary['items']->count() === 0)

    {{-- Empty Cart --}}
    <div style="text-align:center;padding:80px 16px;">
        <div class="glass" style="display:inline-flex;flex-direction:column;align-items:center;padding:60px 48px;border-radius:32px;max-width:400px;">
            <div style="width:80px;height:80px;background:rgba(244,63,94,0.1);border:1px solid rgba(244,63,94,0.18);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:24px;">
                <svg class="w-9 h-9" style="color:rgba(253,164,175,0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h2 style="font-family:'Playfair Display',serif;font-size:26px;color:white;margin:0 0 10px;">Your cart is empty</h2>
            <p style="font-size:13px;color:rgba(255,255,255,0.38);margin:0 0 28px;line-height:1.6;">Start exploring our premium collection and add items to your cart</p>
            <a href="{{ route('shop.index') }}" class="btn-rose" style="padding:12px 32px;font-size:14px;text-decoration:none;">Continue Shopping</a>
        </div>
    </div>

    @else

    {{-- Cart with Items --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Cart Items --}}
        <div class="lg:col-span-2" style="display:flex;flex-direction:column;gap:12px;">
            @foreach($summary['items'] as $item)
            <div class="glass" style="padding:20px;display:flex;gap:16px;align-items:flex-start;border-radius:20px;">

                {{-- Product Image --}}
                <div style="width:80px;height:80px;flex-shrink:0;border-radius:14px;overflow:hidden;background:linear-gradient(135deg,rgba(244,63,94,0.12),rgba(251,113,133,0.05));">
                    @if($item->variant && $item->variant->product && $item->variant->product->images->first())
                        @php $imagePath = $item->variant->product->images->first()->image_path; @endphp
                        <img src="{{ str_starts_with($imagePath, 'http') ? $imagePath : Storage::url($imagePath) }}"
                             alt="{{ $item->variant->product->name }}"
                             style="width:100%;height:100%;object-fit:cover;border-radius:14px;">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                            <span style="font-family:'Playfair Display',serif;font-size:28px;color:rgba(253,164,175,0.35);">?</span>
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div style="flex:1;min-width:0;">
                    <h3 style="font-size:15px;font-weight:500;color:rgba(255,255,255,0.9);margin:0 0 4px;line-height:1.3;">
                        {{ $item->variant->product->name ?? 'Product' }}
                    </h3>
                    <p style="font-size:12px;color:rgba(255,255,255,0.35);margin:0 0 10px;">
                        {{ $item->variant->length ?? '' }}
                        @if($item->variant->texture) · {{ ucfirst($item->variant->texture) }}@endif
                        @if($item->variant->color) · {{ ucfirst($item->variant->color) }}@endif
                    </p>
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                        <span class="price-main" style="font-size:18px;">₦{{ number_format($item->price_at_time * $item->quantity, 0) }}</span>
                        <span style="font-size:12px;color:rgba(255,255,255,0.3);">₦{{ number_format($item->price_at_time, 0) }} each</span>
                    </div>
                </div>

                {{-- Controls --}}
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:12px;flex-shrink:0;">
                    {{-- Remove --}}
                    <form action="{{ route('cart.destroy') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit"
                                style="background:none;border:none;color:rgba(255,255,255,0.22);cursor:pointer;padding:4px;transition:color 0.2s;"
                                onmouseover="this.style.color='rgba(239,68,68,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.22)'"
                                aria-label="Remove item">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>

                    {{-- Quantity --}}
                    <div class="glass-dark" style="display:flex;align-items:center;border-radius:50px;overflow:hidden;">
                        <form action="{{ route('cart.update') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                            <button type="submit"
                                    style="width:34px;height:34px;background:none;border:none;color:rgba(255,255,255,0.5);cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:color 0.2s;"
                                    onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">−</button>
                        </form>
                        <span style="min-width:28px;text-align:center;font-size:13px;color:white;font-weight:500;">{{ $item->quantity }}</span>
                        <form action="{{ route('cart.update') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                            <button type="submit"
                                    style="width:34px;height:34px;background:none;border:none;color:rgba(255,255,255,0.5);cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:color 0.2s;"
                                    onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">+</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Coupon --}}
            <div class="glass-dark" style="padding:16px;display:flex;gap:10px;align-items:center;border-radius:16px;">
                <form action="{{ route('cart.coupon') }}" method="POST" style="display:flex;gap:10px;width:100%;">
                    @csrf
                    <input type="text" name="coupon_code"
                           value="{{ session('applied_coupon') }}"
                           placeholder="Enter coupon code"
                           class="input-glass"
                           style="flex:1;padding:10px 14px;font-size:13px;border-radius:10px;">
                    <button type="submit" class="btn-ghost" style="padding:10px 20px;font-size:12px;flex-shrink:0;">Apply</button>
                </form>
            </div>

            {{-- Continue Shopping --}}
            <a href="{{ route('shop.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.2s;margin-top:4px;"
               onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">
                ← Continue Shopping
            </a>
        </div>

        {{-- Order Summary --}}
        <div>
            <div class="glass-strong" style="padding:28px;border-radius:24px;position:sticky;top:90px;">
                <p class="label-sm" style="margin-bottom:20px;">Order Summary</p>

                <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:20px;">
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:13px;color:rgba(255,255,255,0.45);">Subtotal</span>
                        <span style="font-size:13px;color:rgba(255,255,255,0.8);">₦{{ number_format($summary['subtotal'] ?? 0, 0) }}</span>
                    </div>

                    @if(isset($summary['discount']) && $summary['discount'] > 0)
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:13px;color:rgba(255,255,255,0.45);">
                            Discount
                            @if(session('applied_coupon'))
                                <span class="badge-rose" style="margin-left:4px;font-size:9px;">{{ session('applied_coupon') }}</span>
                            @endif
                        </span>
                        <span style="font-size:13px;color:rgba(74,222,128,0.8);">−₦{{ number_format($summary['discount'], 0) }}</span>
                    </div>
                    @endif

                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:13px;color:rgba(255,255,255,0.45);">Shipping</span>
                        <span style="font-size:13px;color:rgba(74,222,128,0.8);">
                            {{ isset($summary['shipping_cost']) && $summary['shipping_cost'] > 0 ? '₦' . number_format($summary['shipping_cost'], 0) : 'Free' }}
                        </span>
                    </div>
                </div>

                <div class="divider-glass"></div>

                <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:24px;">
                    <span style="font-family:'Playfair Display',serif;font-size:16px;color:white;">Total</span>
                    <span class="price-main" style="font-size:26px;">₦{{ number_format($summary['total'] ?? 0, 0) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-rose" style="width:100%;padding:14px;font-size:14px;text-decoration:none;display:flex;justify-content:center;margin-bottom:16px;">
                    Proceed to Checkout
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <div class="divider-glass"></div>

                {{-- Security Badge --}}
                <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                    <svg class="w-3.5 h-3.5" style="color:rgba(255,255,255,0.25);" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <span style="font-size:11px;color:rgba(255,255,255,0.25);">Secured &amp; encrypted by Paystack</span>
                </div>

                {{-- Payment Icons --}}
                <div style="display:flex;justify-content:center;gap:6px;margin-top:12px;">
                    <span class="glass-dark" style="padding:4px 10px;font-size:10px;color:rgba(255,255,255,0.3);border-radius:6px;">Visa</span>
                    <span class="glass-dark" style="padding:4px 10px;font-size:10px;color:rgba(255,255,255,0.3);border-radius:6px;">Mastercard</span>
                    <span class="glass-dark" style="padding:4px 10px;font-size:10px;color:rgba(255,255,255,0.3);border-radius:6px;">Paystack</span>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection