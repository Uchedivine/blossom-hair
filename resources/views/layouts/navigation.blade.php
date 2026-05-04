<nav x-data="{ mobileMenuOpen: false, searchOpen: false, searchQuery: '' }"
     class="glass-nav sticky top-0 z-50"
     role="navigation"
     aria-label="Main navigation">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-18">

            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="Blossom Hair Home">
                    <span style="font-family:'Playfair Display',serif;font-size:22px;color:#fda4af;letter-spacing:0.04em;line-height:1;">
                        Blossom
                    </span>
                    <span style="width:1px;height:18px;background:rgba(255,255,255,0.15);display:block;"></span>
                    <span style="font-size:10px;color:rgba(255,255,255,0.35);letter-spacing:0.12em;text-transform:uppercase;">Hair</span>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-1" role="menubar">
                <a href="{{ route('home') }}" class="nav-pill {{ request()->routeIs('home') ? 'nav-active' : '' }}" role="menuitem">Home</a>
                <a href="{{ route('shop.index') }}" class="nav-pill {{ request()->routeIs('shop.*') ? 'nav-active' : '' }}" role="menuitem">Shop</a>
                <a href="{{ route('shop.index', ['category' => 'wigs']) }}" class="nav-pill" role="menuitem">Wigs</a>
                <a href="{{ route('shop.index', ['category' => 'weaves']) }}" class="nav-pill" role="menuitem">Weaves</a>
                <a href="{{ route('shop.index', ['category' => 'closures']) }}" class="nav-pill" role="menuitem">Closures</a>
            </div>

            {{-- Right Side Icons --}}
            <div class="flex items-center gap-1 md:gap-2">

                {{-- Search --}}
                <button @click="searchOpen = !searchOpen"
                        class="relative p-2.5 rounded-xl transition-all duration-200"
                        style="color:rgba(255,255,255,0.55);"
                        :style="searchOpen ? 'color:#fda4af;background:rgba(244,63,94,0.12);' : ''"
                        aria-label="Toggle search"
                        :aria-expanded="searchOpen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                {{-- Wishlist --}}
                <a href="{{ route('wishlist.index') }}"
                   class="relative p-2.5 rounded-xl transition-all duration-200"
                   style="color:rgba(255,255,255,0.55);"
                   aria-label="View wishlist">
                    <svg class="w-5 h-5 hover:text-rose-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span id="wishlist-badge"
                          class="absolute -top-0.5 -right-0.5 text-white text-xs rounded-full h-4 w-4 items-center justify-content:center hidden"
                          style="background:rgba(244,63,94,0.9);font-size:9px;font-weight:600;">0</span>
                </a>

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}"
                   class="relative p-2.5 rounded-xl transition-all duration-200"
                   style="color:rgba(255,255,255,0.55);"
                   aria-label="View shopping cart">
                    <svg class="w-5 h-5 hover:text-rose-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span id="cart-badge"
                          class="absolute -top-0.5 -right-0.5 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center"
                          style="background:rgba(244,63,94,0.9);font-size:9px;font-weight:600;">0</span>
                </a>

                {{-- Account --}}
                @auth
                <a href="#"
                   class="hidden sm:flex p-2.5 rounded-xl transition-all duration-200"
                   style="color:rgba(255,255,255,0.55);"
                   aria-label="My account">
                    <svg class="w-5 h-5 hover:text-rose-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="hidden sm:flex btn-ghost"
                   style="padding:7px 16px;font-size:12px;text-decoration:none;">
                    Sign In
                </a>
                @endauth

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2.5 rounded-xl"
                        style="color:rgba(255,255,255,0.6);"
                        aria-label="Toggle mobile menu"
                        :aria-expanded="mobileMenuOpen">
                    <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Search Bar --}}
        <div x-show="searchOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="pb-4"
             role="search">
            <form action="{{ route('shop.index') }}" method="GET">
                <div class="glass-dark flex items-center gap-3 px-4 py-1" style="border-radius:50px;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="rgba(255,255,255,0.35)" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text"
                           name="search"
                           x-model="searchQuery"
                           placeholder="Search for wigs, weaves, bundles…"
                           class="flex-1 bg-transparent border-none outline-none py-2.5"
                           style="font-family:'DM Sans',sans-serif;font-size:14px;color:rgba(255,255,255,0.85);"
                           autofocus>
                    <button type="submit" class="btn-rose" style="padding:7px 18px;font-size:12px;flex-shrink:0;">Search</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden"
         style="border-top:1px solid rgba(255,255,255,0.07);"
         role="menu">
        <div class="px-4 py-4 flex flex-col gap-1">
            <a href="{{ route('home') }}" class="nav-pill" role="menuitem" style="display:block;padding:10px 16px;">Home</a>
            <a href="{{ route('shop.index') }}" class="nav-pill" role="menuitem" style="display:block;padding:10px 16px;">Shop</a>
            <a href="{{ route('shop.index', ['category' => 'wigs']) }}" class="nav-pill" role="menuitem" style="display:block;padding:10px 16px;">Wigs</a>
            <a href="{{ route('shop.index', ['category' => 'weaves']) }}" class="nav-pill" role="menuitem" style="display:block;padding:10px 16px;">Weaves</a>
            <a href="{{ route('shop.index', ['category' => 'closures']) }}" class="nav-pill" role="menuitem" style="display:block;padding:10px 16px;">Closures</a>
            @guest
            <div style="height:1px;background:rgba(255,255,255,0.07);margin:8px 0;"></div>
            <a href="{{ route('login') }}" class="nav-pill" style="display:block;padding:10px 16px;">Sign In</a>
            <a href="{{ route('register') }}" class="btn-rose" style="padding:10px 16px;font-size:13px;text-decoration:none;margin-top:4px;">Create Account</a>
            @endguest
        </div>
    </div>
</nav>