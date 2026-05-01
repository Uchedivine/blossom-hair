<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class InventoryService
{
    /**
     * Check if variant has sufficient stock
     */
    public function isInStock(ProductVariant $variant, int $quantity = 1): bool
    {
        return $variant->stock_quantity >= $quantity;
    }

    /**
     * Deduct stock from variant (on order placement)
     */
    public function deductStock(ProductVariant $variant, int $quantity): bool
    {
        if (!$this->isInStock($variant, $quantity)) {
            throw new \Exception("Insufficient stock for variant ID {$variant->id}");
        }

        return DB::transaction(function () use ($variant, $quantity) {
            // Use lockForUpdate to prevent race conditions
            $variant = ProductVariant::where('id', $variant->id)
                ->lockForUpdate()
                ->first();

            if ($variant->stock_quantity < $quantity) {
                throw new \Exception("Insufficient stock for variant ID {$variant->id}");
            }

            $variant->decrement('stock_quantity', $quantity);

            return true;
        });
    }

    /**
     * Restore stock to variant (on order cancellation)
     */
    public function restoreStock(ProductVariant $variant, int $quantity): bool
    {
        return DB::transaction(function () use ($variant, $quantity) {
            $variant = ProductVariant::where('id', $variant->id)
                ->lockForUpdate()
                ->first();

            $variant->increment('stock_quantity', $quantity);

            return true;
        });
    }

    /**
     * Update stock quantity
     */
    public function updateStock(ProductVariant $variant, int $quantity): bool
    {
        if ($quantity < 0) {
            throw new \Exception('Stock quantity cannot be negative');
        }

        return $variant->update(['stock_quantity' => $quantity]);
    }

    /**
     * Get current stock level
     */
    public function getStockLevel(ProductVariant $variant): int
    {
        return $variant->fresh()->stock_quantity;
    }

    /**
     * Get variants with low stock
     */
    public function getLowStockVariants(int $threshold = 10): Collection
    {
        return ProductVariant::with('product')
            ->where('stock_quantity', '<=', $threshold)
            ->where('stock_quantity', '>', 0)
            ->get();
    }

    /**
     * Get out of stock variants
     */
    public function getOutOfStockVariants(): Collection
    {
        return ProductVariant::with('product')
            ->where('stock_quantity', 0)
            ->get();
    }

    /**
     * Check if product has any in-stock variants
     */
    public function hasInStockVariants(Product $product): bool
    {
        return $product->variants()->where('stock_quantity', '>', 0)->exists();
    }

    /**
     * Get total stock for a product (all variants)
     */
    public function getTotalProductStock(Product $product): int
    {
        return $product->variants()->sum('stock_quantity');
    }

    /**
     * Reserve stock temporarily (during checkout)
     * Note: This is a simple implementation. For production, consider using Redis with TTL
     */
    public function reserveStock(ProductVariant $variant, int $quantity, int $minutes = 15): bool
    {
        // For now, we'll just check availability
        // In production, implement proper reservation system with Redis
        return $this->isInStock($variant, $quantity);
    }

    /**
     * Release reserved stock
     */
    public function releaseReservedStock(ProductVariant $variant, int $quantity): bool
    {
        // Placeholder for reservation system
        return true;
    }

    /**
     * Bulk update stock for multiple variants
     */
    public function bulkUpdateStock(array $updates): bool
    {
        return DB::transaction(function () use ($updates) {
            foreach ($updates as $variantId => $quantity) {
                $variant = ProductVariant::findOrFail($variantId);
                $this->updateStock($variant, $quantity);
            }
            return true;
        });
    }

    /**
     * Get stock status label
     */
    public function getStockStatus(ProductVariant $variant): string
    {
        $stock = $variant->stock_quantity;

        if ($stock === 0) {
            return 'Out of Stock';
        } elseif ($stock <= 5) {
            return 'Low Stock';
        } elseif ($stock <= 20) {
            return 'Limited Stock';
        } else {
            return 'In Stock';
        }
    }

    /**
     * Check if stock alert should be sent
     */
    public function shouldSendLowStockAlert(ProductVariant $variant, int $threshold = 10): bool
    {
        return $variant->stock_quantity <= $threshold && $variant->stock_quantity > 0;
    }
}
