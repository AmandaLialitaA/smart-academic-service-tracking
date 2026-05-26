{{--
    NAVBAR COMPONENT — Smart Academic Service Tracking UMS
    Dipakai di semua role (mahasiswa, dosen, admin)

    CARA PAKAI di blade:
    @include('components.navbar', [
        'userName'  => 'Felix Arlo',
        'userRole'  => 'UMS Academic',
        'userAvatar'=> 'https://randomuser.me/api/portraits/men/32.jpg', // opsional
    ])
--}}

<header class="navbar">
    <div class="navbar-inner">
        {{-- KIRI: Logo --}}
        <div class="navbar-brand">
            <span class="navbar-logo-icon">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" fill="#a259e6"/>
                    <path d="M7 12l5 5 5-5" stroke="#fff" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <span class="navbar-title">Smart Academic Service Tracking System UMS</span>
        </div>

        {{-- KANAN: Notif + User --}}
        <div class="navbar-right">
            {{-- Bell notifikasi --}}
            <button class="navbar-notif" aria-label="Notifikasi">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                    <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"
                            stroke="#a259e6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{-- Badge notif (opsional, bisa dikontrol dari controller) --}}
                @if(!empty($notifCount) && $notifCount > 0)
                    <span class="navbar-notif-badge">{{ $notifCount }}</span>
                @endif
            </button>

            {{-- User info --}}
            <div class="navbar-user">
                <div class="navbar-user-text">
                    <span class="navbar-user-name">{{ $userName ?? 'User' }}</span>
                    <span class="navbar-user-role">{{ $userRole ?? 'UMS Academic' }}</span>
                </div>
                <div class="navbar-avatar">
                    @if(!empty($userAvatar))
                        <img src="{{ $userAvatar }}" alt="Avatar {{ $userName ?? '' }}">
                    @else
                        {{-- Fallback: inisial --}}
                        <span class="navbar-avatar-initial">
                            {{ strtoupper(substr($userName ?? 'U', 0, 1)) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>