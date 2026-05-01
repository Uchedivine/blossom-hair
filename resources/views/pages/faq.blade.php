@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="bg-gradient-to-br from-rose-50 to-pink-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="font-playfair text-5xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Find answers to common questions about our products and services
            </p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mt-8">
    <div class="space-y-4" x-data="{ openFaq: null }">
        <!-- FAQ Item 1 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <button @click="openFaq = openFaq === 1 ? null : 1" 
                    class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                <span class="font-semibold text-lg text-gray-900">Is your hair 100% human hair?</span>
                <svg class="w-5 h-5 text-rose-500 transition-transform" 
                     :class="openFaq === 1 ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 1" 
                 x-collapse
                 class="px-6 pb-4">
                <p class="text-gray-600">
                    Yes! All our hair products are 100% authentic human hair. We source only the finest quality hair and each bundle is carefully inspected before shipping to ensure it meets our high standards.
                </p>
            </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <button @click="openFaq = openFaq === 2 ? null : 2" 
                    class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                <span class="font-semibold text-lg text-gray-900">How long does shipping take?</span>
                <svg class="w-5 h-5 text-rose-500 transition-transform" 
                     :class="openFaq === 2 ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 2" 
                 x-collapse
                 class="px-6 pb-4">
                <p class="text-gray-600">
                    Delivery typically takes 2-5 business days within Lagos and 3-7 business days for other states in Nigeria. Express shipping options are available at checkout for faster delivery.
                </p>
            </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <button @click="openFaq = openFaq === 3 ? null : 3" 
                    class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                <span class="font-semibold text-lg text-gray-900">Can I return or exchange my order?</span>
                <svg class="w-5 h-5 text-rose-500 transition-transform" 
                     :class="openFaq === 3 ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 3" 
                 x-collapse
                 class="px-6 pb-4">
                <p class="text-gray-600">
                    Yes, we offer a 7-day return policy for unopened and unused products in their original packaging. Please see our Returns Policy page for full details and conditions.
                </p>
            </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <button @click="openFaq = openFaq === 4 ? null : 4" 
                    class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                <span class="font-semibold text-lg text-gray-900">How do I care for my hair extensions?</span>
                <svg class="w-5 h-5 text-rose-500 transition-transform" 
                     :class="openFaq === 4 ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 4" 
                 x-collapse
                 class="px-6 pb-4">
                <div class="text-gray-600 space-y-2">
                    <p>To maintain your hair extensions:</p>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>Wash with sulfate-free shampoo and conditioner</li>
                        <li>Use a wide-tooth comb to detangle gently</li>
                        <li>Air dry when possible or use low heat settings</li>
                        <li>Apply leave-in conditioner or hair oil regularly</li>
                        <li>Store properly when not in use</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <button @click="openFaq = openFaq === 5 ? null : 5" 
                    class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                <span class="font-semibold text-lg text-gray-900">Can I dye or color the hair?</span>
                <svg class="w-5 h-5 text-rose-500 transition-transform" 
                     :class="openFaq === 5 ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 5" 
                 x-collapse
                 class="px-6 pb-4">
                <p class="text-gray-600">
                    Yes! Since our hair is 100% human hair, you can dye, bleach, or color it just like your natural hair. We recommend having it done by a professional stylist for best results.
                </p>
            </div>
        </div>

        <!-- FAQ Item 6 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <button @click="openFaq = openFaq === 6 ? null : 6" 
                    class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                <span class="font-semibold text-lg text-gray-900">How many bundles do I need?</span>
                <svg class="w-5 h-5 text-rose-500 transition-transform" 
                     :class="openFaq === 6 ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 6" 
                 x-collapse
                 class="px-6 pb-4">
                <div class="text-gray-600 space-y-2">
                    <p>The number of bundles depends on the length and desired fullness:</p>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>8-14 inches: 2-3 bundles</li>
                        <li>16-20 inches: 3-4 bundles</li>
                        <li>22-28 inches: 4-5 bundles</li>
                    </ul>
                    <p class="mt-2">For a fuller look, we recommend adding an extra bundle.</p>
                </div>
            </div>
        </div>

        <!-- FAQ Item 7 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <button @click="openFaq = openFaq === 7 ? null : 7" 
                    class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                <span class="font-semibold text-lg text-gray-900">What payment methods do you accept?</span>
                <svg class="w-5 h-5 text-rose-500 transition-transform" 
                     :class="openFaq === 7 ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 7" 
                 x-collapse
                 class="px-6 pb-4">
                <p class="text-gray-600">
                    We accept all major payment methods through Paystack including credit/debit cards (Visa, Mastercard, Verve), bank transfers, and USSD. All payments are secure and encrypted.
                </p>
            </div>
        </div>

        <!-- FAQ Item 8 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <button @click="openFaq = openFaq === 8 ? null : 8" 
                    class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                <span class="font-semibold text-lg text-gray-900">Do you offer wholesale prices?</span>
                <svg class="w-5 h-5 text-rose-500 transition-transform" 
                     :class="openFaq === 8 ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 8" 
                 x-collapse
                 class="px-6 pb-4">
                <p class="text-gray-600">
                    Yes, we offer wholesale pricing for bulk orders. Please contact us directly at hello@blossomhair.ng with your requirements and we'll provide you with a custom quote.
                </p>
            </div>
        </div>
    </div>

    <!-- Still Have Questions -->
    <div class="mt-12 text-center bg-gradient-to-br from-rose-50 to-pink-50 rounded-3xl p-12">
        <h2 class="font-playfair text-3xl font-bold text-gray-900 mb-4">Still Have Questions?</h2>
        <p class="text-gray-600 mb-6">Can't find the answer you're looking for? We're here to help!</p>
        <a href="{{ route('contact') }}" class="inline-block bg-rose-500 text-white px-8 py-4 rounded-full font-semibold hover:bg-rose-600 transition transform hover:scale-105 shadow-lg">
            Contact Us
        </a>
    </div>
</div>
@endsection
