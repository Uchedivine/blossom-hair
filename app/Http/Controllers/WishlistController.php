<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(
        protected WishlistService $wishlistService
    ) {}

    /**
     * Display wishlist page
     */
    public function index()
    {
        $wishlist = $this->wishlistService->getWishlist(auth()->user());
        $products = $wishlist->items()->with(['product.images', 'product.category', 'product.variants', 'product.reviews'])->get()->pluck('product');
        
        // Get array of product IDs in wishlist for state tracking
        $wishlistProductIds = $products->pluck('id')->toArray();

        return view('wishlist.index', compact('products', 'wishlistProductIds'));
    }

    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);
            
            $this->wishlistService->addItem($product, auth()->user());

            return response()->json([
                'success' => true,
                'message' => 'Added to wishlist!',
                'wishlist_count' => $this->wishlistService->getItemCount(auth()->user()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove product from wishlist
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);
            
            $this->wishlistService->removeItem($product, auth()->user());

            return response()->json([
                'success' => true,
                'message' => 'Removed from wishlist',
                'wishlist_count' => $this->wishlistService->getItemCount(auth()->user()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Toggle product in wishlist
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);
            
            $isInWishlist = $this->wishlistService->isInWishlist($product, auth()->user());

            if ($isInWishlist) {
                $this->wishlistService->removeItem($product, auth()->user());
                $message = 'Removed from wishlist';
            } else {
                $this->wishlistService->addItem($product, auth()->user());
                $message = 'Added to wishlist!';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'in_wishlist' => !$isInWishlist,
                'wishlist_count' => $this->wishlistService->getItemCount(auth()->user()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
