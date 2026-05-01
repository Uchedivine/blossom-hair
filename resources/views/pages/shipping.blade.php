@extends('layouts.app')

@section('title', 'Shipping Policy')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mt-8">
    <h1 class="font-playfair text-4xl font-bold text-gray-900 mb-8">Shipping Policy</h1>
    
    <div class="prose prose-lg max-w-none">
        <h2>Shipping Methods & Delivery Times</h2>
        <p>We offer reliable shipping across Nigeria with the following delivery times:</p>
        <ul>
            <li><strong>Lagos:</strong> 2-3 business days</li>
            <li><strong>Other States:</strong> 3-7 business days</li>
            <li><strong>Express Shipping:</strong> 1-2 business days (Lagos only)</li>
        </ul>

        <h2>Shipping Costs</h2>
        <ul>
            <li>Free shipping on orders over ₦50,000</li>
            <li>Standard shipping: ₦2,500 - ₦5,000 (depending on location)</li>
            <li>Express shipping: ₦7,500</li>
        </ul>

        <h2>Order Processing</h2>
        <p>Orders are processed within 1-2 business days. You will receive a confirmation email with tracking information once your order ships.</p>

        <h2>Tracking Your Order</h2>
        <p>Once shipped, you'll receive a tracking number via email to monitor your delivery status.</p>

        <h2>Delivery Issues</h2>
        <p>If you experience any delivery issues, please contact us at hello@blossomhair.ng within 48 hours of expected delivery.</p>
    </div>
</div>
@endsection
