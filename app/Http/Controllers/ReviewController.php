<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:1000',
        ]);

        // Check if user already reviewed this product
        if (auth()->check()) {
            $existingReview = Review::where('product_id', $product->id)
                ->where('user_id', auth()->id())
                ->first();

            if ($existingReview) {
                return back()->with('error', 'You have already reviewed this product.');
            }
        }

        // Create review
        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'title' => $request->title,
            'body' => $request->body,
            'is_approved' => false, // Requires admin approval
        ]);

        return back()->with('success', 'Thank you for your review! It will be published after approval.');
    }
}
