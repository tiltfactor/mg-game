function getOutput() {
    var text = "";
    var data = JSON.parse(sessionStorage.getItem("data"));
    //for (var i = 0, dataLength = data.length; i < dataLength; i++) {
    var events = data[0].events;
    for (var i = 0, eventsLength = events.length; i < eventsLength; i++) {
        var evt = events[i];
        text += (getTime(evt.timestamp) + "  ");
        switch (evt.action) {
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
            text += ("player entered '" + keys + "'");
            break;
        case "click":
            text += ("player clicked " + evt.details);
            break;
        case "intro":
            text += ("game intro " + evt.details);
            break;
        case "reaction":
            text += ("game responded '" + evt.details + "'");
            break;
        case "image":
            text += ("game displayed:<br/><img src='" + evt.details + "' height='100px' />");
            break;
        case "end":
            text += ("player ended the session");
            break;
        default:
            console.log("Unrecognized event action: " + evt.action);
        }
        text += "<br/>";
    }
    document.querySelector("h2").textContent += (" - " + getDate(events[0].timestamp));
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
    return date.getUTCHours() + ":" + date.getUTCMinutes() + ":" + date.getUTCSeconds() + "." + date.getUTCMilliseconds();
}
getOutput();