<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected InventoryService $inventoryService;
    protected CouponService $couponService;

    public function __construct(InventoryService $inventoryService, CouponService $couponService)
    {
        $this->inventoryService = $inventoryService;
        $this->couponService = $couponService;
    }

    /**
     * Get or create cart for current user/session
     */
    public function getCart(?User $user = null, ?string $sessionId = null): Cart
    {
        $sessionId = $sessionId ?? Session::getId();

        if ($user) {
            // Get or create cart for authenticated user
            return Cart::firstOrCreate(
                ['user_id' => $user->id],
                ['session_id' => $sessionId]
            );
        }

        // Get or create cart for guest
        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => null]
        );
    }

    /**
     * Add item to cart
     */
    public function addItem(ProductVariant $variant, int $quantity = 1, ?User $user = null): CartItem
    {
        // Check stock availability
        if (!$this->inventoryService->isInStock($variant, $quantity)) {
            throw new \Exception('Insufficient stock available');
        }

        $cart = $this->getCart($user);

        // Check if item already exists in cart
        $cartItem = $cart->items()->where('product_variant_id', $variant->id)->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            
            if (!$this->inventoryService->isInStock($variant, $newQuantity)) {
                throw new \Exception('Insufficient stock available');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            $cartItem = $cart->items()->create([
                'product_variant_id' => $variant->id,
                'quantity' => $quantity,
                'price_at_time' => $variant->price ?? $variant->product->base_price,
            ]);
        }

        return $cartItem->fresh();
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(CartItem $cartItem, int $quantity): CartItem
    {
        if ($quantity <= 0) {
            throw new \Exception('Quantity must be greater than 0');
        }

        // Check stock availability
        if (!$this->inventoryService->isInStock($cartItem->variant, $quantity)) {
            throw new \Exception('Insufficient stock available');
        }

        $cartItem->update(['quantity' => $quantity]);

        return $cartItem->fresh();
    }

    /**
     * Remove item from cart
     */
    public function removeItem(CartItem $cartItem): bool
    {
        return $cartItem->delete();
    }

    /**
     * Clear all items from cart
     */
    public function clearCart(Cart $cart): bool
    {
        return $cart->items()->delete();
    }

    /**
     * Get cart subtotal (before discounts and shipping)
     */
    public function getSubtotal(Cart $cart): float
    {
        return $cart->items->sum(function ($item) {
            return $item->price_at_time * $item->quantity;
        });
    }

    /**
     * Get cart total item count
     */
    public function getItemCount(Cart $cart): int
    {
        return $cart->items->sum('quantity');
    }

    /**
     * Apply coupon to cart
     */
    public function applyCoupon(Cart $cart, string $couponCode): array
    {
        $subtotal = $this->getSubtotal($cart);
        
        // Validate coupon
        $coupon = $this->couponService->validateCoupon($couponCode, $subtotal);

        // Calculate discount
        $discountAmount = $this->couponService->calculateDiscount($coupon, $subtotal);

        return [
            'coupon' => $coupon,
            'discount_amount' => $discountAmount,
            'subtotal' => $subtotal,
            'total' => $subtotal - $discountAmount,
        ];
    }

    /**
     * Get cart total with discount applied
     */
    public function getTotal(Cart $cart, ?Coupon $coupon = null): float
    {
        $subtotal = $this->getSubtotal($cart);

        if ($coupon) {
            $discount = $this->couponService->calculateDiscount($coupon, $subtotal);
            return $subtotal - $discount;
        }

        return $subtotal;
    }

    /**
     * Merge guest cart with user cart on login
     */
    public function mergeGuestCart(User $user, string $guestSessionId): Cart
    {
        return DB::transaction(function () use ($user, $guestSessionId) {
            // Get guest cart
            $guestCart = Cart::where('session_id', $guestSessionId)
                ->whereNull('user_id')
                ->first();

            if (!$guestCart) {
                return $this->getCart($user);
            }

            // Get or create user cart
            $userCart = $this->getCart($user);

            // Merge items
            foreach ($guestCart->items as $guestItem) {
                $existingItem = $userCart->items()
                    ->where('product_variant_id', $guestItem->product_variant_id)
                    ->first();

                if ($existingItem) {
                    // Update quantity
                    $newQuantity = $existingItem->quantity + $guestItem->quantity;
                    
                    // Check stock
                    if ($this->inventoryService->isInStock($guestItem->variant, $newQuantity)) {
                        $existingItem->update(['quantity' => $newQuantity]);
                    }
                } else {
                    // Move item to user cart
                    $guestItem->update(['cart_id' => $userCart->id]);
                }
            }

            // Delete guest cart
            $guestCart->delete();

            return $userCart->fresh();
        });
    }

    /**
     * Validate cart items (check stock, prices, etc.)
     */
    public function validateCart(Cart $cart): array
    {
        $errors = [];

        foreach ($cart->items as $item) {
            // Check if variant still exists and is active
            if (!$item->variant || !$item->variant->product->is_active) {
                $errors[] = "Product '{$item->variant->product->name}' is no longer available";
                continue;
            }

            // Check stock
            if (!$this->inventoryService->isInStock($item->variant, $item->quantity)) {
                $errors[] = "Insufficient stock for '{$item->variant->product->name}'";
            }

            // Check if price changed significantly (optional warning)
            $currentPrice = $item->variant->price ?? $item->variant->product->base_price;
            if ($currentPrice != $item->price_at_time) {
                $errors[] = "Price changed for '{$item->variant->product->name}'";
            }
        }

        return $errors;
    }

    /**
     * Get cart summary for display
     */
    public function getCartSummary(Cart $cart, ?Coupon $coupon = null, ?float $shippingAmount = 0): array
    {
        $subtotal = $this->getSubtotal($cart);
        $discountAmount = 0;

        if ($coupon) {
            $discountAmount = $this->couponService->calculateDiscount($coupon, $subtotal);
        }

        $total = $subtotal - $discountAmount + $shippingAmount;

        return [
            'items' => $cart->items,
            'item_count' => $this->getItemCount($cart),
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'shipping_amount' => $shippingAmount,
            'total' => $total,
            'coupon' => $coupon,
        ];
    }
}
