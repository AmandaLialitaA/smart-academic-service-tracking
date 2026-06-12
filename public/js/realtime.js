document.addEventListener('DOMContentLoaded', function () {

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

    const NOTIF_ENDPOINT = '/api/notifications/unread-count';
    const notifDot = document.getElementById('notif-dot');

    function updateNotifBadge(count) {
        if (!notifDot) return;
        notifDot.style.display = count > 0 ? 'block' : 'none';
        notifDot.setAttribute('data-count', count);
    }

    async function pollNotifications() {
        try {
            const res = await fetch(NOTIF_ENDPOINT, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            });
            if (!res.ok) throw new Error('not ok');
            const data = await res.json();
            updateNotifBadge(data.count ?? 0);
        } catch (e) {
            updateNotifBadge(0);
        }
    }

    if (notifDot) {
        pollNotifications();
        setInterval(pollNotifications, 15000);
    }

    const STATUS_ENDPOINT = '/api/pengajuan/status';
    const STATUS_CLASS = ['completed', 'waiting', 'submitted', 'rejected', 'ttd'];

    function setBadgeStatus(badge, data) {
        const display = typeof data === 'string' ? data : (data.display || data);
        const label   = typeof data === 'object' && data.label
            ? data.label
            : (badge.dataset.label || display);
        const cssClass = typeof data === 'object' && data.class ? data.class : display;

        STATUS_CLASS.forEach(c => badge.classList.remove(c));
        badge.classList.add(cssClass);
        badge.textContent = label;
        badge.dataset.status = display;
        if (typeof data === 'object' && data.label) badge.dataset.label = data.label;
        if (typeof data === 'object' && data.backend) badge.dataset.backend = data.backend;

        badge.classList.add('status-flash');
        setTimeout(() => badge.classList.remove('status-flash'), 1000);
    }

    async function pollStatus() {
        const statusBadges = document.querySelectorAll('.status-badge[data-id]');
        if (statusBadges.length === 0) return;

        const ids = Array.from(statusBadges).map(b => b.dataset.id).join(',');

        try {
            const res = await fetch(`${STATUS_ENDPOINT}?ids=${encodeURIComponent(ids)}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            });
            if (!res.ok) throw new Error('not ok');
            const data = await res.json();

            statusBadges.forEach(badge => {
                const payload = data[badge.dataset.id];
                if (!payload) return;
                const display = typeof payload === 'object' ? payload.display : payload;
                if (display !== badge.dataset.status || (typeof payload === 'object' && payload.label !== badge.textContent)) {
                    setBadgeStatus(badge, payload);
                }
            });
        } catch (e) { /* silent */ }
    }

    setInterval(pollStatus, 10000);
    pollStatus();

    const STATS_ENDPOINT = '/api/dashboard/stats';

    async function pollDashboardStats() {
        try {
            const res = await fetch(STATS_ENDPOINT, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            });
            if (!res.ok) return;
            const data = await res.json();

            Object.keys(data).forEach(key => {
                const el = document.querySelector(`[data-stat="${key}"]`);
                if (el) el.textContent = data[key];
            });
        } catch (e) { /* silent */ }
    }

    if (document.querySelector('[data-stat]')) {
        pollDashboardStats();
        setInterval(pollDashboardStats, 12000);
    }

    const progressBar = document.getElementById('progress-bar');
    const progressPct = document.getElementById('progress-pct');

    if (progressBar) {
        const target = parseInt(progressBar.dataset.target || '0', 10);
        let current = 0;
        const animateProgress = setInterval(() => {
            current += 1;
            if (current >= target) {
                current = target;
                clearInterval(animateProgress);
            }
            progressBar.style.width = current + '%';
            if (progressPct) progressPct.textContent = current + '%';
        }, 15);
    }
});
