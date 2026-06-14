const TIMEZONE = "Asia/Jakarta";

const timeFormatter = new Intl.DateTimeFormat("id-ID", {
    timeZone: TIMEZONE,
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
    hour12: false,
});

const dateTimeFormatter = new Intl.DateTimeFormat("id-ID", {
    timeZone: TIMEZONE,
    day: "2-digit",
    month: "short",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
    hour12: false,
});

const dateTimeShortFormatter = new Intl.DateTimeFormat("id-ID", {
    timeZone: TIMEZONE,
    day: "2-digit",
    month: "short",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    hour12: false,
});

function parseDate(value) {
    if (!value) return null;

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return null;
    }

    return date;
}

function normalizeTimeText(value) {
    return value.replace(/\./g, ":");
}

function formatTime(value) {
    const date = parseDate(value);
    return date ? normalizeTimeText(timeFormatter.format(date)) : "";
}

function formatDateTime(value) {
    const date = parseDate(value);
    return date ? normalizeTimeText(dateTimeFormatter.format(date)) : "";
}

function formatDateTimeShort(value) {
    const date = parseDate(value);
    return date ? normalizeTimeText(dateTimeShortFormatter.format(date)) : "";
}

function formatElapsed(value) {
    const date = parseDate(value);

    if (!date) return "";

    const diffSeconds = Math.max(0, Math.floor((Date.now() - date.getTime()) / 1000));

    if (diffSeconds < 60) return "baru saja";

    const diffMinutes = Math.floor(diffSeconds / 60);
    if (diffMinutes < 60) return `${diffMinutes} minutes ago`;

    const diffHours = Math.floor(diffMinutes / 60);
    if (diffHours < 24) return `${diffHours} hours ago`;

    const diffDays = Math.floor(diffHours / 24);
    return `${diffDays} days ago`;
}

function updateTopbarClock() {
    const currentTime = formatTime(new Date());

    document.querySelectorAll(
        "#clock, #current-time, .clock, .current-time, [data-realtime-clock]"
    ).forEach((element) => {
        element.textContent = currentTime;
    });
}

function updateLiveDateTimes() {
    document.querySelectorAll(".live-dt").forEach((element) => {
        element.textContent = formatDateTime(element.dataset.at);
    });

    document.querySelectorAll(".live-dt-short").forEach((element) => {
        element.textContent = formatDateTimeShort(element.dataset.at);
    });

    document.querySelectorAll(".live-time").forEach((element) => {
        element.textContent = formatTime(element.dataset.at);
    });

    document.querySelectorAll(".live-ago").forEach((element) => {
        element.textContent = formatElapsed(element.dataset.at);
    });
}

function updateLiveElapsed() {
    document.querySelectorAll(".live-elapsed").forEach((element) => {
        const value = element.dataset.at;
        const dateTime = formatDateTimeShort(value);
        const elapsed = formatElapsed(value);

        element.innerHTML = elapsed
            ? `${dateTime}<br><small style="font-size:11.5px;color:#999;">${elapsed}</small>`
            : dateTime;
    });
}

function updateLiveLogs() {
    document.querySelectorAll(".live-log").forEach((element) => {
        const value = element.dataset.at;
        const dateTimeElement = element.querySelector(".log-dt");
        const elapsedElement = element.querySelector(".log-ago");

        if (dateTimeElement) {
            dateTimeElement.textContent = formatDateTime(value);
        }

        if (elapsedElement) {
            elapsedElement.textContent = formatElapsed(value);
        }
    });
}

function updateRealtimeElements() {
    updateTopbarClock();
    updateLiveDateTimes();
    updateLiveElapsed();
    updateLiveLogs();
}

document.addEventListener("DOMContentLoaded", () => {
    updateRealtimeElements();
    setInterval(updateRealtimeElements, 1000);
});