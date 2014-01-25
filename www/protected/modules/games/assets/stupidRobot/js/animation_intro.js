
(function (lib, img, cjs) {

var p; // shortcut to reference prototypes


// stage content:
(lib.animation_intro = function(mode,startPosition,loop) {
	
	this.initialize(mode,startPosition,loop,{startOver:79},true);

	// timeline functions:
	this.frame_0 = function() {
		this.objects.stop();
	}
	this.frame_140 = function() {
		this.robot.stop();
	}
	this.frame_249 = function() {
		this.robot.play();
	}
	this.frame_308 = function() {
		this.objects.gotoAndStop(this.objects.timeline.position + 1);
		this.gotoAndPlay("startOver");
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(140).call(this.frame_140).wait(109).call(this.frame_249).wait(59).call(this.frame_308));

	// rollin
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("AANgMIgZAAIAAAZIAZAAIAAgZ").cp();
	this.shape.setTransform(373.5,136.3);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#FFFFFF").s().p("AjwjCIHhAAIAAGGInhAAIAAmG").cp();
	this.shape_1.setTransform(373.2,136.3,0.328,0.328);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#000000").s().p("ABigDIhUBTQgJAIgHgIIgTgTQgEgEAAgFQAAgFAEgEIBShSQAQgQAAgVQAAgWgPgPQgPgPgWAAIgxAAQgWAAgPAPQgPAPAAAWQAAAFgEAEQgEAEgFAAIgaAAQgGAAgDgEQgEgEAAgFQAAgrAfgeQAegfArAAIAxAAQArAAAeAfQAfAeAAArQAAArgfAeIAAAAAAMC1IgXAAQgGAAgEgEQgDgEAAgFIAAgaQAAgGADgDQAEgEAGAAIAXAAQAGAAAEAEQADADAAAGIAAAaQAAAFgDAEQgEAEgGAAIAAAA").cp();
	this.shape_2.setTransform(419.1,70.7);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f().s("#000000").ss(2,1,1).p("ABGg9IiMB7");
	this.shape_3.setTransform(401.1,90.3);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[]},79).to({state:[{t:this.shape_3},{t:this.shape_2},{t:this.shape_1},{t:this.shape}]},132).to({state:[{t:this.shape_3}]},2).to({state:[{t:this.shape_3},{t:this.shape_2},{t:this.shape_1},{t:this.shape}]},2).to({state:[{t:this.shape_3}]},2).to({state:[{t:this.shape_3},{t:this.shape_2}]},2).to({state:[{t:this.shape_3},{t:this.shape_2}]},2).to({state:[]},25).wait(63));

	// FlashAICB
	this.robot = new lib.Robot();
	this.robot.setTransform(-42,112.1,1,1,0,0,0,0.5,-6);

	this.timeline.addTween(cjs.Tween.get(this.robot).to({x:-41.5},34).to({x:356,y:117.2},45).wait(230));

	// questioner
	this.instance = new lib.SubAnimation();
	this.instance.setTransform(371.4,67.4,0.014,2.683,0,69.1,-10.6,110.7,-6.7);
	this.instance._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(159).to({_off:false},0).to({regX:112.4,regY:-6.5,scaleX:0.84,scaleY:1.04,skewX:70.1,x:372.8},4).to({regX:112.8,regY:-6.2,scaleX:1.11,skewX:79.5,skewY:-1,y:67.1},2).to({regX:113.7,regY:-4.8,scaleX:0.72,scaleY:0.7,skewX:87.3,skewY:6.5,x:372.7,y:67.2},2).to({regX:113.4,regY:-5.2,scaleX:1.06,skewX:90.2,skewY:9.5,x:372.1,y:67.6},2).to({regX:113.5,regY:-4.8,scaleX:0.78,scaleY:0.51,skewX:94.3,skewY:13.6,x:372.7,y:67.7},3).to({regX:112.9,regY:-6.2,scaleX:0.96,scaleY:1.04,skewX:106,skewY:25.3,x:372.3,y:67.1},2).to({regX:113.5,regY:-4.8,scaleX:0.78,scaleY:0.51,skewX:94.3,skewY:13.6,x:373,y:67.3},2).to({regX:113.7,scaleX:1.06,scaleY:0.7,skewX:87.3,skewY:6.5,x:373.9,y:68.3},2).to({scaleX:0.72,x:372.9,y:68.4},2).to({regX:113.4,regY:-5.2,scaleX:1.06,skewX:90.2,skewY:9.5,y:68.5},2).to({regX:113.7,regY:-4.8,scaleX:0.72,skewX:87.3,skewY:6.5,x:371.7,y:67.6},2).to({regX:112.8,regY:-6.2,scaleX:1.11,scaleY:1.04,skewX:79.5,skewY:-1,x:373.1,y:67.5},2).to({regX:112.4,regY:-6.5,scaleX:0.84,skewX:70.1,skewY:-10.5,y:68.2},2).to({regX:110.7,regY:-6.6,scaleX:0.01,scaleY:2.68,skewX:69.1,x:372.5,y:67.3},2).to({_off:true},1).wait(118));

	// object
	this.objects = new lib.Objects();
	this.objects.setTransform(4572.8,2016,1,1,0,0,0,91.5,86.5);

	this.timeline.addTween(cjs.Tween.get(this.objects).wait(90).to({x:1682.1,y:95},0).to({x:620.2},54).wait(100).to({x:-99.1},31).wait(34));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-75.3,55.7,4739.7,2046.8);


// symbols:
(lib.Bitmap3 = function() {
	this.initialize(img.Bitmap3);
}).prototype = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,183,179);


(lib.Bitmap4 = function() {
	this.initialize(img.Bitmap4);
}).prototype = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,183,179);


(lib.Bitmap5 = function() {
	this.initialize(img.Bitmap5);
}).prototype = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,183,179);


(lib.Bitmap6 = function() {
	this.initialize(img.Bitmap6);
}).prototype = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,183,179);


(lib.Bitmap7 = function() {
	this.initialize(img.Bitmap7);
}).prototype = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,185,175);


(lib.tree = function() {
	this.initialize(img.tree);
}).prototype = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,183,173);


(lib.Tween1 = function() {
	this.initialize();

	// Layer 1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("AAAh6IgXB3QgSAGgMAQQgLARAAAUQgBAcAUATQATATAaAAQAbABATgUQATgTAAgbQABgVgMgRQgMgQgSgGIgYh3").cp();
	this.shape.setTransform(-5.5,0,1,1,90,0,0,0,5.6);

	this.addChild(this.shape);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(-12.2,-6.5,24.6,13.2);


(lib.SubAnimation = function() {
	this.initialize();

	// Layer 1
	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f().s("#CC0033").ss(15,1,1).p("A1bAAMAq4AAA");
	this.shape_1.setTransform(249.5,-6.5);

	this.addChild(this.shape_1);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.Objects = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// Layer 1
	this.instance = new lib.tree();

	this.instance_1 = new lib.Bitmap3();
	this.instance_1.setTransform(64,-5.9);

	this.instance_2 = new lib.Bitmap7();
	this.instance_2.setTransform(28,0);

	this.instance_3 = new lib.Bitmap5();
	this.instance_3.setTransform(0,-4.9);

	this.instance_4 = new lib.Bitmap6();
	this.instance_4.setTransform(0,-5.9);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance}]}).to({state:[{t:this.instance_1}]},1).to({state:[{t:this.instance_2}]},1).to({state:[{t:this.instance_3,p:{y:-4.9}}]},1).to({state:[{t:this.instance_3,p:{y:-5.9}},{t:this.instance_4}]},1).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,183,173);


(lib.Robot = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// Layer 2
	this.instance_5 = new lib.Tween1("synched",0);
	this.instance_5.setTransform(0.1,-55.7,1,1,180,0,0,-5.5,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_5).to({rotation:270.1,x:0.5,y:-55.9},10).to({rotation:360,x:0.9,y:-55.6},10).to({rotation:270.1,x:0.5,y:-55.9},10).to({scaleX:1,scaleY:1,rotation:189.1,x:0.2,y:-55.7},9).wait(1));

	// Layer 1
	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#000000").s().p("AANgMIgZAAIAAAZIAZAAIAAgZ").cp();
	this.shape_2.setTransform(23.6,13);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f("#FFFFFF").s().p("AjwjCIHhAAIAAGGInhAAIAAmG").cp();
	this.shape_3.setTransform(17.7,13,0.328,0.328);

	this.shape_4 = new cjs.Shape();
	this.shape_4.graphics.f("#000000").s().p("AgnAoIBPAAIAAhPIhPAAIAABP").cp();
	this.shape_4.setTransform(-19.5,11.8,0.328,0.328);

	this.shape_5 = new cjs.Shape();
	this.shape_5.graphics.f("#FFFFFF").s().p("ADxDEInhAAIAAmGIHhAAIAAGG").cp();
	this.shape_5.setTransform(-16.1,13,0.328,0.328);

	this.shape_6 = new cjs.Shape();
	this.shape_6.graphics.f("#FFFFFF").s().p("AhKCoICVAAIAAlPIiVAAIAAFP").cp();
	this.shape_6.setTransform(3.7,30.8,0.328,0.185);

	this.shape_7 = new cjs.Shape();
	this.shape_7.graphics.f("#FFFFFF").s().p("AgXAYIAvAAIAAgvIgvAAIAAAv").cp();
	this.shape_7.setTransform(-9.4,31.4);

	this.shape_8 = new cjs.Shape();
	this.shape_8.graphics.f("#FFFFFF").s().p("AhKCoICVAAIAAlPIiVAAIAAFP").cp();
	this.shape_8.setTransform(-2.7,30.8,0.328,0.185);

	this.shape_9 = new cjs.Shape();
	this.shape_9.graphics.f("#FFFFFF").s().p("AhKBLICVAAIAAiVIiVAAIAACV").cp();
	this.shape_9.setTransform(10.1,31.4,0.328,0.328);

	this.shape_10 = new cjs.Shape();
	this.shape_10.graphics.f("#000000").s().p("Agg6vIhQGEIotAAIAABqIiqAAIAABpIisAAMAAAAo/QAABTA7A6QA6A8BUAAQBTAAA6g8QA8g6AAhTITEAAQAABTA7A6QA7A8BTAAQBTAAA6g8QA7g6AAhTMAAAgo/IirAAIAAhpIirAAIAAhqIotAAIhPmEIhCAA").cp();
	this.shape_10.setTransform(0.5,0.5,0.328,0.328);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_10},{t:this.shape_9},{t:this.shape_8},{t:this.shape_7},{t:this.shape_6},{t:this.shape_5},{t:this.shape_4},{t:this.shape_3},{t:this.shape_2}]}).wait(40));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-32.7,-62.3,66.5,119.1);

})(lib = lib||{}, images = images||{}, createjs = createjs||{});
var lib, images, createjs;