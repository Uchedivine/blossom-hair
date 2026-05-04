@extends('layouts.app')

@section('title', 'Shop Premium Human Hair')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top:60px;padding-bottom:80px;">

    {{-- Header --}}
    <div style="margin-bottom:40px;">
        <p class="label-sm" style="margin-bottom:8px;">
            @if(request('category')) {{ ucfirst(request('category')) }} @else All Products @endif
        </p>
        <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:16px;">
            <div>
                <h1 style="font-family:'Playfair Display',serif;font-size:clamp(28px,5vw,56px);margin:0;background:linear-gradient(135deg,#fff,#fda4af);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.1;">
                    @if(request('category')) {{ ucfirst(request('category')) }}
                    @else All Products @endif
                </h1>
                <p style="font-size:13px;color:rgba(255,255,255,0.35);margin:8px 0 0;">
                    Discover our premium collection of 100% human hair
                </p>
            </div>
            {{-- Sort --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="glass-dark flex items-center gap-2"
                        style="padding:10px 18px;font-size:12px;color:rgba(255,255,255,0.6);border-radius:50px;cursor:pointer;border:none;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="21" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/>
                        <line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="3" y2="18"/>
                    </svg>
                    Sort By
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak
                     class="glass-strong absolute right-0 top-full mt-2 w-48"
                     style="z-index:50;border-radius:16px;overflow:hidden;padding:6px;">
                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), [])) }}"
                       class="block" style="padding:10px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">Featured</a>
                    <a href="{{ route('shop.index', array_merge(request()->all(), ['sort' => 'price_asc'])) }}"
                       class="block" style="padding:10px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">Price: Low to High</a>
                    <a href="{{ route('shop.index', array_merge(request()->all(), ['sort' => 'price_desc'])) }}"
                       class="block" style="padding:10px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">Price: High to Low</a>
                    <a href="{{ route('shop.index', array_merge(request()->all(), ['sort' => 'newest'])) }}"
                       class="block" style="padding:10px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">Newest</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters Row --}}
    <div style="margin-bottom:32px;">
        <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">

            {{-- Category Filter --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="chip {{ request('category') ? 'chip-active' : '' }} flex items-center gap-1.5">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h8M4 18h6"/></svg>
                    Category
                    @if(request('category')): {{ ucfirst(request('category')) }}@endif
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak
                     class="glass-strong absolute left-0 top-full mt-2 w-48"
                     style="z-index:50;border-radius:16px;padding:6px;">
                    <a href="{{ route('shop.index') }}"
                       class="block" style="padding:10px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">All Categories</a>
                    @foreach($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                       class="block" style="padding:10px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Length Filter --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="chip {{ request('length') ? 'chip-active' : '' }} flex items-center gap-1.5">
                    Length @if(request('length')): {{ request('length') }}@endif
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak
                     class="glass-strong absolute left-0 top-full mt-2 w-48"
                     style="z-index:50;border-radius:16px;padding:6px;">
                    <a href="{{ route('shop.index', array_merge(request()->except('length'), [])) }}"
                       class="block" style="padding:9px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">All Lengths</a>
                    @foreach(['10"','12"','14"','16"','18"','20"','22"','24"','26"','28"','30"'] as $length)
                    <a href="{{ route('shop.index', array_merge(request()->all(), ['length' => $length])) }}"
                       class="block" style="padding:9px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">
                        {{ $length }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Texture Filter --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="chip {{ request('texture') ? 'chip-active' : '' }} flex items-center gap-1.5">
                    Texture @if(request('texture')): {{ ucfirst(request('texture')) }}@endif
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak
                     class="glass-strong absolute left-0 top-full mt-2 w-48"
                     style="z-index:50;border-radius:16px;padding:6px;">
                    <a href="{{ route('shop.index', array_merge(request()->except('texture'), [])) }}"
                       class="block" style="padding:9px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">All Textures</a>
                    @foreach(['Straight','Wavy','Curly','Kinky'] as $texture)
                    <a href="{{ route('shop.index', array_merge(request()->all(), ['texture' => strtolower($texture)])) }}"
                       class="block" style="padding:9px 14px;font-size:13px;color:rgba(255,255,255,0.65);text-decoration:none;border-radius:10px;transition:all 0.15s;"
                       onmouseover="this.style.background='rgba(244,63,94,0.12)';this.style.color='#fda4af'"
                       onmouseout="this.style.background='';this.style.color='rgba(255,255,255,0.65)'">
                        {{ $texture }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Active Filters --}}
            @if(request()->hasAny(['category','length','texture']))
                <div style="width:1px;height:20px;background:rgba(255,255,255,0.1);margin:0 4px;"></div>
                @if(request('category'))
                    <a href="{{ route('shop.index', request()->except('category')) }}"
                       class="chip chip-active flex items-center gap-1.5" style="text-decoration:none;">
                        {{ ucfirst(request('category')) }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
                @if(request('length'))
                    <a href="{{ route('shop.index', request()->except('length')) }}"
                       class="chip chip-active flex items-center gap-1.5" style="text-decoration:none;">
                        {{ request('length') }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
                @if(request('texture'))
                    <a href="{{ route('shop.index', request()->except('texture')) }}"
                       class="chip chip-active flex items-center gap-1.5" style="text-decoration:none;">
                        {{ ucfirst(request('texture')) }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
                <a href="{{ route('shop.index') }}"
                   style="font-size:12px;color:rgba(255,255,255,0.35);text-decoration:none;padding:7px 12px;transition:color 0.2s;"
                   onmouseover="this.style.color='#fda4af'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">
                    Clear All
                </a>
            @endif
        </div>
    </div>

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            @include('components.product-card', ['product' => $product])
        @empty
            <div class="col-span-full" style="text-align:center;padding:80px 16px;">
                <div class="glass" style="display:inline-flex;flex-direction:column;align-items:center;padding:48px;border-radius:28px;max-width:400px;">
                    <div style="width:64px;height:64px;background:rgba(244,63,94,0.1);border:1px solid rgba(244,63,94,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                        <svg class="w-7 h-7" style="color:rgba(253,164,175,0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 style="font-family:'Playfair Display',serif;font-size:20px;color:white;margin:0 0 8px;">No products found</h3>
                    <p style="font-size:13px;color:rgba(255,255,255,0.38);margin:0 0 24px;">Try adjusting your filters to find what you're looking for</p>
                    <a href="{{ route('shop.index') }}" class="btn-rose" style="padding:10px 24px;font-size:13px;text-decoration:none;">Clear Filters</a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
        <div style="margin-top:60px;display:flex;justify-content:center;">
            {{ $products->links() }}
        </div>
    @endif

</div>
@endsection