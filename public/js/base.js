/*document.addEventListener("DOMContentLoaded", function () {
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
});*/

document.addEventListener("DOMContentLoaded", function () {
    function updateCountdowns() {
        const countdownElements = document.querySelectorAll(".countdown");
        const currentTime = Math.floor(Date.now() / 1000); 

        countdownElements.forEach(el => {
            const endTime = parseInt(el.getAttribute("data-endtime"), 10);

            if (isNaN(endTime)) {
                el.textContent = "Errore: data non valida";
                return;
            }

            let remainingTime = endTime - currentTime;

            if (remainingTime > 0) {
                let hours = Math.floor(remainingTime / 3600);
                let minutes = Math.floor((remainingTime % 3600) / 60);
                let seconds = remainingTime % 60;

                el.textContent = `${hours}o ${minutes}m ${seconds}s`;
            } else {
                el.textContent = "ora";
            }
        });
    }

    updateCountdowns();
    setInterval(updateCountdowns, 1000);
});
