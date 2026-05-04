@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="font-playfair text-4xl font-bold text-[#fda4af] mb-8">Privacy Policy</h1>
    
    <div class="prose prose-lg max-w-none">
        <p class="text-gray-600 mb-6">Last updated: {{ date('F d, Y') }}</p>

        <h2>Information We Collect</h2>
        <p>We collect information you provide directly to us, including:</p>
        <ul>
            <li>Name, email address, phone number</li>
            <li>Shipping and billing addresses</li>
            <li>Payment information (processed securely through Paystack)</li>
            <li>Order history and preferences</li>
        </ul>

        <h2>How We Use Your Information</h2>
        <p>We use the information we collect to:</p>
        <ul>
            <li>Process and fulfill your orders</li>
            <li>Communicate with you about your orders</li>
            <li>Send promotional emails (with your consent)</li>
            <li>Improve our products and services</li>
            <li>Prevent fraud and enhance security</li>
        </ul>

        <h2>Information Sharing</h2>
        <p>We do not sell or rent your personal information to third parties. We may share your information with:</p>
        <ul>
            <li>Payment processors (Paystack) to process transactions</li>
            <li>Shipping partners to deliver your orders</li>
            <li>Service providers who assist in our operations</li>
        </ul>

        <h2>Data Security</h2>
        <p>We implement appropriate security measures to protect your personal information. However, no method of transmission over the internet is 100% secure.</p>

        <h2>Your Rights</h2>
        <p>You have the right to:</p>
        <ul>
            <li>Access your personal information</li>
            <li>Correct inaccurate data</li>
            <li>Request deletion of your data</li>
            <li>Opt-out of marketing communications</li>
        </ul>

        <h2>Cookies</h2>
        <p>We use cookies to enhance your browsing experience, analyze site traffic, and personalize content. You can control cookies through your browser settings.</p>

        <h2>Contact Us</h2>
        <p>If you have questions about this Privacy Policy, please contact us at hello@blossomhair.ng</p>
    </div>
</div>
@endsection
