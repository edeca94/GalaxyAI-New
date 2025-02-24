$(document).ready(function() {
    $(".build-btn").click(function(e) {
        e.preventDefault();
        let button = $(this);
        let buildingId = button.data("id");
        let countdownElem = $(".countdown[data-id='" + buildingId + "']");

        $.ajax({
            url: "/buildings/startConstruction",
            method: "POST",
            data: { id: buildingId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    let endTime = response.endTime;
                    button.hide();
                    startCountdown(countdownElem, endTime);
                } else {
                    alert(response.error);
                }
            },
            error: function(xhr, status, error) {    
                console.error("Errore AJAX:", status, error);
                console.error("Risposta del server:", xhr.responseText);
                alert("Errore nella richiesta al server.");
            }
        });
    });

    function startCountdown(element, endTime) {
        let interval = setInterval(function() {
            let now = Math.floor(Date.now() / 1000);
            let remaining = endTime - now;
    
            if (remaining <= 0) {
                clearInterval(interval);
                element.text("Completato");
            } else if (isNaN(remaining) || remaining < 0) {
                element.text("Errore: data non valida");
            } else {
                let minutes = Math.floor(remaining / 60);
                let seconds = remaining % 60;
                element.text(minutes + "m " + seconds + "s");
            }
        }, 1000);
    }
});
