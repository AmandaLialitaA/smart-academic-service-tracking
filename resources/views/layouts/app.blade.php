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
@hasSection('sidebar')
    <div class="main-layout">
        <aside class="sidebar">
            @yield('sidebar')
        </aside>
        <div class="main-content">
            <nav class="navbar">
                @yield('navbar')
            </nav>
            <main>
                @if(session('success'))
                    <div class="alert alert-success">✔ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">✘ {{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin:0;padding-left:20px;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
@else
    {{-- Landing / halaman full-width --}}
    @if(session('success'))
        <div class="alert alert-success" style="position:fixed;top:12px;right:12px;z-index:9999;max-width:400px;">
            ✔ {{ session('success') }}
        </div>
    @endif
    @yield('content')
@endif
</body>
</html>