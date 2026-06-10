<aside class="sidebar sidebar-mahasiswa">
    <nav class="sidebar-nav">
        <a href="{{ route('dosen.dashboard') }}" class="{{ request()->is('dosen/dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="layout-dashboard"></i></span>
            Dashboard
        </a>
        <a href="{{ route('dosen.verifikasi') }}" class="{{ request()->is('dosen/verifikasi') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="pen-line"></i></span>
            Menunggu TTD
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="#">
            <span class="nav-icon"><i data-lucide="settings"></i></span>
            Settings
        </a>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;font:inherit;color:#E53935;display:flex;align-items:center;gap:6px;width:100%;">
                <span class="nav-icon"><i data-lucide="log-out" style="color:#E53935;"></i></span>
                Logout
            </button>
        </form>
    </div>
</aside>