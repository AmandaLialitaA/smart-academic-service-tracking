<aside class="sidebar sidebar-mahasiswa">
    <nav class="sidebar-nav">
        <a href="/dosen/dashboard" class="{{ request()->is('dosen/dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="layout-dashboard"></i></span>
            Dashboard
        </a>
        <a href="/dosen/menunggu" class="{{ request()->is('dosen/menunggu') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="pen-line"></i></span>
            Menunggu TTD
        </a>
        <a href="/dosen/riwayat" class="{{ request()->is('dosen/riwayat') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="history"></i></span>
            Riwayat
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="/settings">
            <span class="nav-icon"><i data-lucide="settings"></i></span>
            Settings
        </a>
        <a href="/login" style="color:#E53935;">
            <span class="nav-icon"><i data-lucide="log-out" style="color:#E53935;"></i></span>
            Logout
        </a>
    </div>
</aside>