var logs = JSON.parse(sessionStorage.getItem("data"));

function getOutput(index) {
    var text = "<i>" + logs[index].browser + "</i><br/><br/>";
    var events = logs[index].events;
    var startTime = events[0].timestamp;
    var lastImage;
    for (var i = 0, eventsLength = events.length; i < eventsLength; i++) {
        var evt = events[i];
        if (lastImage == evt.details) {
            continue;
        }
        var timeDiff = Math.round((evt.timestamp - startTime) / 1000);
        text += (Math.floor(timeDiff/60) + ":" + pad(timeDiff%60, "0", 2) + " ");
        switch (evt.action) {
        case "start":
            text += ("PLAYER started the session");
            break;
        case "keypress":
            var keys = getKey(evt.details);
            var lastTime = evt.timestamp;
            var nextEvent = events[i + 1];
            while (nextEvent.action == "keypress" && lastTime - nextEvent.timestamp < 500) {
                keys += getKey(nextEvent.details);
                i++;
                nextEvent = events[i + 1];
                lastTime = nextEvent.timestamp;
            }
            text += ("PLAYER entered '" + keys + "'");
            break;
        case "click":
            text += ("PLAYER clicked " + evt.details);
            break;
        case "intro":
            text += ("GAME intro " + evt.details);
            break;
        case "reaction":
            text += ("GAME responded '" + evt.details + "'");
            break;
        case "image":
            text += ("GAME displayed:<br/><a href='" + evt.details + "' target='_blank'><img src='" + evt.details + "' height='100px' /></a>");
            lastImage = evt.details;
            break;
        case "end round":
            text += ("GAME ended with " + evt.details + " words");
            break;
        case "end":
            text += ("PLAYER ended the session");
            break;
        default:
            console.log("Unrecognized event action: " + evt.action);
        }
        text += "<br/>";
    }
    document.querySelector("h2").textContent = ("Gameplay log - " + getDate(startTime) + ", " + getTime(startTime));
    output.innerHTML = text;
}

function getKey(key) {
    switch (key) {
    case "Backspace":
        return "[Del]";
    case "Enter":
        return "[Enter]";
    default:
        return key;
    }
}
var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
function getDate(timestamp) {
    var date = new Date(parseInt(timestamp));
    return months[date.getUTCMonth()] + " " + date.getUTCDate();
}
function getTime(timestamp) {
    var date = new Date(parseInt(timestamp));
    return pad(date.getUTCHours(), "0", 2) + ":" + pad(date.getUTCMinutes(), "0", 2);
}
function pad(string, padding, length) {
    string += "";
    padding += "";
    while (string.length < length) {
        string = (padding + string);
    }
    return string;
}

function addOptions(length) {
    var gameSelect = document.getElementById("gameselect");
    for (var i = 0; i < length; i++) {
        var gameOption = document.createElement("option");
        gameOption.textContent = i;
        gameOption.value = i;
        gameSelect.appendChild(gameOption);
    }
}
addOptions(logs.length);

getOutput(0);