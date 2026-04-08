<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ \App\Models\Company::first()?->name ?? 'Horntech LTD' }}</title>

    <!-- Global CSS & JS (Vite) — Inter font & Bootstrap Icons loaded via app.css + CDN below -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="auth-page-bg">
    <div class="auth-container max-w-[450px] w-full animate-fadeIn">
        <div class="auth-card">
            @php
                $company = \App\Models\Company::first();
            @endphp
            <div class="auth-header-gradient auth-header-border p-5 py-4 text-center text-white">
                <div class="auth-logo flex justify-center mb-6">
                    @if($company && $company->logo)
                        <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-2xl overflow-hidden border-4 border-accent/30 p-2 transform hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset($company->logo) }}" class="w-full h-full object-contain" alt="Logo">
                        </div>
                    @else
                        <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-2xl border-4 border-accent/30 p-2 transform hover:scale-110 transition-transform duration-300">
                            @include('partials.logo_svg', ['width' => 56, 'height' => 56])
                        </div>
                    @endif
                </div>
                <h1 class="auth-title text-2xl font-black tracking-tighter">{{ $company->name ?? 'Horntech LTD' }}</h1>
            </div>

            <div class="auth-body p-5 py-4">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm font-bold rounded-xl px-4 py-3 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-[11px] font-black text-primary uppercase tracking-wider mb-1.5">Email Address</label>
                        <div class="relative">
                            <i class="bi bi-envelope input-icon"></i>
                            <input id="email" class="form-control @error('email') border-red-400 @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@company.com" />
                        </div>
                        @error('email')
                            <p class="text-red-500 font-bold mt-1.5 uppercase text-[0.7rem]">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="block text-[11px] font-black text-primary uppercase tracking-wider">Password</label>
                            @if (Route::has('password.request'))
                                <a class="link-auth text-[0.75rem]" href="{{ route('password.request') }}">Forgot Password?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <i class="bi bi-lock input-icon"></i>
                            <input id="password" class="form-control @error('password') border-red-400 @enderror" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                            <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon')">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 font-bold mt-1.5 uppercase text-[0.7rem]">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-2 mb-4">
                        <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary cursor-pointer accent-primary" name="remember">
                        <label for="remember_me" class="text-sm font-semibold text-primary opacity-60 cursor-pointer">Remember me on this device</label>
                    </div>

                    <button type="submit" class="btn-auth">
                        <i class="bi bi-box-arrow-in-right mr-2"></i>Sign In
                    </button>
                </form>
            </div>

            <div class="auth-footer py-1 px-5 text-center">
                <p class="text-primary opacity-40 m-0 text-[0.75rem]">
                    &copy; {{ date('Y') }} {{ $company->name ?? 'Horntech LTD' }}. All rights reserved.
                </p>
                <a href="{{ route('host.login') }}" class="text-[0.7rem] text-gray-400 hover:text-primary mt-1 inline-block transition-colors">
                    <i class="bi bi-shield-lock me-1"></i>Admin Portal
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>
</html>
