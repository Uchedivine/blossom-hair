<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    /**
     * Display cart page
     */
    public function index()
    {
        try {
            $cart = $this->cartService->getCart(auth()->user());
            $summary = $this->cartService->getCartSummary($cart);

            return view('cart.index', compact('cart', 'summary'));
        } catch (\Exception $e) {
            // If there's any error, show empty cart
            $cart = null;
            $summary = [
                'items' => collect([]),
                'item_count' => 0,
                'subtotal' => 0,
                'discount_amount' => 0,
                'shipping_amount' => 0,
                'total' => 0,
                'coupon' => null,
            ];

            return view('cart.index', compact('cart', 'summary'));
        }
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $variant = ProductVariant::findOrFail($request->variant_id);
            
            $this->cartService->addItem(
                $variant,
                $request->quantity,
                auth()->user()
            );

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $this->cartService->getItemCount(
                    $this->cartService->getCart(auth()->user())
                ),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cart = $this->cartService->getCart(auth()->user());
            $cartItem = $cart->items()->where('id', $request->item_id)->firstOrFail();

            $this->cartService->updateQuantity($cartItem, $request->quantity);

            // Redirect back to cart page with success message
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove item from cart
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
        ]);

        try {
            $cart = $this->cartService->getCart(auth()->user());
            $cartItem = $cart->items()->where('id', $request->item_id)->firstOrFail();

            $this->cartService->removeItem($cartItem);

            // Redirect back to cart page with success message
            return redirect()->route('cart.index')->with('success', 'Item removed from cart successfully!');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }
}
