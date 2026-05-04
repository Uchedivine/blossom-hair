@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 16px;position:relative;">

    {{-- Decorative orb --}}
    <div style="position:absolute;width:400px;height:400px;background:radial-gradient(circle,rgba(244,63,94,0.12),transparent 70%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;border-radius:50%;"></div>

    <div style="width:100%;max-width:420px;position:relative;z-index:1;">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:36px;">
            <a href="{{ route('home') }}" style="text-decoration:none;display:inline-block;margin-bottom:20px;">
                <span style="font-family:'Playfair Display',serif;font-size:32px;color:#fda4af;letter-spacing:0.04em;">Blossom</span>
            </a>
            <div style="width:56px;height:56px;background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.22);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg class="w-6 h-6" style="color:#fda4af;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>
            <h1 style="font-family:'Playfair Display',serif;font-size:30px;color:white;margin:0 0 6px;background:linear-gradient(135deg,#fff,#fda4af);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                Welcome Back
            </h1>
            <p style="font-size:13px;color:rgba(255,255,255,0.35);margin:0;">Sign in to your Blossom account</p>
        </div>

        {{-- Card --}}
        <div class="glass-strong" style="padding:32px;border-radius:28px;">

            {{-- Session Status --}}
            @if(session('status'))
            <div style="padding:12px 16px;margin-bottom:20px;border-radius:12px;background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.2);display:flex;align-items:center;gap:8px;">
                <svg class="w-4 h-4 flex-shrink-0" style="color:rgba(74,222,128,0.8);" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span style="font-size:13px;color:rgba(255,255,255,0.7);">{{ session('status') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:18px;">
                @csrf

                {{-- Email --}}
                <div>
                    <span class="label-sm">Email Address</span>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           autofocus
                           placeholder="queen@example.com"
                           class="input-glass {{ $errors->has('email') ? 'input-error' : '' }}">
                    @error('email')
                        <p style="font-size:12px;color:rgba(239,68,68,0.75);margin:6px 0 0;display:flex;align-items:center;gap:4px;">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ showPassword: false }">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <span class="label-sm" style="margin-bottom:0;">Password</span>
                        @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           style="font-size:11px;color:#fda4af;text-decoration:none;transition:opacity 0.2s;"
                           onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                            Forgot password?
                        </a>
                        @endif
                    </div>
                    <div style="position:relative;">
                        <input :type="showPassword ? 'text' : 'password'"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="input-glass {{ $errors->has('password') ? 'input-error' : '' }}"
                               style="padding-right:44px;">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.3);cursor:pointer;padding:4px;transition:color 0.2s;"
                                onmouseover="this.style.color='rgba(255,255,255,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.3)'"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'">
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
                        <p style="font-size:12px;color:rgba(239,68,68,0.75);margin:6px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div style="display:flex;align-items:center;gap:10px;">
                    <div x-data="{ checked: false }"
                         @click="checked = !checked"
                         style="width:18px;height:18px;flex-shrink:0;border-radius:5px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;"
                         :style="checked ? 'background:rgba(244,63,94,0.3);border:1px solid rgba(244,63,94,0.55);' : 'background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.15);'">
                        <input type="checkbox" name="remember" id="remember_me" class="sr-only" :checked="checked">
                        <svg x-show="checked" class="w-3 h-3" style="color:#fda4af;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <label for="remember_me" style="font-size:13px;color:rgba(255,255,255,0.45);cursor:pointer;user-select:none;">Remember me</label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-rose" style="width:100%;padding:14px;font-size:14px;margin-top:4px;">
                    Sign In
                </button>

                {{-- Divider --}}
                <div style="display:flex;align-items:center;gap:12px;margin:4px 0;">
                    <div style="flex:1;height:1px;background:rgba(255,255,255,0.07);"></div>
                    <span style="font-size:11px;color:rgba(255,255,255,0.2);">or continue with</span>
                    <div style="flex:1;height:1px;background:rgba(255,255,255,0.07);"></div>
                </div>

                {{-- Social Logins (if configured) --}}
                <button type="button"
                        class="btn-ghost"
                        style="width:100%;padding:12px;font-size:13px;">
                    <svg style="width:16px;height:16px;" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M5.26 9.77A7.77 7.77 0 0 1 12 4.25c2.1 0 3.97.76 5.42 2l4-4A13.47 13.47 0 0 0 12 0C7.31 0 3.26 2.7 1.28 6.62l3.98 3.15z"/>
                        <path fill="#34A853" d="M16.04 18.01A7.73 7.73 0 0 1 12 19.75c-3.3 0-6.12-2.06-7.29-5l-3.99 3.07C2.97 21.22 7.16 24 12 24c3.52 0 6.71-1.3 9.13-3.41l-5.09-2.58z"/>
                        <path fill="#4A90D9" d="M23.75 12.27c0-.9-.08-1.77-.22-2.61H12v4.95h6.6a5.65 5.65 0 0 1-2.44 3.7l5.09 2.57C22.8 18.82 23.75 15.74 23.75 12.27z"/>
                        <path fill="#FBBC05" d="M4.71 14.75A7.8 7.8 0 0 1 4.25 12c0-.96.17-1.89.46-2.76L.73 6.1A13.46 13.46 0 0 0 0 12c0 2.17.52 4.22 1.44 6.03l3.27-3.28z"/>
                    </svg>
                    Continue with Google
                </button>
            </form>
        </div>

        {{-- Register Link --}}
        <p style="text-align:center;font-size:13px;color:rgba(255,255,255,0.3);margin-top:20px;">
            Don't have an account?
            <a href="{{ route('register') }}"
               style="color:#fda4af;text-decoration:none;font-weight:500;transition:opacity 0.2s;"
               onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                Create one free
            </a>
        </p>
    </div>
</div>
@endsection