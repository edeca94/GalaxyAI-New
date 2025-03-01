$(document).ready(function () {
    let countdownIntervals = {}; 

    checkActiveConstruction();

    $(".build-btn").click(function (e) {
        e.preventDefault();
        let button = $(this);
        let buildingId = button.data("id");

        $.ajax({
            url: "/buildings/startConstruction",
            method: "POST",
            data: { id: buildingId },
            dataType: "json",
            success: function (response) {
                if (!response.success) {
                    alert(response.error);
                } else {
                    updateQueue(response.queue); 

                    if (response.active) {
                        let countdownElem = $(".countdown[data-id='" + response.buildingId + "']");
                        startCountdown(countdownElem, response.endTime);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error("Errore AJAX:", xhr.responseText);
            }
        });
    });

    function updateQueue(queue) {
        $("#construction-queue").empty();
        
        queue.forEach(item => {
            $("#construction-queue").append(`
                <div class="queue-item">
                    <img src="/public/images/buildings/${item.buildingId}.png" class="queue-thumbnail">
                    <span>${item.buildingLevel}</span>
                    <button class="remove-btn" data-id="${item.buildingId}">X</button>
                </div>
            `);
        });

        $(".remove-btn").click(function () {
            let buildingId = $(this).data("id");
            removeFromQueue(buildingId);
        });
    }

    $(".cancel-btn").click(function (e) {
        e.preventDefault();
        let button = $(this);
        let buildingId = button.data("id");
        let queuePosition = button.data("position"); 
    
        $.ajax({
            url: "/buildings/removeFromQueue",
            method: "POST",
            data: { id: buildingId, position: queuePosition },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    location.reload(); 
                } else {
                    alert(response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error("Errore AJAX:", status, error);
                alert("Errore nella richiesta al server.");
            }
        });
    });    

    function startCountdown(element, endTime) {
        let buildingId = element.data("id");

        function updateCountdown() {
            let now = Math.floor(Date.now() / 1000);
            let remaining = endTime - now;

            if (remaining <= 0) {
                clearInterval(countdownIntervals[buildingId]);
                delete countdownIntervals[buildingId];
                element.text("Completato");

                $.ajax({
                    url: "/buildings/handleQueue",
                    method: "POST",
                    dataType: "json",
                    success: function (response) {
                        location.reload(true);
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX ERRORE:", xhr.responseText);
                    }
                });
            } else {
                element.text(formatTime(remaining));
            }
        }

        if (countdownIntervals[buildingId]) {
            clearInterval(countdownIntervals[buildingId]);
        }

        countdownIntervals[buildingId] = setInterval(updateCountdown, 1000);
        updateCountdown();
    }

    function checkActiveConstruction() {
        $.ajax({
            url: "/buildings/getActiveBuildings",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.active) {
                    let buildingId = response.buildingId;
                    let endTime = response.endTime;

                    $(".build-btn").hide();
                    let countdownElem = $(".countdown[data-id='" + buildingId + "']");
                    $(".cancel-btn[data-id='" + buildingId + "']").show();
                    countdownElem.show();
                    startCountdown(countdownElem, endTime);
                } else {
                    $(".build-btn").show();
                }

                updateQueue(response.queue);
            },
            error: function (xhr, status, error) {
                console.error("Errore AJAX:", status, error);
                console.error("Risposta del server:", xhr.responseText);
            }
        });
    }
});
