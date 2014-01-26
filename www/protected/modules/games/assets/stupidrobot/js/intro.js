//scroll in

	var paragraphArray;
	var introText=["This is Stupid Robot.",
	"Stupid Robot looks at everything but understands nothing.",
	"Can you help?",
	"Fill Stupid Robot’s input fields by naming what is in the pictures.",
	"Stupid Robot can only understand short words at first.",
	"Sometimes Stupid Robot has an ** NGR ERROR and can’t process a word.",
	"** No Good Reason",
	"If that happens, try another word until you find one that works."];
	var a = "";
	var p;
	var i=0;
	var activeLine=0;
	


function scrollIn() {
	p=paragraphArray[activeLine];
	i++;
	if(i > introText[activeLine].length) {
		
		paragraphArray[activeLine].innerHTML = a;
		activeLine++;
		i=0;
		
		if(activeLine >= introText.length){
			return;
			}
		
		setTimeout("scrollIn()",1000);
		return;
	 }
	 
	a = introText[activeLine].substring(0,i);
	p.innerHTML = a+"_";
	setTimeout("scrollIn()",40);
}



function init(){	
	$(".manifest").hide();
	canvas = document.getElementById("canvas");
	canvas.width=window.innerWidth;
	window.onresize =function(){
			canvas.width=window.innerWidth;
	};
	images = images||{};
	var manifest = [
		{src:$(".manifest").find('img').eq(0).attr('src'), id:"Bitmap3"},
		{src:$(".manifest").find('img').eq(1).attr('src'), id:"Bitmap7"},
		{src:$(".manifest").find('img').eq(2).attr('src'), id:"Bitmap5"},
		{src:$(".manifest").find('img').eq(3).attr('src'), id:"Bitmap6"},
		{src:$(".manifest").find('img').eq(4).attr('src'), id:"FlashAICB"},
		{src:$(".manifest").find('img').eq(5).attr('src'), id:"tree"}
	];
	var loader = new createjs.LoadQueue(false);
	loader.addEventListener("fileload", handleFileLoad);
	loader.addEventListener("complete", handleComplete);
	loader.loadManifest(manifest);
	
	//set up scroller
	var paragraphCollection=document.getElementsByClassName("scrollText");
	paragraphArray = Array.prototype.slice.call( paragraphCollection );
	paragraphArray.push(document.getElementById("lastScrollText"));
}


function handleFileLoad(evt) {
	if (evt.item.type == "image") { images[evt.item.id] = evt.result; }
}

function handleComplete() {
	console.log("complete");
	var loadScreen=document.getElementById("loading");
	loadScreen.parentNode.removeChild(loadScreen);	


	exportRoot = new lib.animation_intro();

	stage = new createjs.Stage(canvas);
	stage.addChild(exportRoot);
	stage.update();

	createjs.Ticker.setFPS(24);
	createjs.Ticker.addEventListener("tick", stage);
	
	setTimeout("scrollIn()",2000);

}

window.onload = function(){	
	init();
};


