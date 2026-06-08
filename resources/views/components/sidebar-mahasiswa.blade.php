<div id="sidebarMahasiswa" class="sidebar-mahasiswa">
    <div class="sidebar-header">Smart Academic Service Tracking System UMS</div>
    <nav class="sidebar-menu">
        <ul>
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="/dashboard">
                    <span class="sidebar-icon">&#128200;</span> Dashboard
                </a>
            </li>
            <li class="{{ request()->is('pengajuan') ? 'active' : '' }}">
                <a href="/pengajuan">
                    <span class="sidebar-icon">&#10133;</span> Ajukan Layanan
                </a>
            </li>
            <li class="{{ request()->is('tracking') ? 'active' : '' }}">
                <a href="/tracking">
                    <span class="sidebar-icon">&#128221;</span> Riwayat Pengajuan
                </a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-bottom">
        <a href="#" class="sidebar-settings"><span class="sidebar-icon">&#9881;</span> Settings</a>

        {{-- Logout pakai form POST sesuai route Laravel --}}
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="sidebar-logout" style="background:none; border:none; cursor:pointer; width:100%; text-align:left; padding:0; font:inherit; color:inherit;">
                <span class="sidebar-icon">&#128682;</span> Logout
            </button>
        </form>
    </div>
</div>

<!-- Hamburger Button -->
<button id="sidebarToggle" class="sidebar-hamburger" aria-label="Toggle Sidebar">
    <span></span><span></span><span></span>
</button>

<script>
    const sidebar = document.getElementById('sidebarMahasiswa');
    const toggleBtn = document.getElementById('sidebarToggle');
    function closeSidebarOnOutsideClick(e) {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    }
    toggleBtn.onclick = function() {
        sidebar.classList.toggle('open');
        if (sidebar.classList.contains('open')) {
            document.body.addEventListener('click', closeSidebarOnOutsideClick);
        } else {
            document.body.removeEventListener('click', closeSidebarOnOutsideClick);
        }
    };
</script>