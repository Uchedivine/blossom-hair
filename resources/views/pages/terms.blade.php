@extends('layouts.app')

@section('title', 'Terms & Conditions')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="font-playfair text-4xl font-bold text-[#fda4af] mb-8">Terms & Conditions</h1>
    
    <div class="prose prose-lg max-w-none">
        <p class="text-gray-600 mb-6">Last updated: {{ date('F d, Y') }}</p>

        <h2>Agreement to Terms</h2>
        <p>By accessing and using Blossom Hair's website, you agree to be bound by these Terms and Conditions. If you disagree with any part of these terms, please do not use our website.</p>

        <h2>Products and Pricing</h2>
        <ul>
            <li>All products are subject to availability</li>
            <li>Prices are in Nigerian Naira (₦) and may change without notice</li>
            <li>We reserve the right to limit quantities</li>
            <li>Product images are for illustration purposes and may vary slightly from actual products</li>
        </ul>

        <h2>Orders and Payment</h2>
        <ul>
            <li>All orders are subject to acceptance and availability</li>
            <li>We reserve the right to refuse or cancel any order</li>
            <li>Payment must be received before order processing</li>
            <li>Prices include applicable taxes</li>
        </ul>

        <h2>Shipping and Delivery</h2>
        <p>Delivery times are estimates and not guaranteed. See our Shipping Policy for detailed information.</p>

        <h2>Returns and Refunds</h2>
        <p>Please refer to our Returns Policy for information about returns, exchanges, and refunds.</p>

        <h2>User Accounts</h2>
        <ul>
            <li>You are responsible for maintaining account confidentiality</li>
            <li>You must provide accurate and complete information</li>
            <li>You are responsible for all activities under your account</li>
            <li>We reserve the right to suspend or terminate accounts</li>
        </ul>

        <h2>Intellectual Property</h2>
        <p>All content on this website, including text, images, logos, and designs, is the property of Blossom Hair and protected by copyright laws.</p>

        <h2>Limitation of Liability</h2>
        <p>Blossom Hair shall not be liable for any indirect, incidental, special, or consequential damages arising from the use of our products or services.</p>

        <h2>Governing Law</h2>
        <p>These terms are governed by the laws of the Federal Republic of Nigeria.</p>

        <h2>Changes to Terms</h2>
        <p>We reserve the right to modify these terms at any time. Continued use of the website constitutes acceptance of modified terms.</p>

        <h2>Contact Information</h2>
        <p>For questions about these Terms and Conditions, contact us at hello@blossomhair.ng</p>
    </div>
</div>
@endsection
