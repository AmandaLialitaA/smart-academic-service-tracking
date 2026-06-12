<aside class="sidebar sidebar-mahasiswa">
    <nav class="sidebar-nav">
        <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="layout-dashboard"></i></span>
            Dashboard
        </a>
        <a href="/admin/verifikasi" class="{{ request()->is('admin/verifikasi*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="shield-check"></i></span>
            Verifikasi
        </a>
        <a href="/admin/semua-pengajuan" class="{{ request()->is('admin/semua-pengajuan*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="clipboard-list"></i></span>
            Semua Pengajuan
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="/admin/settings">
            <span class="nav-icon"><i data-lucide="settings"></i></span>
            Settings
        </a>
        <a href="/logout" style="color:#E53935;"
           onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
            <span class="nav-icon"><i data-lucide="log-out" style="color:#E53935;"></i></span>
            Logout
        </a>
        <form id="logout-form-admin" action="/logout" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</aside>