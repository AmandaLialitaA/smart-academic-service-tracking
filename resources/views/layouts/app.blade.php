<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMS Smart Tracking')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/realtime-extra.css') }}">
</head>
<body>
    @php
        $authUser = auth()->user();
        $topbarName = $authUser?->name ?? 'Pengguna';
        $topbarRole = $authUser?->roleLabel() ?? 'UMS Academic';
    @endphp
    <div class="topbar-global">
        <div class="topbar-left">
            <div class="topbar-brand-icon" aria-hidden="true">
                <svg viewBox="0 0 32 32" width="28" height="28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="6" width="28" height="20" rx="3" fill="#a259e6" opacity="0.15"/>
                    <path d="M16 8L6 14v2l10 6 10-6v-2L16 8z" fill="#a259e6"/>
                    <path d="M6 18l10 6 10-6" stroke="#7c3aed" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="topbar-title">Smart Academic Service Tracking System UMS</span>
        </div>
        <div class="topbar-right">
            <div class="live-clock-box">
                <span id="live-clock"></span>
                <span id="live-date"></span>
            </div>

            <div style="position: relative; display: flex; align-items: center;">
                <i data-lucide="bell" class="topbar-notif"></i>
                <span class="notif-dot" id="notif-dot" style="display:none;"></span>
            </div>

            <div class="topbar-user">
                <span class="topbar-user-name" id="topbar-user-name">{{ $topbarName }}</span>
                <span class="topbar-user-role" id="topbar-user-role">{{ $topbarRole }}</span>
            </div>
            <img src="https://i.pravatar.cc/36?u={{ $authUser?->id ?? 'guest' }}" class="topbar-avatar" alt="avatar">
        </div>
    </div>

    <div class="main-layout">
        <aside class="sidebar">
            @yield('sidebar')
        </aside>
        <div class="main-content">
            @hasSection('navbar')
                <nav class="navbar">
                    @yield('navbar')
                </nav>
            @endif
            <main>
                @if(session('success'))
                    <div class="flash-message flash-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="flash-message flash-error">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script>lucide.createIcons();</script>
    <script src="{{ asset('js/realtime.js') }}"></script>
</body>
</html>
