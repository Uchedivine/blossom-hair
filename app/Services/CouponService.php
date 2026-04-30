<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Collection;

class CouponService
{
    /**
     * Validate coupon code
     */
    public function validateCoupon(string $code, float $subtotal): Coupon
    {
        $coupon = Coupon::where('code', strtoupper($code))->first();

        if (!$coupon) {
            throw new \Exception('Invalid coupon code');
        }

        if (!$coupon->is_active) {
            throw new \Exception('This coupon is not active');
        }

        if ($coupon->starts_at && $coupon->starts_at->isFuture()) {
            throw new \Exception('This coupon is not yet valid');
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            throw new \Exception('This coupon has expired');
        }

        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            throw new \Exception('This coupon has reached its usage limit');
        }

        if ($subtotal < $coupon->min_order_amount) {
            throw new \Exception(
                "Minimum order amount of ₦" . number_format($coupon->min_order_amount, 2) . " required"
            );
        }

        return $coupon;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        if ($coupon->type === 'percentage') {
            $discount = ($subtotal * $coupon->value) / 100;
        } else {
            // Fixed amount
            $discount = min($coupon->value, $subtotal);
        }

        return round($discount, 2);
    }

    /**
     * Apply coupon (validate and calculate)
     */
    public function applyCoupon(string $code, float $subtotal): array
    {
        $coupon = $this->validateCoupon($code, $subtotal);
        $discountAmount = $this->calculateDiscount($coupon, $subtotal);

        return [
            'coupon' => $coupon,
            'discount_amount' => $discountAmount,
            'final_amount' => $subtotal - $discountAmount,
        ];
    }

    /**
     * Increment coupon usage count
     */
    public function incrementUsage(Coupon $coupon): bool
    {
        return $coupon->increment('used_count');
    }

    /**
     * Decrement coupon usage count (on order cancellation)
     */
    public function decrementUsage(Coupon $coupon): bool
    {
        if ($coupon->used_count > 0) {
            return $coupon->decrement('used_count');
        }
        return false;
    }

    /**
     * Check if coupon is valid (without throwing exceptions)
     */
    public function isValid(Coupon $coupon, float $subtotal): bool
    {
        try {
            $this->validateCoupon($coupon->code, $subtotal);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get all active coupons
     */
    public function getActiveCoupons(): Collection
    {
        return Coupon::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('used_count < max_uses');
            })
            ->get();
    }

    /**
     * Get coupon by code
     */
    public function getCouponByCode(string $code): ?Coupon
    {
        return Coupon::where('code', strtoupper($code))->first();
    }

    /**
     * Check if user can use coupon (for future user-specific coupons)
     */
    public function canUserUseCoupon(User $user, Coupon $coupon): bool
    {
        // For now, all users can use all coupons
        // In future, implement user-specific coupon logic
        return true;
    }

    /**
     * Get coupon usage percentage
     */
    public function getUsagePercentage(Coupon $coupon): ?float
    {
        if (!$coupon->max_uses) {
            return null;
        }

        return ($coupon->used_count / $coupon->max_uses) * 100;
    }

    /**
     * Check if coupon is about to expire (within days)
     */
    public function isExpiringWithin(Coupon $coupon, int $days = 7): bool
    {
        if (!$coupon->expires_at) {
            return false;
        }

        return $coupon->expires_at->diffInDays(now()) <= $days && $coupon->expires_at->isFuture();
    }

    /**
     * Get coupon display text
     */
    public function getDisplayText(Coupon $coupon): string
    {
        if ($coupon->type === 'percentage') {
            return "{$coupon->value}% OFF";
        } else {
            return "₦" . number_format($coupon->value, 2) . " OFF";
        }
    }
}
