<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Premium 100% human hair extensions, wigs, weaves, and closures. Shop quality hair products with fast delivery across Nigeria.')">
    <meta name="keywords" content="human hair, hair extensions, wigs, weaves, closures, bundles, Nigerian hair, premium hair">
    <meta name="author" content="Blossom Hair">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Blossom Hair') - Premium Human Hair">
    <meta property="og:description" content="@yield('meta_description', 'Premium 100% human hair extensions, wigs, weaves, and closures.')">
    <meta property="og:image" content="{{ asset('images/logo.svg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Blossom Hair') - Premium Human Hair">
    <meta property="twitter:description" content="@yield('meta_description', 'Premium 100% human hair extensions, wigs, weaves, and closures.')">
    <meta property="twitter:image" content="{{ asset('images/logo.svg') }}">

    <title>{{ config('app.name', 'Blossom Hair') }} - @yield('title', 'Premium Human Hair')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,700|inter:400,500,600,700|satisfy:400" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="antialiased bg-cream">


    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <main id="main-content" role="main">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Toast Notifications -->
    @include('components.toast-notification')

    <!-- Cart Slide-over (Alpine.js component) -->
    <div x-data="{ cartOpen: false }">
        @include('components.cart-slideover')
    </div>

    <!-- Global JavaScript -->
    <script>
        // Update Cart Badge
        function updateCartBadge(count = null) {
            const badge = document.getElementById('cart-badge');
            if (!badge) return;

            if (count !== null) {
                badge.textContent = count;
                localStorage.setItem('cart_count', count);
                
                // Bounce animation
                badge.classList.add('animate-bounce');
                setTimeout(() => badge.classList.remove('animate-bounce'), 1000);
            } else {
                // Load from localStorage
                const savedCount = localStorage.getItem('cart_count') || '0';
                badge.textContent = savedCount;
            }
        }

        // Update Wishlist Badge
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

        // Toggle Wishlist
        async function toggleWishlist(productId, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            try {
                const response = await fetch('{{ route("wishlist.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                const data = await response.json();

                if (data.success) {
                    // Update icon
                    const buttons = document.querySelectorAll(`[data-product-id="${productId}"]`);
                    buttons.forEach(btn => {
                        const icon = btn.querySelector('.wishlist-icon');
                        if (icon) {
                            if (data.in_wishlist) {
                                icon.setAttribute('fill', 'currentColor');
                                icon.classList.add('text-rose-500');
                            } else {
                                icon.setAttribute('fill', 'none');
                            }
                        }
                    });

                    // Update badge
                    updateWishlistBadge(data.wishlist_count);

                    // Show toast
                    showToast({
                        type: data.in_wishlist ? 'success' : 'info',
                        title: data.message
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                showToast({
                    type: 'error',
                    title: 'Failed to update wishlist',
                    message: 'Please try again'
                });
            }
        }

        // Load counts on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateCartBadge();
            
            const wishlistCount = localStorage.getItem('wishlist_count') || '0';
            updateWishlistBadge(parseInt(wishlistCount));
        });
    </script>

    @stack('scripts')
</body>
</html>
