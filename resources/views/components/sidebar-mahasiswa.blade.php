<aside class="sidebar sidebar-mahasiswa">
    <nav class="sidebar-nav">
        <a href="{{ route('mahasiswa.dashboard') }}" class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="layout-dashboard"></i></span>
            Dashboard
        </a>
        <a href="{{ route('mahasiswa.pengajuan') }}" class="{{ request()->routeIs('mahasiswa.pengajuan*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="file-plus"></i></span>
            Ajukan Layanan
        </a>
        <a href="{{ route('mahasiswa.riwayat') }}" class="{{ request()->routeIs('mahasiswa.riwayat') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="clock"></i></span>
            Riwayat Pengajuan
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="{{ route('settings') }}">
            <span class="nav-icon"><i data-lucide="settings"></i></span>
            Settings
        </a>
        <a href="/logout" style="color:#E53935;"
           onclick="event.preventDefault(); document.getElementById('logout-form-mhs').submit();">
            <span class="nav-icon"><i data-lucide="log-out" style="color:#E53935;"></i></span>
            Logout
        </a>
        <form id="logout-form-mhs" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</aside>