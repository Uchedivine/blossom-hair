@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:60px 16px;position:relative;">

    {{-- Decorative orb --}}
    <div style="position:absolute;width:500px;height:500px;background:radial-gradient(circle,rgba(244,63,94,0.10),transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;border-radius:50%;"></div>

    <div style="width:100%;max-width:460px;position:relative;z-index:1;">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:32px;">
            <a href="{{ route('home') }}" style="text-decoration:none;display:inline-block;margin-bottom:16px;">
                <span style="font-family:'Playfair Display',serif;font-size:32px;color:#fda4af;letter-spacing:0.04em;">Blossom</span>
            </a>
            <div style="width:56px;height:56px;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.22);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <svg class="w-6 h-6" style="color:#fda4af;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                </svg>
            </div>
            <h1 style="font-family:'Playfair Display',serif;font-size:30px;color:white;margin:0 0 6px;background:linear-gradient(135deg,#fff,#fda4af);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                Create Account
            </h1>
            <p style="font-size:13px;color:rgba(255,255,255,0.35);margin:0;">Join the Blossom family today</p>
        </div>

        {{-- Card --}}
        <div class="glass-strong" style="padding:32px;border-radius:28px;">
            <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:16px;">
                @csrf

                {{-- Name Row --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <span class="label-sm">First Name</span>
                        <input type="text"
                               name="first_name"
                               value="{{ old('first_name') }}"
                               required
                               autocomplete="given-name"
                               placeholder="Amara"
                               class="input-glass {{ $errors->has('first_name') ? 'input-error' : '' }}">
                        @error('first_name')
                            <p style="font-size:11px;color:rgba(239,68,68,0.75);margin:4px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <span class="label-sm">Last Name</span>
                        <input type="text"
                               name="last_name"
                               value="{{ old('last_name') }}"
                               required
                               autocomplete="family-name"
                               placeholder="Okafor"
                               class="input-glass {{ $errors->has('last_name') ? 'input-error' : '' }}">
                        @error('last_name')
                            <p style="font-size:11px;color:rgba(239,68,68,0.75);margin:4px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <span class="label-sm">Email Address</span>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           placeholder="amara@example.com"
                           class="input-glass {{ $errors->has('email') ? 'input-error' : '' }}">
                    @error('email')
                        <p style="font-size:11px;color:rgba(239,68,68,0.75);margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <span class="label-sm">Phone Number</span>
                    <input type="tel"
                           name="phone"
                           value="{{ old('phone') }}"
                           autocomplete="tel"
                           placeholder="+234 800 000 0000"
                           class="input-glass {{ $errors->has('phone') ? 'input-error' : '' }}">
                    @error('phone')
                        <p style="font-size:11px;color:rgba(239,68,68,0.75);margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ showPassword: false }">
                    <span class="label-sm">Password</span>
                    <div style="position:relative;">
                        <input :type="showPassword ? 'text' : 'password'"
                               name="password"
                               required
                               autocomplete="new-password"
                               placeholder="Min. 8 characters"
                               class="input-glass {{ $errors->has('password') ? 'input-error' : '' }}"
                               style="padding-right:44px;">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.3);cursor:pointer;padding:4px;transition:color 0.2s;"
                                onmouseover="this.style.color='rgba(255,255,255,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p style="font-size:11px;color:rgba(239,68,68,0.75);margin:4px 0 0;">{{ $message }}</p>
                    @enderror

                    {{-- Password Strength Indicator --}}
                    <div x-data="{ strength: 0 }" style="margin-top:8px;">
                        <div style="display:flex;gap:4px;margin-bottom:4px;">
                            @for($i = 0; $i < 4; $i++)
                            <div style="flex:1;height:3px;border-radius:2px;background:rgba(255,255,255,0.08);transition:background 0.3s;"></div>
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div x-data="{ showPassword: false }">
                    <span class="label-sm">Confirm Password</span>
                    <div style="position:relative;">
                        <input :type="showPassword ? 'text' : 'password'"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               placeholder="Repeat your password"
                               class="input-glass {{ $errors->has('password_confirmation') ? 'input-error' : '' }}"
                               style="padding-right:44px;">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.3);cursor:pointer;padding:4px;transition:color 0.2s;"
                                onmouseover="this.style.color='rgba(255,255,255,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p style="font-size:11px;color:rgba(239,68,68,0.75);margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Terms --}}
                <div x-data="{ agreed: false }" style="display:flex;align-items:flex-start;gap:10px;margin-top:4px;">
                    <div @click="agreed = !agreed"
                         style="width:18px;height:18px;flex-shrink:0;border-radius:5px;cursor:pointer;display:flex;align-items:center;justify-content:center;margin-top:1px;transition:all 0.2s;"
                         :style="agreed ? 'background:rgba(244,63,94,0.28);border:1px solid rgba(244,63,94,0.55);' : 'background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.14);'">
                        <input type="checkbox" name="terms" class="sr-only" :checked="agreed" required>
                        <svg x-show="agreed" class="w-3 h-3" style="color:#fda4af;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <p style="font-size:12px;color:rgba(255,255,255,0.38);line-height:1.6;margin:0;">
                        I agree to the
                        <a href="{{ route('terms') }}" style="color:#fda4af;text-decoration:none;" target="_blank">Terms & Conditions</a>
                        and
                        <a href="{{ route('privacy') }}" style="color:#fda4af;text-decoration:none;" target="_blank">Privacy Policy</a>
                    </p>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-rose" style="width:100%;padding:14px;font-size:14px;margin-top:4px;">
                    Create My Account
                </button>

                {{-- Divider --}}
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="flex:1;height:1px;background:rgba(255,255,255,0.07);"></div>
                    <span style="font-size:11px;color:rgba(255,255,255,0.2);">or</span>
                    <div style="flex:1;height:1px;background:rgba(255,255,255,0.07);"></div>
                </div>

                {{-- Google --}}
                <button type="button" class="btn-ghost" style="width:100%;padding:12px;font-size:13px;">
                    <svg style="width:16px;height:16px;" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M5.26 9.77A7.77 7.77 0 0 1 12 4.25c2.1 0 3.97.76 5.42 2l4-4A13.47 13.47 0 0 0 12 0C7.31 0 3.26 2.7 1.28 6.62l3.98 3.15z"/>
                        <path fill="#34A853" d="M16.04 18.01A7.73 7.73 0 0 1 12 19.75c-3.3 0-6.12-2.06-7.29-5l-3.99 3.07C2.97 21.22 7.16 24 12 24c3.52 0 6.71-1.3 9.13-3.41l-5.09-2.58z"/>
                        <path fill="#4A90D9" d="M23.75 12.27c0-.9-.08-1.77-.22-2.61H12v4.95h6.6a5.65 5.65 0 0 1-2.44 3.7l5.09 2.57C22.8 18.82 23.75 15.74 23.75 12.27z"/>
                        <path fill="#FBBC05" d="M4.71 14.75A7.8 7.8 0 0 1 4.25 12c0-.96.17-1.89.46-2.76L.73 6.1A13.46 13.46 0 0 0 0 12c0 2.17.52 4.22 1.44 6.03l3.27-3.28z"/>
                    </svg>
                    Sign up with Google
                </button>
            </form>
        </div>

        {{-- Login Link --}}
        <p style="text-align:center;font-size:13px;color:rgba(255,255,255,0.3);margin-top:20px;">
            Already have an account?
            <a href="{{ route('login') }}"
               style="color:#fda4af;text-decoration:none;font-weight:500;transition:opacity 0.2s;"
               onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                Sign in
            </a>
        </p>
    </div>
</div>
@endsection