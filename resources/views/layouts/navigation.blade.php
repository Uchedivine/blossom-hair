<nav x-data="{ mobileMenuOpen: false, searchOpen: false, searchQuery: '' }" class="bg-white shadow-sm sticky top-0 z-50" role="navigation" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-2" aria-label="Blossom Hair Home">
                    <img src="{{ asset('images/logo.svg') }}" alt="Blossom Hair" class="h-8 md:h-10">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8" role="menubar">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-rose-500 transition font-medium" role="menuitem">
                    Home
                </a>
                <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-rose-500 transition font-medium" role="menuitem">
                    Shop
                </a>
                <a href="{{ route('shop.index', ['category' => 'wigs']) }}" class="text-gray-700 hover:text-rose-500 transition font-medium" role="menuitem">
                    Wigs
                </a>
                <a href="{{ route('shop.index', ['category' => 'weaves']) }}" class="text-gray-700 hover:text-rose-500 transition font-medium" role="menuitem">
                    Weaves
                </a>
                <a href="{{ route('shop.index', ['category' => 'closures']) }}" class="text-gray-700 hover:text-rose-500 transition font-medium" role="menuitem">
                    Closures
                </a>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-2 md:space-x-4">
                <!-- Search Icon -->
                <button @click="searchOpen = !searchOpen" 
                        class="text-gray-700 hover:text-rose-500 transition p-2"
                        aria-label="Toggle search"
                        :aria-expanded="searchOpen">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Wishlist Icon -->
                <a href="{{ route('wishlist.index') }}" 
                   class="relative text-gray-700 hover:text-rose-500 transition p-2"
                   aria-label="View wishlist">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span id="wishlist-badge" 
                          class="absolute -top-1 -right-1 bg-rose-500 text-white text-xs rounded-full h-5 w-5 items-center justify-center hidden"
                          aria-label="Wishlist items count">
                        0
                    </span>
                </a>

                <!-- Cart Icon with Preview -->
                <div x-data="{ cartPreview: false }" @mouseenter="cartPreview = true" @mouseleave="cartPreview = false" class="relative">
                    <a href="{{ route('cart.index') }}" 
                       class="relative text-gray-700 hover:text-rose-500 transition p-2 block"
                       aria-label="View shopping cart">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span id="cart-badge" 
                              class="absolute -top-1 -right-1 bg-rose-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                              aria-label="Cart items count">
                            0
                        </span>
                    </a>
                    
                    <!-- Cart Preview (Desktop Only) -->
                    <div x-show="cartPreview" 
                         x-cloak
                         class="hidden md:block absolute right-0 top-full mt-2 w-80 bg-white rounded-lg shadow-xl border z-50"
                         @click.away="cartPreview = false"
                         role="tooltip">
                        <div class="p-4">
                            <p class="text-sm text-gray-600 text-center">Hover to preview cart</p>
                            <p class="text-xs text-gray-400 text-center mt-1">Click cart icon to view full cart</p>
                        </div>
                    </div>
                </div>

                <!-- Account Icon -->
                <a href="#" 
                   class="hidden sm:block text-gray-700 hover:text-rose-500 transition p-2"
                   aria-label="My account">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden text-gray-700 p-2"
                        aria-label="Toggle mobile menu"
                        :aria-expanded="mobileMenuOpen">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Search Bar -->
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
            <form action="{{ route('shop.index') }}" method="GET" class="relative">
                <label for="search-input" class="sr-only">Search for products</label>
                <input 
                    type="text" 
                    id="search-input"
                    name="search"
                    x-model="searchQuery"
                    placeholder="Search for products..." 
                    class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-full focus:border-rose-500 focus:outline-none"
                    aria-label="Search products"
                    autofocus
                >
                <button type="submit" 
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-rose-500 text-white p-2 rounded-full hover:bg-rose-600 transition"
                        aria-label="Submit search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white border-t"
         role="menu"
         aria-label="Mobile navigation menu">
        <div class="px-4 py-4 space-y-3">
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-rose-500 transition font-medium py-2" role="menuitem">
                Home
            </a>
            <a href="{{ route('shop.index') }}" class="block text-gray-700 hover:text-rose-500 transition font-medium py-2" role="menuitem">
                Shop
            </a>
            <a href="{{ route('shop.index', ['category' => 'wigs']) }}" class="block text-gray-700 hover:text-rose-500 transition font-medium py-2" role="menuitem">
                Wigs
            </a>
            <a href="{{ route('shop.index', ['category' => 'weaves']) }}" class="block text-gray-700 hover:text-rose-500 transition font-medium py-2" role="menuitem">
                Weaves
            </a>
            <a href="{{ route('shop.index', ['category' => 'closures']) }}" class="block text-gray-700 hover:text-rose-500 transition font-medium py-2" role="menuitem">
                Closures
            </a>
            <a href="#" class="block text-gray-700 hover:text-rose-500 transition font-medium py-2 sm:hidden" role="menuitem">
                My Account
            </a>
        </div>
    </div>
</nav>
