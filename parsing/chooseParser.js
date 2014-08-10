var parser = null;
var rFrame = document.getElementById("resultframe");

function submitParserSelection(form) {
	/*
	Put the jsons in session storage to allow frame to access them.
	  There's currently no logic to determine when files have loaded;
	  until logic is added, we'll just hope they have loaded by now.
	*/
	sessionStorage.setItem("data", JSON.stringify(sessionData));

	setParser(form.parser);
	rFrame.src = "parsers/" + parser + ".html";
	document.getElementById("parserselection").style.display = "none";
	document.getElementById("results").style.display = "inline";
}

//Store parser selection globally
function setParser(parsers) {
	for (var i = 0, length = parsers.length; i < length; i++) {
		if (parsers[i].checked) {
			parser = parsers[i].value
			break;
		}
	}
	if (!parser) {
		console.log("No parser chosen!");
		parser = "noParser";
	}
}

//Reset parser selection
function backToParserSelection() {
	parser = null;
	rFrame.src = "about:blank";
	document.getElementById("results").style.display = "none";
	document.getElementById("parserselection").style.display = "inline";
}