<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ \App\Models\Company::first()?->name ?? 'Horntech LTD' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        .tab-switcher {
            display: flex;
            background: rgba(255,255,255,0.12);
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 1.5rem;
        }
        .tab-btn {
            flex: 1;
            border: none;
            background: transparent;
            border-radius: 7px;
            padding: .55rem .5rem;
            font-size: .875rem;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            cursor: pointer;
            transition: background .2s, color .2s, box-shadow .2s;
        }
        .tab-btn.active {
            background: #fff;
            color: #004161;
            box-shadow: 0 1px 6px rgba(0,0,0,.18);
        }
    </style>
</head>
<body class="auth-page-bg">
@php
    $company = \App\Models\Company::first();
    $activeTab = ($errors->has('company_name') || $errors->has('name') || session('register_attempted')) ? 'register' : 'login';
@endphp

<div class="auth-container max-w-[450px] w-full animate-fadeIn">
    <div class="auth-card">

        <!-- Header -->
        <div class="auth-header-gradient auth-header-border p-5 py-4 text-center text-white">
            <div class="auth-logo flex justify-center mb-4">
                @if($company && $company->logo)
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-xl overflow-hidden border-4 border-accent/30 p-1.5">
                        <img src="{{ asset($company->logo) }}" class="w-full h-full object-contain" alt="Logo">
                    </div>
                @else
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-xl border-4 border-accent/30 p-1.5">
                        @include('partials.logo_svg', ['width' => 44, 'height' => 44])
                    </div>
                @endif
            </div>
            <h1 class="text-2xl font-black tracking-tighter mb-0">{{ $company->name ?? 'Horntech LTD' }}</h1>
            <p class="text-white/60 text-sm mt-1 mb-3">Accounting SaaS for modern teams</p>

            <!-- Tab Switcher -->
            <div class="tab-switcher">
                <button class="tab-btn {{ $activeTab === 'login' ? 'active' : '' }}" id="tab-signin" onclick="switchTab('login')">Sign In</button>
                <button class="tab-btn {{ $activeTab === 'register' ? 'active' : '' }}" id="tab-register" onclick="switchTab('register')">Create Account</button>
            </div>
        </div>

        <!-- Body -->
        <div class="auth-body p-5 py-4">

            @if (session('status'))
                <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm font-bold rounded-xl px-4 py-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- ── Sign In Form ── -->
            <div id="form-login" style="{{ $activeTab === 'register' ? 'display:none' : '' }}">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-[11px] font-black text-primary uppercase tracking-wider mb-1.5">Email Address</label>
                        <div class="relative">
                            <i class="bi bi-envelope input-icon"></i>
                            <input id="email" class="form-control @error('email') border-red-400 @enderror" type="email" name="email"
                                   value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@company.com">
                        </div>
                        @error('email')
                            <p class="text-red-500 font-bold mt-1.5 uppercase text-[0.7rem]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="block text-[11px] font-black text-primary uppercase tracking-wider">Password</label>
                            @if (Route::has('password.request'))
                                <a class="link-auth text-[0.75rem]" href="{{ route('password.request') }}">Forgot Password?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <i class="bi bi-lock input-icon"></i>
                            <input id="password" class="form-control @error('password') border-red-400 @enderror" type="password" name="password"
                                   required autocomplete="current-password" placeholder="••••••••">
                            <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon')">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 font-bold mt-1.5 uppercase text-[0.7rem]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 cursor-pointer accent-primary" name="remember">
                        <label for="remember_me" class="text-sm font-semibold text-primary opacity-60 cursor-pointer">Remember me on this device</label>
                    </div>

                    <button type="submit" class="btn-auth">
                        <i class="bi bi-box-arrow-in-right mr-2"></i>Sign In
                    </button>
                </form>
            </div>

            <!-- ── Create Account Form ── -->
            <div id="form-register" style="{{ $activeTab === 'login' ? 'display:none' : '' }}">
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-[11px] font-black text-primary uppercase tracking-wider mb-1.5">Company Name</label>
                        <div class="relative">
                            <i class="bi bi-building input-icon"></i>
                            <input type="text" name="company_name"
                                   class="form-control @error('company_name') border-red-400 @enderror"
                                   placeholder="Enter your company name"
                                   value="{{ old('company_name') }}" required>
                        </div>
                        @error('company_name')
                            <p class="text-red-500 font-bold mt-1.5 uppercase text-[0.7rem]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-[11px] font-black text-primary uppercase tracking-wider mb-1.5">Your Name</label>
                        <div class="relative">
                            <i class="bi bi-person input-icon"></i>
                            <input type="text" name="name"
                                   class="form-control @error('name') border-red-400 @enderror"
                                   placeholder="Enter your name"
                                   value="{{ old('name') }}" required autocomplete="name">
                        </div>
                        @error('name')
                            <p class="text-red-500 font-bold mt-1.5 uppercase text-[0.7rem]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-[11px] font-black text-primary uppercase tracking-wider mb-1.5">Email</label>
                        <div class="relative">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" name="email"
                                   class="form-control @error('email') border-red-400 @enderror"
                                   placeholder="you@gmail.com"
                                   value="{{ old('email') }}" required autocomplete="username">
                        </div>
                        @error('email')
                            <p class="text-red-500 font-bold mt-1.5 uppercase text-[0.7rem]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-[11px] font-black text-primary uppercase tracking-wider mb-1.5">Password</label>
                        <div class="relative">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password" id="reg-password"
                                   class="form-control @error('password') border-red-400 @enderror"
                                   placeholder="••••••••" required autocomplete="new-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('reg-password', 'regToggleIcon')">
                                <i class="bi bi-eye" id="regToggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 font-bold mt-1.5 uppercase text-[0.7rem]">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" name="password_confirmation" id="reg-password-confirm">

                    <button type="submit" class="btn-auth">
                        <i class="bi bi-rocket-takeoff mr-2"></i>Create Account &amp; Start
                    </button>
                </form>
            </div>

        </div>

        <!-- Footer -->
        <div class="auth-footer py-2 px-5 text-center">
            <div id="footer-login" style="{{ $activeTab === 'register' ? 'display:none' : '' }}">
                <p class="text-primary opacity-40 m-0 text-[0.75rem]">
                    &copy; {{ date('Y') }} {{ $company->name ?? 'Horntech LTD' }}. All rights reserved.
                </p>
            </div>
            <div id="footer-register" style="{{ $activeTab === 'login' ? 'display:none' : '' }}">
                <p class="text-primary opacity-50 m-0 text-[0.75rem]">
                    25 chart of accounts will be seeded automatically on registration.
                </p>
            </div>
            <a href="{{ route('host.login') }}" class="text-[0.7rem] text-gray-400 hover:text-primary mt-1 inline-block transition-colors">
                <i class="bi bi-shield-lock me-1"></i>Admin Portal
            </a>
        </div>

    </div>
</div>

<script>
    function switchTab(tab) {
        const isLogin = tab === 'login';
        document.getElementById('form-login').style.display    = isLogin ? '' : 'none';
        document.getElementById('form-register').style.display = isLogin ? 'none' : '';
        document.getElementById('footer-login').style.display    = isLogin ? '' : 'none';
        document.getElementById('footer-register').style.display = isLogin ? 'none' : '';
        document.getElementById('tab-signin').classList.toggle('active', isLogin);
        document.getElementById('tab-register').classList.toggle('active', !isLogin);
    }

    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    // Mirror password into hidden confirmation field
    document.getElementById('reg-password').addEventListener('input', function () {
        document.getElementById('reg-password-confirm').value = this.value;
    });
</script>
</body>
</html>
