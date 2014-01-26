(function (lib, img, cjs) {

var p; // shortcut to reference prototypes

// stage content:
(lib.animation_score = function(level,mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// timeline functions:
	this.frame_0 = function() {
		if(level==0){
			this.stop();
		}
		console.log("nothing");
	}
	this.frame_1 = function() {
		console.log("eyes");
		this.eyes.gotoAndPlay("goeyes");
		if(level==1){
			this.stop();
		}
	}
	this.frame_18 = function() {
		console.log("wheels");
			if(level==2){
			this.stop();
		}
	}
	this.frame_24 = function() {
		console.log("leftarm");
				if(level==3){
			this.stop();
		}
	}
	this.frame_42 = function() {
		console.log("eyesraise");
				if(level==4){
			this.stop();
		}
	}
	this.frame_51 = function() {
		console.log("satellite");
			if(level==5){
			this.stop();
		}
	}
	this.frame_60 = function() {
		console.log("raisemouth");
				if(level==6){
			this.stop();
		}
	}
	this.frame_61 = function() {
				if(level==7){
			this.stop();
		}
		console.log("changemouth (ADD CHANGE)");
		this.mouth.gotoAndPlay("go");
	}
	this.frame_63 = function() {
				if(level==8){
			this.stop();
		}
		console.log("rightarm");
	}
	this.frame_66 = function() {
				if(level==9){
			this.stop();
		}
	}
	this.frame_76 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(1).call(this.frame_1).wait(17).call(this.frame_18).wait(6).call(this.frame_24).wait(18).call(this.frame_42).wait(9).call(this.frame_51).wait(9).call(this.frame_60).wait(1).call(this.frame_61).wait(2).call(this.frame_63).wait(3).call(this.frame_66).wait(10).call(this.frame_76));

	// objects
	this.instance = new lib.Arm();
	this.instance.setTransform(200.4,249.1,1,1,0,0,0,85.2,-28.3);

	this.instance_1 = new lib.Satellite();
	this.instance_1.setTransform(205,59.6);

	this.instance_2 = new lib.Arm2();
	this.instance_2.setTransform(448.6,324.2,1,1,0,0,0,0.5,0.5);

	this.instance_3 = new lib.Badge();
	this.instance_3.setTransform(224.6,347.4,0.327,0.327);

	this.instance_4 = new lib.Monocle();
	this.instance_4.setTransform(358.1,270.1,1,1,0,0,0,1.2,-14.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[{t:this.instance}]},24).to({state:[{t:this.instance_1},{t:this.instance}]},27).to({state:[{t:this.instance_1},{t:this.instance},{t:this.instance_2}]},12).to({state:[{t:this.instance_1},{t:this.instance_3},{t:this.instance},{t:this.instance_2}]},3).to({state:[{t:this.instance_1},{t:this.instance_3},{t:this.instance},{t:this.instance_2},{t:this.instance_4}]},10).wait(1));

	// eyes
	this.eyes = new lib.Eyes();
	this.eyes.setTransform(228.3,313.4,1,1,0,0,0,-129.9,-60.9);

	this.timeline.addTween(cjs.Tween.get(this.eyes).wait(12).to({y:265.4},6).wait(15).to({y:224.4},9).wait(35));

	// mouth
	this.mouth = new lib.Mouth();
	this.mouth.setTransform(295.9,422.4,1,1,0,0,0,41.1,10.5);

	this.timeline.addTween(cjs.Tween.get(this.mouth).wait(12).to({y:374.4},6).wait(35).to({y:321.4},7).wait(17));

	// spinner
	this.spinner = new lib.Spinner();
	this.spinner.setTransform(277.2,124.2,3.358,3.358,0,0,0,-5.4,-55.8);

	this.timeline.addTween(cjs.Tween.get(this.spinner).wait(12).to({y:76.2},6).wait(59));

	// robot
	this.instance_5 = new lib.RoboBody();
	this.instance_5.setTransform(297.3,308.9,1,1,0,0,0,111.7,177);

	this.timeline.addTween(cjs.Tween.get(this.instance_5).wait(12).to({y:260.9},6).wait(59));

	// secondWheels
	this.instance_6 = new lib.MovingWheel();
	this.instance_6.setTransform(329.2,462.6,1,1,0,0,0,-0.9,-0.9);

	this.instance_7 = new lib.MovingWheel();
	this.instance_7.setTransform(271.2,462.6,1,1,0,0,0,-0.9,-0.9);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[{t:this.instance_7},{t:this.instance_6}]},18).wait(59));

	// wheels
	this.instance_8 = new lib.Wheel("synched",0);
	this.instance_8.setTransform(385.4,459.3,1,1,0,0,0,-11.6,32.2);

	this.instance_9 = new lib.Wheel("synched",0);
	this.instance_9.setTransform(209.3,459.3,1,1,0,0,0,-11.6,32.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_9},{t:this.instance_8}]}).wait(77));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(185.6,102,223.5,410.1);


// symbols:
(lib.WhiteBox = function() {
	this.initialize();

	// Layer 1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#FFFFFF").s().p("AFUq7IAAV3IxpAAIAA13IRpAAIHCAAIAAV3InCAAIAA13").cp();
	this.shape.setTransform(79,70);

	this.addChild(this.shape);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,158,140);


(lib.Tween56 = function() {
	this.initialize();

	// Layer 1
	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#FFFFFF").s().p("AC+i8QhPhPhvAAQhuAAhOBPQhPBOAABuQAABvBPBPQBOBOBuAAQBvAABPhOQBOhPAAhvQAAhuhOhOIAAAAAEWAAQAABzhSBRQhRBShzAAQhyAAhShSQhRhRAAhzQAAhyBRhSQBShRByAAQBzAABRBRQBSBSAAByIAAAAADhjgQhehdiDAAQiCAAheBdQhdBdAACDQAACDBdBeQBeBdCCAAQCDAABehdQBdheAAiDQAAiDhdhdIAAAAAFIAAQAACIhgBfQhgBhiIAAQiGAAhhhhQhghfAAiIQAAiHBghgQBghgCHAAQCIAABgBgQBgBgAACHIAAAA").cp();
	this.shape_1.setTransform(0,0,1.323,1.323);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#000000").s().p("ADBjAQhQhQhxAAQhwAAhQBQQhQBQAABwQAABxBQBQQBQBQBwAAQBxAABQhQQBQhQAAhxQAAhwhQhQIAAAAAFDAAQAACGhfBeQheBfiGAAQiFAAhehfQhfheAAiGQAAiFBfheQBehfCFAAQCGAABeBfQBfBeAACFIAAAA").cp();
	this.shape_2.setTransform(0,0,1.323,1.323);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f("#EDE750").s().p("AEXkWQhzh0ikAAQiiAAh0B0Qh0B1AAChQAACkB0BzQB0B0CiAAQCkAABzh0QB0hzAAikQAAihh0h1IAAAA").cp();

	this.addChild(this.shape_3,this.shape_2,this.shape_1);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(-43.4,-43.4,87,87);


(lib.Symbol2 = function() {
	this.initialize();

	// Layer 1
	this.shape_4 = new cjs.Shape();
	this.shape_4.graphics.f("#000000").s().p("AB7B5Ij1AAIgUjxIEdAAIgUDx").cp();
	this.shape_4.setTransform(14.3,12.2);

	this.addChild(this.shape_4);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,28.7,24.4);


(lib.Symbol1 = function() {
	this.initialize();

	// Layer 1
	this.shape_5 = new cjs.Shape();
	this.shape_5.graphics.f("#000000").s().p("ACDBWIAADhQBXgnA1hPQA2hRAAhjQAAiEhfhgQhghfiGAAQiFAAhgBfQhfBgAACEQAABjA2BRQA1BPBXAnIAAjhQAAg2AmglQAngmA1AAQA2AAAmAmQAnAlAAA2IAAAA").cp();
	this.shape_5.setTransform(32.5,31.1);

	this.addChild(this.shape_5);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,65,62.3);


(lib.SatSymbol5 = function() {
	this.initialize();

	// Layer 1
	this.shape_6 = new cjs.Shape();
	this.shape_6.graphics.f("#000000").s().p("AA3ApQARgXgEgaQgEgdgXgRQgXgRgaAEQgcAEgSAXQgRAXAEAaQAEAcAXASQAXARAbgEQAcgEARgXIAAAA").cp();
	this.shape_6.setTransform(6.9,7);

	this.addChild(this.shape_6);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,13.9,13.9);


(lib.SatSymbol4 = function() {
	this.initialize();

	// Layer 1
	this.shape_7 = new cjs.Shape();
	this.shape_7.graphics.f("#000000").s().p("AB2AkIknizQgWgNgCACQgCADASASID+DpQATASAcAPQAcAQAUADIAHACQAUAEAIgKQAIgKgKgSIgDgHQgJgSgXgXQgWgWgWgOIAAAA").cp();
	this.shape_7.setTransform(20.3,15.6);

	this.addChild(this.shape_7);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,40.6,31.1);


(lib.SatSymbol3 = function() {
	this.initialize();

	// Layer 1
	this.shape_8 = new cjs.Shape();
	this.shape_8.graphics.f("#000000").s().p("ADTgTQhABUhkAsQhQAkhVACQhLABgagXQgbgYA7gaQBzgzAUgLQBKgqA5hLIAOgTQAVgVAdgCQAegCAXASQAaATAFAgQAFAggTAaIgBACIgBAA").cp();
	this.shape_8.setTransform(22.9,14.8);

	this.addChild(this.shape_8);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,45.7,29.6);


(lib.SatSymbol2 = function() {
	this.initialize();

	// Layer 1
	this.shape_9 = new cjs.Shape();
	this.shape_9.graphics.f("#000000").s().p("AgKgwQgWBTg3BLIgPATQgOAaAGAcQAGAdAYASQAaATAggEQAdgEAUgZIABgCIABAAQBAhWAPhsQANhXgWhSQgUhJgdgSQgfgTgIA/QgPB8gGAYIAAAA").cp();
	this.shape_9.setTransform(11.3,24.6);

	this.addChild(this.shape_9);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,22.7,49.3);


(lib.SatSymbol1 = function() {
	this.initialize();

	// Layer 1
	this.shape_10 = new cjs.Shape();
	this.shape_10.graphics.f("#000000").s().p("ACZBzQgKANgRADQgQACgNgKIjxi1QgNgKgDgQQgCgRAKgNQAKgNAQgDQARgCANAKIDxC1QANAKADAQQACARgKANIAAAA").cp();
	this.shape_10.setTransform(16.2,13.2);

	this.addChild(this.shape_10);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,32.4,26.4);


(lib.spinnertween = function() {
	this.initialize();

	// Layer 1
	this.shape_11 = new cjs.Shape();
	this.shape_11.graphics.f("#000000").s().p("AhmgtQgTATAAAaQgBAbAUATQATATAbAAQAVABARgMQAQgMAGgSIB3gYIh3gXQgGgSgQgMQgRgLgUAAQgcgBgTAUIAAAA").cp();
	this.shape_11.setTransform(-5.4,0,1,1,0,0,0,-5.5,0);

	this.addChild(this.shape_11);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(-12.2,-6.5,24.6,13.2);


(lib.RoboBody = function() {
	this.initialize();

	// Layer 1
	this.shape_12 = new cjs.Shape();
	this.shape_12.graphics.f("#000000").s().p("ALizJIAAh0IpmAAIhXmsIhJAAIhYGsIpmAAIAAB0Ii8AAIAAB0Ii9AAMAAAAs/MAi3AAAMAAAgs/Ii9AAIAAh0Ii9AA").cp();
	this.shape_12.setTransform(111.7,177);

	this.addChild(this.shape_12);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,223.3,354.1);


(lib.GreenBox = function() {
	this.initialize();

	// Layer 1
	this.shape_13 = new cjs.Shape();
	this.shape_13.graphics.f("#009933").s().p("AFRlQIAAKhIqhAAIAAqhIKhAA").cp();
	this.shape_13.setTransform(33.8,33.8);

	this.addChild(this.shape_13);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,67.5,67.5);


(lib.BlackBox = function() {
	this.initialize();

	// Layer 1
	this.shape_14 = new cjs.Shape();
	this.shape_14.graphics.f("#000000").s().p("AC2C2IlrAAIAAlrIFrAAIAAFr").cp();
	this.shape_14.setTransform(18.3,18.3);

	this.addChild(this.shape_14);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,36.5,36.5);


(lib.Wheel = function() {
	this.initialize();

	// Layer 1
	this.shape_15 = new cjs.Shape();
	this.shape_15.graphics.f("#000000").s().dr(-8.75,-27.9,17.5,55.8);
	this.shape_15.setTransform(-11.7,13.6);

	this.instance = new lib.spinnertween("synched",0);
	this.instance.setTransform(-11.4,60.5,3.603,3.603,-89.9,0,0,-5.5,0);

	this.addChild(this.instance,this.shape_15);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(-35.3,-14.2,47.4,99.3);


(lib.Spinner = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// Layer 1
	this.instance_1 = new lib.spinnertween("synched",0);
	this.instance_1.setTransform(0.1,-55.7,1,1,180,0,0,-5.5,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).to({rotation:270.1,x:0.5,y:-55.9},10).to({rotation:360,x:0.9,y:-55.6},10).to({rotation:270.1,x:0.5,y:-55.9},10).to({scaleX:1,scaleY:1,rotation:189.1,x:0.2,y:-55.7},9).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-17.7,-62.3,24.6,13.2);


(lib.Satellite = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{start:16},true);

	// timeline functions:
	this.frame_46 = function() {
		this.gotoAndPlay("start");
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).wait(46).call(this.frame_46));

	// Layer 6
	this.instance_2 = new lib.SatSymbol1();
	this.instance_2.setTransform(26.9,35,1,1,53.1);

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(47));

	// Layer 9
	this.instance_3 = new lib.SatSymbol5();
	this.instance_3.setTransform(25.8,2.8,0.867,0.867,0,0,0,7,7);
	this.instance_3._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_3).wait(8).to({_off:false},0).to({x:26,y:-32.9},4).to({rotation:-50.8,x:-35,y:-6.7},4).to({regY:7.1,rotation:-20.8,x:-2.9,y:-30.1},15).to({regY:7,rotation:-50.8,x:-35,y:-6.7},15).wait(1));

	// Layer 8
	this.instance_4 = new lib.SatSymbol4();
	this.instance_4.setTransform(25.8,28.4,0.965,0.945,52.2,0,0,20.4,15.6);
	this.instance_4._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_4).wait(8).to({_off:false},0).to({regX:40.5,regY:31.1,scaleX:1,scaleY:1,x:26.1,y:18},4).to({regX:40.4,regY:31.4,rotation:1.2,x:4.5,y:25.4},4).to({rotation:31.2,x:15.1,y:17.4},15).to({rotation:1.2,x:4.5,y:25.4},15).wait(1));

	// FlashAICB
	this.instance_5 = new lib.SatSymbol1();
	this.instance_5.setTransform(26,55.9,1,1,52.9,0,0,16.2,13.1);

	this.timeline.addTween(cjs.Tween.get(this.instance_5).to({x:26.1,y:26.1},4).wait(4).to({x:26.3,y:23.8},4).to({regX:16.1,regY:13.2,rotation:0,x:13.3,y:30.4},4).to({rotation:30,x:19.9,y:25.7},15).to({rotation:0,x:13.3,y:30.4},15).wait(1));

	// FlashAICB
	this.instance_6 = new lib.SatSymbol3();
	this.instance_6.setTransform(28.5,68.1,1,1,112.9,0,0,37.8,8.1);

	this.timeline.addTween(cjs.Tween.get(this.instance_6).to({x:26.6,y:38.3},4).to({y:11.3},4).to({regX:37.7,scaleX:1,scaleY:1,rotation:68,x:22.9,y:4.4},3).to({regX:22.9,regY:14.8,scaleX:1,scaleY:1,rotation:52.9,x:12.9,y:-4.7},1).to({rotation:0,x:-17.3,y:23.8},4).to({regX:22.8,regY:14.7,rotation:30,x:-3.4,y:4.4},15).to({regX:22.9,regY:14.8,rotation:0,x:-17.3,y:23.8},15).wait(1));

	// FlashAICB
	this.instance_7 = new lib.SatSymbol2();
	this.instance_7.setTransform(29.5,68,1,1,-12.7,0,0,8.1,41.2);

	this.timeline.addTween(cjs.Tween.get(this.instance_7).to({x:27.6,y:38.3},4).to({y:11.3},4).to({regY:41.1,scaleX:1,scaleY:1,rotation:36.6,x:31.7,y:3.1},3).to({regX:11.3,regY:24.6,scaleX:1,scaleY:1,rotation:52.9,x:42.3,y:-4.3},1).to({rotation:0,x:0.5,y:0.5},4).to({rotation:30,x:23.7,y:-6.4},15).to({rotation:0,x:0.5,y:0.5},15).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(5.7,24.6,45,53.9);


(lib.MovingWheel = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// timeline functions:
	this.frame_9 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).wait(9).call(this.frame_9));

	// Layer 1
	this.instance_8 = new lib.Wheel("synched",0);
	this.instance_8.setTransform(-0.8,-100.8,1,1,0,0,0,-11.6,35.4);

	this.timeline.addTween(cjs.Tween.get(this.instance_8).to({y:-0.7},9).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-24.6,-150.5,47.4,99.3);


(lib.Mouth = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{go:1},true);

	// timeline functions:
	this.frame_0 = function() {
		this.stop();
	}
	this.frame_34 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(34).call(this.frame_34));

	// Layer 8
	this.instance_9 = new lib.WhiteBox();
	this.instance_9.setTransform(21.4,19.7,0.105,0.12,0,0,0,80,138);
	this.instance_9._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_9).wait(24).to({_off:false},0).to({y:41.8},10).wait(1));

	// Layer 7
	this.instance_10 = new lib.WhiteBox();
	this.instance_10.setTransform(63.6,19.7,0.105,0.12,0,0,0,80,138);
	this.instance_10._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_10).wait(24).to({_off:false},0).to({y:41.8},10).wait(1));

	// Layer 6
	this.instance_11 = new lib.WhiteBox();
	this.instance_11.setTransform(42.5,19.7,0.105,0.12,0,0,0,80,138);
	this.instance_11._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_11).wait(24).to({_off:false},0).to({y:41.8},10).wait(1));

	// Layer 5
	this.instance_12 = new lib.WhiteBox();
	this.instance_12.setTransform(42.5,19.7,0.105,0.12,0,0,0,80,138);
	this.instance_12._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_12).wait(15).to({_off:false},0).wait(20));

	// Layer 3
	this.instance_13 = new lib.WhiteBox();
	this.instance_13.setTransform(9,3,0.105,0.12,0,0,0,79,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_13).to({x:0.2,y:3.1},15).wait(20));

	// Layer 1
	this.instance_14 = new lib.WhiteBox();
	this.instance_14.setTransform(30.2,26.1,0.105,0.167,0,0,0,80,138);

	this.timeline.addTween(cjs.Tween.get(this.instance_14).to({scaleY:0.12,x:21.4,y:19.7},15).wait(20));

	// Layer 2
	this.instance_15 = new lib.WhiteBox();
	this.instance_15.setTransform(52.2,26.1,0.105,0.167,0,0,0,80,138);

	this.timeline.addTween(cjs.Tween.get(this.instance_15).to({scaleY:0.12,x:63.6,y:19.7},15).wait(20));

	// Layer 4
	this.instance_16 = new lib.WhiteBox();
	this.instance_16.setTransform(73.3,3,0.105,0.12,0,0,0,79,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_16).to({x:84.7,y:3.1},15).wait(20));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0.7,3,80.9,23.5);


(lib.Finger = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// timeline functions:
	this.frame_14 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).wait(14).call(this.frame_14));

	// Layer 2
	this.instance_17 = new lib.BlackBox("synched",0);
	this.instance_17.setTransform(0.5,16.6,0.214,0.439,0,0,0,18.2,18.2);
	this.instance_17._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_17).wait(9).to({startPosition:0,_off:false},0).to({y:28.3},5).wait(1));

	// Layer 1
	this.instance_18 = new lib.BlackBox("synched",0);
	this.instance_18.setTransform(-6.1,-16.4,0.369,0.484);

	this.timeline.addTween(cjs.Tween.get(this.instance_18).to({regX:18.2,regY:18.2,scaleY:0.64,x:0.5,y:13.1},4).wait(11));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-6.1,-16.4,13.5,17.7);


(lib.Eyes = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{eyego:1},true);

	// timeline functions:
	this.frame_0 = function() {
		this.stop();
	}
	this.frame_14 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(14).call(this.frame_14));

	// pupil2
	this.instance_19 = new lib.BlackBox();
	this.instance_19.setTransform(16,-15,0.219,0.219,0,0,0,18.2,18.2);

	this.timeline.addTween(cjs.Tween.get(this.instance_19).to({x:0.5,y:-14.2},14).wait(1));

	// pupil1
	this.instance_20 = new lib.BlackBox();
	this.instance_20.setTransform(-129,-18.7,0.219,0.219,0,0,0,18.2,18.2);

	this.timeline.addTween(cjs.Tween.get(this.instance_20).to({x:-118.7,y:-14.2},14).wait(1));

	// mainEye2
	this.instance_21 = new lib.WhiteBox();
	this.instance_21.setTransform(22.5,6.6,0.335,0.309,0,0,0,158,140.1);

	this.timeline.addTween(cjs.Tween.get(this.instance_21).to({regX:158.1,scaleX:0.55},14).wait(1));

	// mainEye1
	this.instance_22 = new lib.WhiteBox();
	this.instance_22.setTransform(-144.6,6.6,0.335,0.309,0,0,0,0,140.1);

	this.timeline.addTween(cjs.Tween.get(this.instance_22).to({scaleX:0.53},14).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-144.7,-36.7,167.2,43.3);


(lib.Circle = function() {
	this.initialize();

	// Layer 1
	this.instance_23 = new lib.Tween56("synched",0);
	this.instance_23.setTransform(43.5,43.5);

	this.addChild(this.instance_23);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,87,87);


(lib.Badge = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// timeline functions:
	this.frame_18 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).wait(18).call(this.frame_18));

	// Layer 1
	this.instance_24 = new lib.GreenBox();
	this.instance_24.setTransform(1.5,0.8,1,1,0,0,0,33.8,33.8);

	this.instance_25 = new lib.GreenBox();
	this.instance_25.setTransform(1.5,0.8,1,1,0,0,0,33.8,33.8);

	this.instance_26 = new lib.GreenBox();
	this.instance_26.setTransform(1.5,0.8,1,1,0,0,0,33.8,33.8);

	this.instance_27 = new lib.GreenBox();
	this.instance_27.setTransform(1.5,0.8,1,1,0,0,0,33.8,33.8);

	this.instance_28 = new lib.GreenBox();
	this.instance_28.setTransform(1.5,0.8,1,1,0,0,0,33.8,33.8);

	this.instance_29 = new lib.GreenBox();
	this.instance_29.setTransform(1.5,0.8,1,1,0,0,0,33.8,33.8);

	this.instance_30 = new lib.GreenBox();
	this.instance_30.setTransform(1.5,0.8,1,1,0,0,0,33.8,33.8);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_24,p:{scaleX:1,scaleY:1,x:1.5,y:0.8}}]}).to({state:[{t:this.instance_25,p:{scaleX:1,scaleY:1,x:1.5,y:0.8}},{t:this.instance_24,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:54.8}}]},3).to({state:[{t:this.instance_26,p:{scaleX:1,scaleY:1,x:1.5,y:0.8}},{t:this.instance_25,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:54.8}},{t:this.instance_24,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:54.8}}]},3).to({state:[{t:this.instance_27,p:{scaleX:1,scaleY:1,x:1.5,y:0.8}},{t:this.instance_26,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:54.8}},{t:this.instance_25,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:54.8}},{t:this.instance_24,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:91.3}}]},3).to({state:[{t:this.instance_28,p:{scaleX:1,scaleY:1,x:1.5,y:0.8}},{t:this.instance_27,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:54.8}},{t:this.instance_26,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:54.8}},{t:this.instance_25,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:91.3}},{t:this.instance_24,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:91.3}}]},3).to({state:[{t:this.instance_29,p:{scaleX:1,scaleY:1,x:1.5,y:0.8}},{t:this.instance_28,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:54.8}},{t:this.instance_27,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:54.8}},{t:this.instance_26,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:91.3}},{t:this.instance_25,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:91.3}},{t:this.instance_24,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:128.2}}]},3).to({state:[{t:this.instance_30},{t:this.instance_29,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:54.8}},{t:this.instance_28,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:54.8}},{t:this.instance_27,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:91.3}},{t:this.instance_26,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:91.3}},{t:this.instance_25,p:{scaleX:0.471,scaleY:0.471,x:19.3,y:128.2}},{t:this.instance_24,p:{scaleX:0.471,scaleY:0.471,x:-16.3,y:128.2}}]},3).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-32.3,-32.9,67.5,67.5);


(lib.Arm2 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// timeline functions:
	this.frame_26 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).wait(26).call(this.frame_26));

	// top
	this.instance_31 = new lib.BlackBox("synched",0);
	this.instance_31.setTransform(-40.8,-71.7,0.048,1.193);

	this.timeline.addTween(cjs.Tween.get(this.instance_31).to({scaleX:1.3},6).to({x:-5.8,y:-72},5).to({startPosition:0},6).wait(10));

	// bottom
	this.instance_32 = new lib.BlackBox("synched",0);
	this.instance_32.setTransform(-5.9,-56.1,1.296,0.707);
	this.instance_32._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_32).wait(11).to({startPosition:0,_off:false},0).to({y:6.1},6).to({startPosition:0},8).wait(2));

	// fingers
	this.instance_33 = new lib.Finger();
	this.instance_33.setTransform(-15.9,21,1,1,90,0,0,0.5,18.9);

	this.instance_34 = new lib.Finger();
	this.instance_34.setTransform(-6.4,44,1,1,30,0,0,0.5,18.9);

	this.instance_35 = new lib.Finger();
	this.instance_35.setTransform(-6.4,44,1,1,30,0,0,0.5,18.9);

	this.instance_36 = new lib.Finger();
	this.instance_36.setTransform(-6.4,44,1,1,30,0,0,0.5,18.9);

	this.instance_37 = new lib.Finger();
	this.instance_37.setTransform(-6.4,44,1,1,30,0,0,0.5,18.9);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[{t:this.instance_33,p:{rotation:90,x:-15.9}}]},17).to({state:[{t:this.instance_34,p:{rotation:30,x:-6.4,y:44}},{t:this.instance_33,p:{rotation:90,x:-15.9}}]},2).to({state:[{t:this.instance_35,p:{rotation:30,x:-6.4}},{t:this.instance_34,p:{rotation:0,x:17.5,y:44}},{t:this.instance_33,p:{rotation:90,x:-15.9}}]},2).to({state:[{t:this.instance_36,p:{rotation:30,x:-6.4}},{t:this.instance_35,p:{rotation:0,x:17.5}},{t:this.instance_34,p:{rotation:-29.9,x:41.8,y:44}},{t:this.instance_33,p:{rotation:90,x:-15.9}}]},2).to({state:[{t:this.instance_37},{t:this.instance_36,p:{rotation:0,x:17.5}},{t:this.instance_35,p:{rotation:-29.9,x:41.8}},{t:this.instance_34,p:{rotation:90,x:-15.9,y:21}},{t:this.instance_33,p:{rotation:-89.9,x:52.3}}]},2).wait(2));

	// Layer 4
	this.instance_38 = new lib.BlackBox("synched",0);
	this.instance_38.setTransform(28.5,-31.7,0.369,0.075,0,0,0,18.2,17.9);
	this.instance_38._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_38).wait(11).to({startPosition:0,_off:false},0).to({regY:18.2,scaleY:1.18,y:-11.4},6).wait(10));

	// Layer 10
	this.instance_39 = new lib.BlackBox("synched",0);
	this.instance_39.setTransform(6.7,-31.7,0.369,0.075,0,0,0,18.2,18.1);
	this.instance_39._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_39).wait(11).to({startPosition:0,_off:false},0).to({regY:18.2,scaleY:1.17,y:-11.4},6).wait(10));

	// arm
	this.instance_40 = new lib.BlackBox("synched",0);
	this.instance_40.setTransform(-17.7,-50.4,1.329,0.601,0,0,0,18.2,18.2);
	this.instance_40._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_40).wait(6).to({startPosition:0,_off:false},0).wait(21));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-40.8,-71.7,1.8,43.6);


(lib.Arm = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// timeline functions:
	this.frame_48 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).wait(48).call(this.frame_48));

	// Layer 6
	this.instance_41 = new lib.Symbol2();
	this.instance_41.setTransform(109.7,-28.3,1,1,90,0,0,14.3,12.2);

	this.timeline.addTween(cjs.Tween.get(this.instance_41).to({x:85.7},5).wait(44));

	// Layer 5
	this.instance_42 = new lib.Symbol2();
	this.instance_42.setTransform(109.7,-28.3,1,1,90,0,0,14.3,12.2);

	this.timeline.addTween(cjs.Tween.get(this.instance_42).to({x:85.7},5).to({x:64.9},14).to({regX:14.2,regY:12.1,rotation:70,x:67.1,y:-24.2},2).wait(28));

	// Layer 4
	this.instance_43 = new lib.Symbol2();
	this.instance_43.setTransform(109.7,-28.3,1,1,90,0,0,14.3,12.2);

	this.timeline.addTween(cjs.Tween.get(this.instance_43).to({x:85.7},5).to({x:44.1},14).to({regX:14.2,regY:12.1,rotation:70,x:47.5,y:-17.1},2).to({regX:14.3,rotation:51.5,x:50.8,y:-13.2},2).wait(26));

	// Layer 3
	this.instance_44 = new lib.Symbol2();
	this.instance_44.setTransform(109.7,-28.3,1,1,90,0,0,14.3,12.2);

	this.timeline.addTween(cjs.Tween.get(this.instance_44).to({x:85.7},5).to({x:23.3},14).to({regX:14.2,regY:12.1,rotation:70,x:28,y:-10},2).to({regX:14.3,rotation:51.5,x:34.5,y:-0.2},2).to({rotation:33.8,x:37.2,y:1.8},2).wait(24));

	// Layer 2
	this.instance_45 = new lib.Symbol2();
	this.instance_45.setTransform(109.7,-28.3,1,1,90,0,0,14.3,12.2);

	this.timeline.addTween(cjs.Tween.get(this.instance_45).to({x:85.7},5).to({x:2.5},14).to({regX:14.2,regY:12.1,rotation:70,x:8.4,y:-2.8},2).to({regX:14.3,regY:12.2,rotation:51.5,x:18.2,y:12.6},2).to({regY:12.1,rotation:33.8,x:25.7,y:19},2).to({scaleX:1,scaleY:1,rotation:28.3,x:26.5,y:20.3},1).to({scaleX:1,scaleY:1,rotation:22.9,x:27.4,y:21.3},1).wait(22));

	// FlashAICB
	this.instance_46 = new lib.Symbol1();
	this.instance_46.setTransform(102,-28.3,1,1,-89.9,0,0,32.5,31.1);

	this.timeline.addTween(cjs.Tween.get(this.instance_46).to({rotation:90,x:63.3},5).to({x:-34.5},14).to({rotation:70,x:-26.5,y:9.8},2).to({rotation:51.5,x:-10.8,y:35.7},2).to({regX:33.2,regY:12.3,rotation:33.8,x:15.9,y:34.8},2).to({regX:32.2,regY:17.1,rotation:1.4,x:17.4,y:43.2},4).to({rotation:1.4},8).to({rotation:46.4,x:17.3},4).to({regY:17,scaleX:1,scaleY:1,rotation:-41.7},3).to({regY:17.1,scaleX:1,scaleY:1,rotation:1.4,x:17.4},4).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(70.9,-60.9,62.3,65);


(lib.Monocle = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// timeline functions:
	this.frame_9 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).wait(9).call(this.frame_9));

	// Layer 2
	this.instance_47 = new lib.BlackBox();
	this.instance_47.setTransform(1.2,-14.1,0.219,0.219,0,0,0,18.2,18.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_47}]}).wait(10));

	// Layer 1
	this.instance_48 = new lib.Circle();
	this.instance_48.setTransform(1.1,-13.9,0.087,0.087,0,0,0,43.2,43.2);

	this.timeline.addTween(cjs.Tween.get(this.instance_48).to({regX:43.5,regY:43.5,scaleX:0.82,scaleY:0.82,x:1.3,y:-14},9).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-2.7,-18.2,8,8);

})(lib = lib||{}, images = images||{}, createjs = createjs||{});
var lib, images, createjs;
