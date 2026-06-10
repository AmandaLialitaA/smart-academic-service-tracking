<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMS Smart Tracking')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>
    <div class="topbar-global">
        <div class="topbar-left">
            <i data-lucide="graduation-cap" style="width:20px;height:20px;color:#a259e6;"></i>
            <span class="topbar-title">Smart Academic Service Tracking System UMS</span>
        </div>
        <div class="topbar-right">
            <i data-lucide="bell" class="topbar-notif"></i>
            <div class="topbar-user">
                <span class="topbar-user-name">@yield('topbar_name', 'student')</span>
                <span class="topbar-user-role">@yield('topbar_role', 'UMS Academic')</span>
            </div>
            <img src="https://i.pravatar.cc/36" class="topbar-avatar" alt="avatar">
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
                @yield('content')
            </main>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>