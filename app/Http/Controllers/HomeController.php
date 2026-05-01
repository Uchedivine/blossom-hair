<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Get featured products
        $featuredProducts = Product::with(['category', 'images', 'variants'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(8)
            ->get();

        // Get main categories (no parent) with a sample product image
        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->withCount('products')
            ->with(['products' => function($query) {
                $query->with('images')
                      ->where('is_active', true)
                      ->limit(1);
            }])
            ->take(4)
            ->get();

        // Get trending products (most recent)
        $trendingProducts = Product::with(['category', 'images', 'variants'])
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'trendingProducts'));
    }
}
