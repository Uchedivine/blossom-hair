<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\User;
use App\Models\ShippingZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class OrderService
{
    protected InventoryService $inventoryService;
    protected CouponService $couponService;

    public function __construct(InventoryService $inventoryService, CouponService $couponService)
    {
        $this->inventoryService = $inventoryService;
        $this->couponService = $couponService;
    }

    /**
     * Create order from cart
     */
    public function createOrder(
        Cart $cart,
        Address $shippingAddress,
        ShippingZone $shippingZone,
        ?Coupon $coupon = null,
        ?string $notes = null
    ): Order {
        return DB::transaction(function () use ($cart, $shippingAddress, $shippingZone, $coupon, $notes) {
            // Validate cart has items
            if ($cart->items->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            // Calculate totals
            $totals = $this->calculateTotals($cart, $shippingZone, $coupon);

            // Create order
            $order = Order::create([
                'user_id' => $cart->user_id,
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $totals['subtotal'],
                'discount_amount' => $totals['discount_amount'],
                'shipping_amount' => $totals['shipping_amount'],
                'total' => $totals['total'],
                'coupon_id' => $coupon?->id,
                'shipping_address_id' => $shippingAddress->id,
                'notes' => $notes,
            ]);

            // Create order items and deduct stock
            foreach ($cart->items as $cartItem) {
                // Deduct stock
                $this->inventoryService->deductStock($cartItem->variant, $cartItem->quantity);

                // Create order item with snapshot of product details
                $order->items()->create([
                    'product_variant_id' => $cartItem->product_variant_id,
                    'product_name' => $cartItem->variant->product->name,
                    'variant_details' => [
                        'length' => $cartItem->variant->length,
                        'texture' => $cartItem->variant->texture,
                        'color' => $cartItem->variant->color,
                        'sku' => $cartItem->variant->sku,
                    ],
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->price_at_time,
                    'subtotal' => $cartItem->price_at_time * $cartItem->quantity,
                ]);
            }

            // Increment coupon usage
            if ($coupon) {
                $this->couponService->incrementUsage($coupon);
            }

            // Clear cart
            $cart->items()->delete();

            return $order->fresh(['items', 'user', 'shippingAddress', 'coupon']);
        });
    }

    /**
     * Calculate order totals
     */
    public function calculateTotals(Cart $cart, ShippingZone $shippingZone, ?Coupon $coupon = null): array
    {
        $subtotal = $cart->items->sum(function ($item) {
            return $item->price_at_time * $item->quantity;
        });

        $discountAmount = 0;
        if ($coupon) {
            $discountAmount = $this->couponService->calculateDiscount($coupon, $subtotal);
        }

        $shippingAmount = $shippingZone->rate;
        $total = $subtotal - $discountAmount + $shippingAmount;

        return [
            'subtotal' => round($subtotal, 2),
            'discount_amount' => round($discountAmount, 2),
            'shipping_amount' => round($shippingAmount, 2),
            'total' => round($total, 2),
        ];
    }

    /**
     * Update order status
     */
    public function updateStatus(Order $order, string $status): Order
    {
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            throw new \Exception("Invalid order status: {$status}");
        }

        $order->update(['status' => $status]);

        // Fire events based on status
        // event(new OrderStatusUpdated($order));

        return $order->fresh();
    }

    /**
     * Cancel order and restore stock
     */
    public function cancelOrder(Order $order, ?string $reason = null): Order
    {
        if ($order->status === 'cancelled') {
            throw new \Exception('Order is already cancelled');
        }

        if (in_array($order->status, ['shipped', 'delivered'])) {
            throw new \Exception('Cannot cancel order that has been shipped or delivered');
        }

        return DB::transaction(function () use ($order, $reason) {
            // Restore stock for all items
            foreach ($order->items as $item) {
                $this->inventoryService->restoreStock($item->variant, $item->quantity);
            }

            // Decrement coupon usage
            if ($order->coupon) {
                $this->couponService->decrementUsage($order->coupon);
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'notes' => $order->notes . "\n\nCancellation reason: " . ($reason ?? 'No reason provided'),
            ]);

            return $order->fresh();
        });
    }

    /**
     * Generate unique order number
     */
    public function generateOrderNumber(): string
    {
        $year = date('Y');
        $lastOrder = Order::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastOrder ? ((int) substr($lastOrder->order_number, -4)) + 1 : 1;

        return 'BH-' . $year . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get order by order number
     */
    public function getOrderByNumber(string $orderNumber): ?Order
    {
        return Order::where('order_number', $orderNumber)
            ->with(['items.variant.product', 'user', 'shippingAddress', 'payment', 'coupon'])
            ->first();
    }

    /**
     * Get user orders
     */
    public function getUserOrders(User $user, ?string $status = null): Collection
    {
        $query = Order::where('user_id', $user->id)
            ->with(['items.variant.product', 'payment'])
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    /**
     * Add tracking number to order
     */
    public function addTrackingNumber(Order $order, string $trackingNumber): Order
    {
        $order->update(['tracking_number' => $trackingNumber]);

        // Optionally update status to shipped
        if ($order->status === 'processing') {
            $this->updateStatus($order, 'shipped');
        }

        return $order->fresh();
    }

    /**
     * Get order summary for emails/display
     */
    public function getOrderSummary(Order $order): array
    {
        return [
            'order_number' => $order->order_number,
            'status' => $order->status,
            'customer' => [
                'name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone,
            ],
            'shipping_address' => [
                'name' => $order->shippingAddress->first_name . ' ' . $order->shippingAddress->last_name,
                'address' => $order->shippingAddress->address_line_1,
                'city' => $order->shippingAddress->city,
                'state' => $order->shippingAddress->state,
                'phone' => $order->shippingAddress->phone,
            ],
            'items' => $order->items->map(function ($item) {
                return [
                    'product_name' => $item->product_name,
                    'variant' => $item->variant_details,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->subtotal,
                ];
            }),
            'pricing' => [
                'subtotal' => $order->subtotal,
                'discount' => $order->discount_amount,
                'shipping' => $order->shipping_amount,
                'total' => $order->total,
            ],
            'coupon' => $order->coupon?->code,
            'tracking_number' => $order->tracking_number,
            'created_at' => $order->created_at,
        ];
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(Order $order): bool
    {
        return !in_array($order->status, ['cancelled', 'shipped', 'delivered']);
    }

    /**
     * Get orders by status
     */
    public function getOrdersByStatus(string $status): Collection
    {
        return Order::where('status', $status)
            ->with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
