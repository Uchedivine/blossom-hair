<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="@yield('meta_description', 'Premium 100% human hair extensions, wigs, weaves, and closures. Shop quality hair products with fast delivery across Nigeria.')">
    <meta name="keywords" content="human hair, hair extensions, wigs, weaves, closures, bundles, Nigerian hair, premium hair">
    <meta name="author" content="Blossom Hair">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Blossom Hair') - Premium Human Hair">
    <meta property="og:description" content="@yield('meta_description', 'Premium 100% human hair extensions, wigs, weaves, and closures.')">
    <meta property="og:image" content="{{ asset('images/logo.svg') }}">

    <title>{{ config('app.name', 'Blossom Hair') }} - @yield('title', 'Premium Human Hair')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        /* Floating ambient orbs — purely decorative */
        .ambient-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
    </style>

    @stack('styles')
</head>
<body class="antialiased min-h-screen" style="font-family:'DM Sans',sans-serif;">

    {{-- Ambient background orbs --}}
    <div class="ambient-orb" style="width:500px;height:500px;background:rgba(244,63,94,0.09);top:-150px;left:-100px;"></div>
    <div class="ambient-orb" style="width:400px;height:400px;background:rgba(251,113,133,0.07);bottom:-100px;right:-80px;"></div>
    <div class="ambient-orb" style="width:300px;height:300px;background:rgba(253,164,175,0.05);top:40%;left:55%;"></div>

    {{-- Skip link --}}
    <a href="#main-content" class="skip-to-main">Skip to main content</a>

    {{-- Navigation --}}
    @include('layouts.navigation')

    {{-- Main Content --}}
    <main id="main-content" role="main" style="position:relative;z-index:1;">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')

    {{-- Toast Notifications --}}
    @include('components.toast-notification')

    {{-- Cart Slide-over --}}
    <div x-data="{ cartOpen: false }">
        @include('components.cart-slideover')
    </div>

    {{-- Global JS --}}
    <script>
        function updateCartBadge(count = null) {
            const badge = document.getElementById('cart-badge');
            if (!badge) return;
            if (count !== null) {
                badge.textContent = count;
                localStorage.setItem('cart_count', count);
                badge.classList.add('animate-bounce-badge');
                setTimeout(() => badge.classList.remove('animate-bounce-badge'), 400);
            } else {
                badge.textContent = localStorage.getItem('cart_count') || '0';
            }
        }

        function updateWishlistBadge(count) {
            const badge = document.getElementById('wishlist-badge');
            if (!badge) return;
            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }
            localStorage.setItem('wishlist_count', count);
        }

        async function toggleWishlist(productId, event) {
            if (event) { event.preventDefault(); event.stopPropagation(); }
            try {
                const response = await fetch('{{ route("wishlist.toggle") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ product_id: productId })
                });
                const data = await response.json();
                if (data.success) {
                    document.querySelectorAll(`[data-product-id="${productId}"]`).forEach(btn => {
                        const icon = btn.querySelector('.wishlist-icon');
                        if (icon) {
                            icon.setAttribute('fill', data.in_wishlist ? 'currentColor' : 'none');
                            icon.classList.toggle('text-rose-400', data.in_wishlist);
                        }
                    });
                    updateWishlistBadge(data.wishlist_count);
                    showToast({ type: data.in_wishlist ? 'success' : 'info', title: data.message });
                }
            } catch (error) {
                showToast({ type: 'error', title: 'Failed to update wishlist', message: 'Please try again' });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCartBadge();
            updateWishlistBadge(parseInt(localStorage.getItem('wishlist_count') || '0'));
        });
    </script>

    @stack('scripts')
</body>
</html>