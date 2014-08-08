var list = document.getElementById("linklist");
function createCSV(game) {
	var csv = "";
	var events = game.events;
	for (var j = 0, eventsLength = events.length; j < eventsLength; j++) {
		var evt = events[j];
		for (var attr in evt) {
			csv += (evt[attr] + "\t");
		}
		csv = csv.slice(0, -1);
		csv += "\n";
	}
	return csv;
}

function showDownloads() {
	var data = JSON.parse(sessionStorage.getItem("data"));
	for (var i = 0, dataLength = data.length; i < dataLength; i++) {
		var game = data[i];
		var csv = createCSV(game);
		var uri = "data:text/csv;charset=utf-8," + encodeURIComponent(csv);
		var download = game.id + ".csv";

		var link = document.createElement("a");
		link.href = uri;
		link.download = download;
		link.textContent = download;

		var listItem = document.createElement("li");
		listItem.appendChild(link);
		list.appendChild(listItem);
	}
}
showDownloads();