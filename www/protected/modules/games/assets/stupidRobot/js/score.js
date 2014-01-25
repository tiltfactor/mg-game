window.onload = function(){
	var canvas = document.getElementById("canvas");
	var exportRoot = new lib.animation_score(10);

	var stage = new createjs.Stage(canvas);
	stage.addChild(exportRoot);
	stage.update();

	createjs.Ticker.setFPS(24);
	createjs.Ticker.addListener(stage);
};
