@extends('layouts.app')

@section('title', 'Shop Premium Human Hair')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-playfair text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            @if(request('category'))
                {{ ucfirst(request('category')) }}
            @else
                All Products
            @endif
        </h1>
        <p class="text-gray-600">Discover our premium collection of 100% human hair</p>
    </div>

    <!-- Filters & Sort -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <!-- Filters -->
        <div class="flex flex-wrap gap-4">
            <!-- Category Filter -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:border-rose-500 transition">
                    <span>Category</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak class="absolute top-full mt-2 w-48 bg-white border rounded-lg shadow-lg z-10">
                    <a href="{{ route('shop.index') }}" class="block px-4 py-2 hover:bg-rose-50 transition">All Categories</a>
                    @foreach($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="block px-4 py-2 hover:bg-rose-50 transition">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Length Filter -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:border-rose-500 transition">
                    <span>Length</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak class="absolute top-full mt-2 w-48 bg-white border rounded-lg shadow-lg z-10">
                    <a href="{{ route('shop.index', array_merge(request()->except('length'), [])) }}" class="block px-4 py-2 hover:bg-rose-50 transition">All Lengths</a>
                    @foreach(['10"', '12"', '14"', '16"', '18"', '20"', '22"', '24"', '26"', '28"', '30"'] as $length)
                    <a href="{{ route('shop.index', array_merge(request()->all(), ['length' => $length])) }}" class="block px-4 py-2 hover:bg-rose-50 transition">
                        {{ $length }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Texture Filter -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:border-rose-500 transition">
                    <span>Texture</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak class="absolute top-full mt-2 w-48 bg-white border rounded-lg shadow-lg z-10">
                    <a href="{{ route('shop.index', array_merge(request()->except('texture'), [])) }}" class="block px-4 py-2 hover:bg-rose-50 transition">All Textures</a>
                    @foreach(['Straight', 'Wavy', 'Curly', 'Kinky'] as $texture)
                    <a href="{{ route('shop.index', array_merge(request()->all(), ['texture' => strtolower($texture)])) }}" class="block px-4 py-2 hover:bg-rose-50 transition">
                        {{ $texture }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sort -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:border-rose-500 transition">
                <span>Sort By</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" x-cloak class="absolute top-full mt-2 right-0 w-48 bg-white border rounded-lg shadow-lg z-10">
                <a href="{{ route('shop.index', array_merge(request()->except('sort'), [])) }}" class="block px-4 py-2 hover:bg-rose-50 transition">Featured</a>
                <a href="{{ route('shop.index', array_merge(request()->all(), ['sort' => 'price_asc'])) }}" class="block px-4 py-2 hover:bg-rose-50 transition">Price: Low to High</a>
                <a href="{{ route('shop.index', array_merge(request()->all(), ['sort' => 'price_desc'])) }}" class="block px-4 py-2 hover:bg-rose-50 transition">Price: High to Low</a>
                <a href="{{ route('shop.index', array_merge(request()->all(), ['sort' => 'newest'])) }}" class="block px-4 py-2 hover:bg-rose-50 transition">Newest</a>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    @if(request()->hasAny(['category', 'length', 'texture', 'sort']))
    <div class="flex flex-wrap gap-2 mb-8">
        @if(request('category'))
        <span class="inline-flex items-center gap-2 px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-sm">
            Category: {{ ucfirst(request('category')) }}
            <a href="{{ route('shop.index', request()->except('category')) }}" class="hover:text-rose-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </span>
        @endif
        @if(request('length'))
        <span class="inline-flex items-center gap-2 px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-sm">
            Length: {{ request('length') }}
            <a href="{{ route('shop.index', request()->except('length')) }}" class="hover:text-rose-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </span>
        @endif
        @if(request('texture'))
        <span class="inline-flex items-center gap-2 px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-sm">
            Texture: {{ ucfirst(request('texture')) }}
            <a href="{{ route('shop.index', request()->except('texture')) }}" class="hover:text-rose-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </span>
        @endif
        <a href="{{ route('shop.index') }}" class="text-rose-500 text-sm font-semibold hover:text-rose-600">
            Clear All
        </a>
    </div>
    @endif

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            @include('components.product-card', ['product' => $product])
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">No products found</h3>
                <p class="mt-2 text-gray-500">Try adjusting your filters</p>
                <a href="{{ route('shop.index') }}" class="mt-4 inline-block text-rose-500 font-semibold hover:text-rose-600">
                    Clear Filters
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-12">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
