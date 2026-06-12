<aside class="sidebar sidebar-mahasiswa">
    <nav class="sidebar-nav">
        <a href="{{ route('dosen.dashboard') }}" class="{{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="layout-dashboard"></i></span>
            Dashboard
        </a>
        <a href="{{ route('dosen.menunggu') }}" class="{{ request()->routeIs('dosen.menunggu') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="pen-line"></i></span>
            Menunggu TTD
        </a>
        <a href="{{ route('dosen.riwayat') }}" class="{{ request()->routeIs('dosen.riwayat') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="history"></i></span>
            Riwayat
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="{{ route('settings') }}">
            <span class="nav-icon"><i data-lucide="settings"></i></span>
            Settings
        </a>
        <a href="/logout" style="color:#E53935;" onclick="event.preventDefault(); document.getElementById('logout-form-dosen').submit();">
            <span class="nav-icon"><i data-lucide="log-out" style="color:#E53935;"></i></span>
            Logout
        </a>
        <form id="logout-form-dosen" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>
</aside>
