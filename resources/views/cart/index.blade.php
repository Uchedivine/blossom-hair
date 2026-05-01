@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-playfair text-4xl font-bold text-gray-900">Shopping Cart</h1>
            @if($summary['item_count'] > 0)
            <p class="text-gray-600 mt-2">
                <span id="cart-page-item-count">{{ $summary['item_count'] }}</span> {{ Str::plural('item', $summary['item_count']) }} in your cart
            </p>
            @endif
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(!$cart || !$summary['items'] || $summary['items']->count() === 0)
        <!-- Empty Cart State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <h2 class="mt-6 text-2xl font-semibold text-gray-900">Your cart is empty</h2>
            <p class="mt-2 text-gray-600">Start shopping to add items to your cart</p>
            <a href="{{ route('shop.index') }}" class="mt-6 inline-block bg-rose-500 text-white px-8 py-3 rounded-full font-semibold hover:bg-rose-600 transition">
                Continue Shopping
            </a>
        </div>
    @else
        <!-- Cart with Items -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($summary['items'] as $item)
                    <div class="bg-white rounded-lg p-6 shadow-sm flex gap-6">
                        <!-- Product Image -->
                        <div class="w-24 h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                            @if($item->variant && $item->variant->product && $item->variant->product->images->first())
                                @php
                                    $imagePath = $item->variant->product->images->first()->image_path;
                                @endphp
                                <img src="{{ str_starts_with($imagePath, 'http') ? $imagePath : Storage::url($imagePath) }}" alt="{{ $item->variant->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-rose-100 to-pink-100">
                                    <span class="text-2xl text-rose-300">?</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">{{ $item->variant->product->name ?? 'Product' }}</h3>
                            <p class="text-sm text-gray-600 mb-2">
                                {{ $item->variant->length ?? '' }} • 
                                {{ ucfirst($item->variant->texture ?? '') }} • 
                                {{ ucfirst($item->variant->color ?? '') }}
                            </p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-lg font-bold text-gray-900">
                                    ₦{{ number_format($item->price_at_time * $item->quantity, 0) }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    (₦{{ number_format($item->price_at_time, 0) }} each)
                                </p>
                            </div>
                        </div>

                        <!-- Quantity & Remove -->
                        <div class="flex flex-col items-end justify-between">
                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-2">
                                <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                    <button type="submit" class="w-8 h-8 border rounded hover:border-rose-500 transition">
                                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                </form>
                                <span class="w-12 text-center font-semibold">{{ $item->quantity }}</span>
                                <form action="{{ route('cart.update') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                    <button type="submit" class="w-8 h-8 border rounded hover:border-rose-500 transition">
                                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Remove Button -->
                            <button onclick="showRemoveModal({{ $item->id }}, '{{ addslashes($item->variant->product->name ?? 'this item') }}')" 
                                    class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg font-semibold hover:bg-red-100 transition border border-red-200">
                                Remove
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg p-6 shadow-sm sticky top-24">
                    <h2 class="font-semibold text-xl mb-6">Order Summary</h2>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">₦{{ number_format($summary['subtotal'], 0) }}</span>
                        </div>
                        @if($summary['discount_amount'] > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Discount</span>
                            <span class="font-semibold">-₦{{ number_format($summary['discount_amount'], 0) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold">Calculated at checkout</span>
                        </div>
                        <div class="border-t pt-4 flex justify-between text-lg">
                            <span class="font-semibold">Total</span>
                            <span class="font-bold text-rose-500">₦{{ number_format($summary['total'], 0) }}</span>
                        </div>
                    </div>

                    <!-- Coupon Code -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold mb-2">Coupon Code</label>
                        <form action="#" method="POST" class="flex gap-2">
                            @csrf
                            <input 
                                type="text" 
                                name="coupon_code"
                                placeholder="Enter code"
                                class="flex-1 px-4 py-2 border rounded-lg focus:border-rose-500 focus:outline-none">
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                                Apply
                            </button>
                        </form>
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-rose-500 text-white px-6 py-4 rounded-full font-semibold hover:bg-rose-600 transition transform hover:scale-105 mb-4 text-center">
                        Proceed to Checkout
                    </a>

                    <a href="{{ route('shop.index') }}" class="block w-full bg-white text-rose-500 border-2 border-rose-500 px-6 py-4 rounded-full font-semibold hover:bg-rose-50 transition text-center">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Remove Confirmation Modal -->
<div id="removeModal" class="hidden fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.5);">
    <!-- Modal Container -->
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 mx-auto" onclick="event.stopPropagation()">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>

            <!-- Content -->
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Remove Item?</h3>
                <p class="text-gray-600 mb-6">
                    Are you sure you want to remove <span class="font-semibold" id="modalProductName"></span> from your cart?
                </p>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <button type="button" onclick="closeRemoveModal()"
                        class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="button" onclick="confirmRemove()"
                        class="flex-1 bg-rose-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-rose-600 transition">
                    Yes, Remove
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let itemToRemove = null;

    // Update cart badge on page load with current cart count
    document.addEventListener('DOMContentLoaded', () => {
        updateCartBadge({{ $summary['item_count'] ?? 0 }});
        
        // Close modal when clicking backdrop
        document.getElementById('removeModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRemoveModal();
            }
        });
    });

    // Show remove modal
    function showRemoveModal(itemId, productName) {
        itemToRemove = itemId;
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('removeModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    // Close remove modal
    function closeRemoveModal() {
        document.getElementById('removeModal').classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
        itemToRemove = null;
    }

    // Confirmation action for remove
    function confirmRemove() {
        if (!itemToRemove) return;
        
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('cart.destroy') }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const itemInput = document.createElement('input');
        itemInput.type = 'hidden';
        itemInput.name = 'item_id';
        itemInput.value = itemToRemove;
        
        form.appendChild(csrfInput);
        form.appendChild(itemInput);
        document.body.appendChild(form);
        form.submit();
    }

    // Show toast notifications from flash messages
    @if(session('success'))
        showToast({
            type: 'success',
            title: 'Success!',
            message: '{{ session('success') }}'
        });
    @endif

    @if(session('error'))
        showToast({
            type: 'error',
            title: 'Error!',
            message: '{{ session('error') }}'
        });
    @endif
</script>
@endpush
