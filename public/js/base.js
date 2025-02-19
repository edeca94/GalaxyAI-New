document.addEventListener("DOMContentLoaded", function () {
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString(undefined, {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZoneName: 'short'
        });

        document.getElementById('clock').textContent = timeString;
    }

    updateClock(); 
    setInterval(updateClock, 1000); 
});
