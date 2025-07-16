/*
 * Special thanks to Bang Ucup Informatika Unmul 2020
 */

(function startClock() {
    const elementsJam = document.getElementsByClassName("current-time");

    if (elementsJam.length === 0) return;

    const tanggalFormatter = new Intl.DateTimeFormat("id-ID", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
        timeZone: "Asia/Makassar",
    });

    function formatTime(date) {
        const hours = String(date.getHours()).padStart(2, "0");
        const minutes = String(date.getMinutes()).padStart(2, "0");
        const seconds = String(date.getSeconds()).padStart(2, "0");
        return `${hours}.${minutes}.${seconds}`;
    }

    function updateClock() {
        const now = new Date();
        const tanggal = tanggalFormatter.format(now);
        const waktu = formatTime(now);

        const timeString = `${tanggal} (${waktu} WITA)`;

        for (let el of elementsJam) {
            el.textContent = timeString;
        }
    }

    updateClock();
    setInterval(updateClock, 1000);
})();
