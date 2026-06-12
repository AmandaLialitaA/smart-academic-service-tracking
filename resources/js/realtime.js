/* =============================================================
   REALTIME.JS
   Helper untuk fitur real-time di Smart Academic UMS:
   1. Jam & tanggal berjalan di topbar
   2. Status pengajuan auto-update (polling)
   3. Notifikasi badge (lonceng) auto-update
   4. Progress bar tracking bergerak otomatis

   Cara pakai: tinggal include file ini di layouts/app.blade.php
   sebelum </body>:
   <script src="{{ asset('js/realtime.js') }}"></script>
   ============================================================= */

document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       1) JAM & TANGGAL BERJALAN
       Tambahkan elemen ini di topbar:
       <span id="live-clock"></span>
       <span id="live-date"></span>
       ========================================================= */
    function updateClock() {
        const now = new Date();

        const clockEl = document.getElementById('live-clock');
        const dateEl  = document.getElementById('live-date');

        if (clockEl) {
            clockEl.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        }
        if (dateEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
            });
        }
    }
    updateClock();
    setInterval(updateClock, 1000);


    /* =========================================================
       2) NOTIFIKASI BADGE (LONCENG) AUTO-UPDATE
       Elemen lonceng harus punya:
       <button class="notif-btn">
           <i data-lucide="bell"></i>
           <span class="notif-dot" id="notif-dot" style="display:none;"></span>
       </button>

       Polling ke endpoint backend:
       GET /api/notifications/unread-count -> { "count": 2 }

       Untuk demo (tanpa backend), pakai localStorage sebagai
       sumber data sementara.
       ========================================================= */
    const NOTIF_ENDPOINT = '/api/notifications/unread-count';
    const notifDot = document.getElementById('notif-dot');

    function updateNotifBadge(count) {
        if (!notifDot) return;
        notifDot.style.display = count > 0 ? 'block' : 'none';
        notifDot.setAttribute('data-count', count);
    }

    async function pollNotifications() {
        try {
            const res = await fetch(NOTIF_ENDPOINT, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('not ok');
            const data = await res.json();
            updateNotifBadge(data.count ?? 0);
        } catch (e) {
            // Fallback demo: baca dari localStorage (key: "demo_notif_count")
            const demoCount = parseInt(localStorage.getItem('demo_notif_count') || '1', 10);
            updateNotifBadge(demoCount);
        }
    }

    if (notifDot) {
        pollNotifications();
        setInterval(pollNotifications, 15000); // cek tiap 15 detik
    }


    /* =========================================================
       3) STATUS PENGAJUAN AUTO-UPDATE (tanpa refresh halaman)
       Setiap baris tabel / kartu status diberi atribut:
       <span class="status-badge" data-id="REQ-2024-009" data-status="submitted">...</span>

       Polling ke endpoint:
       GET /api/pengajuan/status?ids=REQ-2024-009,REQ-2024-005
       Response: { "REQ-2024-009": "waiting", "REQ-2024-005": "completed" }

       Fallback demo: simulasi acak biar terlihat "hidup".
       ========================================================= */
    const STATUS_ENDPOINT = '/api/pengajuan/status';
    const statusBadges = document.querySelectorAll('.status-badge[data-id]');

    const STATUS_LABEL = {
        submitted: 'Submitted',
        waiting:   'Waiting',
        completed: 'Completed',
        rejected:  'Rejected',
    };
    const STATUS_CLASS = ['completed', 'waiting', 'submitted', 'rejected'];

    function setBadgeStatus(badge, status) {
        if (!STATUS_LABEL[status]) return;
        STATUS_CLASS.forEach(c => badge.classList.remove(c));
        badge.classList.add(status);
        badge.textContent = STATUS_LABEL[status];
        badge.dataset.status = status;

        // efek flash supaya user tahu ada perubahan
        badge.classList.add('status-flash');
        setTimeout(() => badge.classList.remove('status-flash'), 1000);
    }

    async function pollStatus() {
        if (statusBadges.length === 0) return;

        const ids = Array.from(statusBadges).map(b => b.dataset.id).join(',');

        try {
            const res = await fetch(`${STATUS_ENDPOINT}?ids=${encodeURIComponent(ids)}`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) throw new Error('not ok');
            const data = await res.json();

            statusBadges.forEach(badge => {
                const newStatus = data[badge.dataset.id];
                if (newStatus && newStatus !== badge.dataset.status) {
                    setBadgeStatus(badge, newStatus);
                }
            });
        } catch (e) {
            // tidak ada backend — skip silent
        }
    }

    if (statusBadges.length > 0) {
        setInterval(pollStatus, 10000); // cek tiap 10 detik
    }


    /* =========================================================
       4) PROGRESS BAR TRACKING — BERGERAK OTOMATIS
       Elemen progress bar:
       <div class="progress-bar-bg">
           <div class="progress-bar" id="progress-bar" style="width:0%"></div>
       </div>
       <span class="progress-pct" id="progress-pct">0%</span>

       data-target diisi dari backend (persentase asli).
       Animasi mengisi dari 0 -> target secara halus.
       ========================================================= */
    const progressBar = document.getElementById('progress-bar');
    const progressPct = document.getElementById('progress-pct');

    if (progressBar) {
        const target = parseInt(progressBar.dataset.target || progressBar.style.width || '0', 10);
        let current = 0;

        const animateProgress = setInterval(() => {
            current += 1;
            if (current >= target) {
                current = target;
                clearInterval(animateProgress);
            }
            progressBar.style.width = current + '%';
            if (progressPct) progressPct.textContent = current + '%';
        }, 15); // makin kecil = makin cepat
    }

});