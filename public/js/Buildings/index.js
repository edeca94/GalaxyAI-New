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
                        startCountdown(countdownElem, response.startTime, response.endTime);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error("Errore AJAX:", xhr.responseText);
            }
        });
    });

    function updateQueue(queue) {
        let baseLevels = {};  // Salva il livello reale di ogni edificio sul pianeta
        let queueCount = {};  // Conta quante costruzioni sono già in coda
    
        // **1️⃣ Recuperiamo i livelli di base dal DOM**
        $(".build-btn").each(function () {
            let buildingId = $(this).data("id");
            let levelText = $(this).closest(".building-container").find(".building-level").text().match(/\d+/);
            if (levelText) {
                baseLevels[buildingId] = parseInt(levelText[0]); // Il livello reale senza incrementi sbagliati
            }
            queueCount[buildingId] = 0; // Inizializziamo il conteggio
        });
    
        // **2️⃣ Puliamo e aggiorniamo la coda senza influenzare i livelli di base**
        $("#construction-queue").empty();
    
        queue.forEach((item, index) => {
            let buildingId = item.buildingId;
    
            // Incrementiamo il numero di costruzioni in coda per questo edificio
            queueCount[buildingId]++;
    
            // Determiniamo il livello corretto da mostrare nella coda
            let correctLevel = baseLevels[buildingId] + queueCount[buildingId];
    
            let progressBar = index === 0 ? `<div class="progress-bar"><div class="progress" id="progress-${buildingId}"></div></div>` : '';
            let countdown = index === 0 ? `<span class="countdown" id="countdown-${buildingId}"></span>` : '';
    
            $("#construction-queue").append(`
                <div class="queue-item">
                    <img src="${$('img[data-id="' + buildingId + '"]').attr('data-src')}" class="queue-thumbnail">
                    <span>Livello ${correctLevel}</span>
                    ${progressBar}
                    ${countdown}
                    <a href="#" class="remove-btn" data-id="${buildingId}" data-position="${index + 1}">
                        ${index === 0 ? 'Annulla' : 'Rimuovi'}
                    </a>
                </div>
            `);
    
            if (index === 0) {
                startCountdown($(`#countdown-${buildingId}`), item.startTime, item.endTime);
            }
        });
    
        // **3️⃣ Aggiorniamo SOLO i pulsanti necessari**
        $(".build-btn").each(function () {
            let buildingId = $(this).data("id");
            let newLevel = baseLevels[buildingId] + (queueCount[buildingId] || 0) + 1;
            $(this).text(`Amplia al livello ${newLevel}`);
        });
    
        // **4️⃣ Gestiamo la rimozione dalla coda**
        $(".remove-btn").click(function () {
            let buildingId = $(this).data("id");
            let position = $(this).data("position");
            removeFromQueue(buildingId, position, queueCount[buildingId]);
        });
    }            
    
    function updateBuildingButton(buildingId, nextLevel) {
        let button = $(`.build-btn[data-id="${buildingId}"]`);
        button.text(`Amplia al livello ${nextLevel}`);
    }    
    
    function updateBuildingButton(buildingId, nextLevel) {
        let button = $(`.build-btn[data-id="${buildingId}"]`);
        button.text(`Amplia al livello ${nextLevel}`);
    }
    
    
    function removeFromQueue(buildingId, position, level) {
        $.ajax({
            url: "/buildings/removeFromQueue",
            method: "POST",
            data: { id: buildingId, position: position, level: level },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    updateQueue(response.queue);
                } else {
                    alert(response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error("Errore AJAX:", status, error);
                alert("Errore nella richiesta al server.");
            }
        });
    }

    function startCountdown(element, startTime, endTime) {
        let buildingId = element.attr("id").replace("countdown-", "");
    
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
                updateProgressBar(buildingId, startTime, endTime);
            }
        }
    
        if (countdownIntervals[buildingId]) {
            clearInterval(countdownIntervals[buildingId]);
        }
    
        countdownIntervals[buildingId] = setInterval(updateCountdown, 1000);
        updateCountdown();
    }    

    function updateProgressBar(buildingId, startTime, endTime) {
        let now = Math.floor(Date.now() / 1000);
        let progress = ((now - startTime) / (endTime - startTime)) * 100;
        $(`#progress-${buildingId}`).css("width", progress + "%");
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

    function formatTime(seconds) {
        let days = Math.floor(seconds / 86400);
        let hours = Math.floor((seconds % 86400) / 3600);
        let minutes = Math.floor((seconds % 3600) / 60);
        let secs = seconds % 60;

        let timeUnits = [];

        if (days > 0) timeUnits.push(days + "g");
        if (hours > 0) timeUnits.push(hours + "o");
        if (minutes > 0) timeUnits.push(minutes + "m");
        if (secs > 0) timeUnits.push(secs + "s");

        return timeUnits.join(" ");
    }
});
