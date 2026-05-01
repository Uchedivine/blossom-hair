<?php

namespace App\Services;

use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class WishlistService
{
    /**
     * Get or create wishlist for current user/session
     */
    public function getWishlist(?User $user = null, ?string $sessionId = null): Wishlist
    {
        $sessionId = $sessionId ?? Session::getId();

        if ($user) {
            return Wishlist::firstOrCreate(
                ['user_id' => $user->id],
                ['session_id' => $sessionId]
            );
        }

        return Wishlist::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => null]
        );
    }

    /**
     * Add product to wishlist
     */
    public function addItem(Product $product, ?User $user = null): WishlistItem
    {
        $wishlist = $this->getWishlist($user);

        // Check if already in wishlist
        $existingItem = $wishlist->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            return $existingItem;
        }

        return $wishlist->items()->create([
            'product_id' => $product->id,
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function removeItem(Product $product, ?User $user = null): bool
    {
        $wishlist = $this->getWishlist($user);

        return $wishlist->items()->where('product_id', $product->id)->delete() > 0;
    }

    /**
     * Check if product is in wishlist
     */
    public function isInWishlist(Product $product, ?User $user = null): bool
    {
        $wishlist = $this->getWishlist($user);

        return $wishlist->items()->where('product_id', $product->id)->exists();
    }

    /**
     * Get wishlist item count
     */
    public function getItemCount(?User $user = null): int
    {
        $wishlist = $this->getWishlist($user);

        return $wishlist->items()->count();
    }

    /**
     * Clear wishlist
     */
    public function clearWishlist(?User $user = null): bool
    {
        $wishlist = $this->getWishlist($user);

        return $wishlist->items()->delete() > 0;
    }

    /**
     * Merge guest wishlist with user wishlist on login
     */
    public function mergeGuestWishlist(User $user, string $guestSessionId): Wishlist
    {
        $guestWishlist = Wishlist::where('session_id', $guestSessionId)
            ->whereNull('user_id')
            ->first();

        if (!$guestWishlist) {
            return $this->getWishlist($user);
        }

        $userWishlist = $this->getWishlist($user);

        foreach ($guestWishlist->items as $guestItem) {
            $existingItem = $userWishlist->items()
                ->where('product_id', $guestItem->product_id)
                ->first();

            if (!$existingItem) {
                $guestItem->update(['wishlist_id' => $userWishlist->id]);
            }
        }

        $guestWishlist->delete();

        return $userWishlist->fresh();
    }
}
