@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top:60px;padding-bottom:80px;">

    {{-- Breadcrumb --}}
    <nav style="display:flex;align-items:center;gap:8px;margin-bottom:40px;">
        <a href="{{ route('home') }}" style="font-size:12px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.2s;"
           onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">Home</a>
        <span style="color:rgba(255,255,255,0.2);font-size:12px;">/</span>
        <a href="{{ route('cart.index') }}" style="font-size:12px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.2s;"
           onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">Cart</a>
        <span style="color:rgba(255,255,255,0.2);font-size:12px;">/</span>
        <span style="font-size:12px;color:#fda4af;">Checkout</span>
    </nav>

    {{-- Page Title --}}
    <div style="margin-bottom:40px;">
        <p class="label-sm" style="margin-bottom:8px;">Almost there</p>
        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,56px);margin:0;background:linear-gradient(135deg,#fff,#fda4af);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.1;">
            Checkout
        </h1>
    </div>

    {{-- Main Coming Soon Card --}}
    <div class="glass-strong" style="padding:56px 40px;text-align:center;border-radius:28px;position:relative;overflow:hidden;margin-bottom:24px;">

        {{-- Decorative glow --}}
        <div style="position:absolute;inset:0;background:radial-gradient(ellipse 70% 50% at 50% 0%,rgba(244,63,94,0.12),transparent 65%);pointer-events:none;"></div>

        {{-- Icon --}}
        <div style="width:80px;height:80px;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.22);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 28px;">
            <svg style="width:36px;height:36px;color:#fda4af;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
            </svg>
        </div>

        {{-- Badge --}}
        <span class="badge-amber" style="display:inline-block;margin-bottom:20px;font-size:11px;letter-spacing:0.08em;">
            ⚡ &nbsp;Coming Soon
        </span>

        <h2 style="font-family:'Playfair Display',serif;font-size:clamp(24px,4vw,40px);color:white;margin:0 0 16px;line-height:1.2;">
            Checkout is on its way!
        </h2>

        <p style="font-size:15px;color:rgba(255,255,255,0.45);max-width:520px;margin:0 auto 36px;line-height:1.75;">
            We're putting the finishing touches on our checkout experience — address selection, secure Paystack payment, and order tracking will all be ready very soon.
        </p>

        {{-- Progress Steps --}}
        <div style="display:flex;align-items:center;justify-content:center;gap:0;margin-bottom:40px;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:8px;padding:10px 16px;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.25);border-radius:50px;">
                <span style="width:20px;height:20px;background:rgba(244,63,94,0.3);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;color:#fda4af;">1</span>
                <span style="font-size:12px;color:#fda4af;font-weight:500;">Cart</span>
                <svg style="width:12px;height:12px;color:#fda4af;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div style="width:32px;height:1px;background:rgba(255,255,255,0.1);flex-shrink:0;"></div>
            <div style="display:flex;align-items:center;gap:8px;padding:10px 16px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:50px;">
                <span style="width:20px;height:20px;background:rgba(255,255,255,0.08);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;color:rgba(255,255,255,0.4);">2</span>
                <span style="font-size:12px;color:rgba(255,255,255,0.4);">Address</span>
            </div>
            <div style="width:32px;height:1px;background:rgba(255,255,255,0.1);flex-shrink:0;"></div>
            <div style="display:flex;align-items:center;gap:8px;padding:10px 16px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:50px;">
                <span style="width:20px;height:20px;background:rgba(255,255,255,0.08);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;color:rgba(255,255,255,0.4);">3</span>
                <span style="font-size:12px;color:rgba(255,255,255,0.4);">Payment</span>
            </div>
            <div style="width:32px;height:1px;background:rgba(255,255,255,0.1);flex-shrink:0;"></div>
            <div style="display:flex;align-items:center;gap:8px;padding:10px 16px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:50px;">
                <span style="width:20px;height:20px;background:rgba(255,255,255,0.08);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;color:rgba(255,255,255,0.4);">4</span>
                <span style="font-size:12px;color:rgba(255,255,255,0.4);">Confirm</span>
            </div>
        </div>

        {{-- CTA Buttons --}}
        <div style="display:flex;flex-direction:column;align-items:center;gap:14px;">
            <a href="{{ route('cart.index') }}" class="btn-rose" style="padding:13px 36px;font-size:14px;text-decoration:none;">
                ← Back to Cart
            </a>
            <a href="{{ route('shop.index') }}"
               style="font-size:13px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.2s;"
               onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">
                Continue Shopping
            </a>
        </div>
    </div>

    {{-- What's Coming Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- Shipping Address --}}
        <div class="glass" style="padding:28px;border-radius:22px;position:relative;overflow:hidden;">
            <div style="position:absolute;top:0;right:0;width:80px;height:80px;background:radial-gradient(circle at top right,rgba(244,63,94,0.1),transparent 70%);pointer-events:none;"></div>
            <div style="width:48px;height:48px;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
                <svg style="width:22px;height:22px;color:#fda4af;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
            </div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                <h3 style="font-size:15px;font-weight:500;color:white;margin:0;">Shipping Address</h3>
                <span class="badge-rose" style="font-size:9px;">Step 2</span>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,0.38);margin:0;line-height:1.6;">Select a saved address or add a new delivery location anywhere in Nigeria</p>
        </div>

        {{-- Payment --}}
        <div class="glass" style="padding:28px;border-radius:22px;position:relative;overflow:hidden;">
            <div style="position:absolute;top:0;right:0;width:80px;height:80px;background:radial-gradient(circle at top right,rgba(244,63,94,0.1),transparent 70%);pointer-events:none;"></div>
            <div style="width:48px;height:48px;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
                <svg style="width:22px;height:22px;color:#fda4af;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                </svg>
            </div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                <h3 style="font-size:15px;font-weight:500;color:white;margin:0;">Secure Payment</h3>
                <span class="badge-rose" style="font-size:9px;">Step 3</span>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,0.38);margin:0;line-height:1.6;">Pay securely via Paystack — cards, bank transfer, and USSD all supported</p>
            <div style="display:flex;gap:5px;margin-top:14px;">
                <span class="glass-dark" style="padding:3px 8px;font-size:10px;color:rgba(255,255,255,0.3);border-radius:5px;">Visa</span>
                <span class="glass-dark" style="padding:3px 8px;font-size:10px;color:rgba(255,255,255,0.3);border-radius:5px;">Mastercard</span>
                <span class="glass-dark" style="padding:3px 8px;font-size:10px;color:rgba(255,255,255,0.3);border-radius:5px;">USSD</span>
            </div>
        </div>

        {{-- Order Confirmation --}}
        <div class="glass" style="padding:28px;border-radius:22px;position:relative;overflow:hidden;">
            <div style="position:absolute;top:0;right:0;width:80px;height:80px;background:radial-gradient(circle at top right,rgba(244,63,94,0.1),transparent 70%);pointer-events:none;"></div>
            <div style="width:48px;height:48px;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
                <svg style="width:22px;height:22px;color:#fda4af;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                <h3 style="font-size:15px;font-weight:500;color:white;margin:0;">Order Confirmation</h3>
                <span class="badge-rose" style="font-size:9px;">Step 4</span>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,0.38);margin:0;line-height:1.6;">Instant email confirmation with your order details and real-time tracking</p>
        </div>
    </div>

</div>
@endsection