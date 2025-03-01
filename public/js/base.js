function formatTime(seconds) {
    let totalMinutes = Math.floor(seconds / 60);
    let totalHours = Math.floor(totalMinutes / 60);
    let days = Math.floor(totalHours / 24);

    let remainingHours = totalHours % 24;
    let remainingMinutes = totalMinutes % 60;
    let remainingSeconds = seconds % 60;

    let timeUnits = [];

    if (days > 0) {
        timeUnits.push(days + "g");
    }
    if (remainingHours > 0) {
        timeUnits.push(remainingHours + "o");
    }
    if (remainingMinutes > 0) {
        timeUnits.push(remainingMinutes + "m");
    }
    if (remainingSeconds > 0) {
        timeUnits.push(remainingSeconds + "s");
    }

    return timeUnits.join(" ");
}