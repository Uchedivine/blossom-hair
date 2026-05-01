<!-- Cart Slide-over -->
<div x-show="cartOpen" 
     x-cloak
     @keydown.escape.window="cartOpen = false"
     class="fixed inset-0 z-50 overflow-hidden">
    
    <!-- Backdrop -->
    <div x-show="cartOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="cartOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50"></div>

    <!-- Slide-over Panel -->
    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
        <div x-show="cartOpen"
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="w-screen max-w-md">
            
            <div class="flex h-full flex-col bg-white shadow-xl">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-6 border-b">
                    <h2 class="text-2xl font-playfair font-bold text-gray-900">Shopping Cart</h2>
                    <button @click="cartOpen = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto px-6 py-6">
                    <div id="cart-items-container">
                        <!-- Cart items will be loaded here via AJAX -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="mt-4 text-gray-500">Your cart is empty</p>
                            <a href="{{ route('shop.index') }}" class="mt-4 inline-block text-rose-500 font-semibold hover:text-rose-600">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="border-t px-6 py-6">
                    <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                        <p>Subtotal</p>
                        <p id="cart-subtotal">₦0</p>
                    </div>
                    <p class="text-sm text-gray-500 mb-6">Shipping and taxes calculated at checkout.</p>
                    <a href="{{ route('cart.index') }}" class="block w-full bg-rose-500 text-white text-center px-6 py-3 rounded-full font-semibold hover:bg-rose-600 transition">
                        View Cart & Checkout
                    </a>
                    <div class="mt-4 text-center">
                        <button @click="cartOpen = false" class="text-rose-500 font-semibold hover:text-rose-600">
                            Continue Shopping
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
