<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMS Smart Tracking')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
</head>
<body>
    <div class="main-layout">
        <aside class="sidebar">
            <!-- Sidebar content, bisa di-@section('sidebar') untuk custom per halaman -->
            @yield('sidebar')
        </aside>
        <div class="main-content">
            <nav class="navbar">
                <!-- Navbar content, bisa di-@section('navbar') untuk custom per halaman -->
                @yield('navbar')
            </nav>
            <main>
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
