var sessionData = [];

function submitFileSelection(form) {
	readJSONFromFile(form.filebrowser.files);
	document.getElementById("fileselection").style.display = "none";
	document.getElementById("parserselection").style.display = "inline";
}

//Store session data globally
function readJSONFromFile(inFiles) {
	// Check for the various File API support.
	if (window.File && window.FileReader && window.FileList && window.Blob) {
	// Great success! All the File APIs are supported.
	} else {
	  alert('The File APIs are not fully supported in this browser.');
	}

	for (var i = 0; i < inFiles.length; i++) {
		var reader = new FileReader();
		reader.onload = function(file) {
			var json = JSON.parse(file.target.result);
			sessionData.push(json);
		}
		reader.readAsText(inFiles[i]);
	}
}

//Reset file selection
function backToFileSelection() {
	sessionData = [];
	document.getElementById("parserselection").style.display = "none";
	document.getElementById("fileselection").style.display = "inline";
}