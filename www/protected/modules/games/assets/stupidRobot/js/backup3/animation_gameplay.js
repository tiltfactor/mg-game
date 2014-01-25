(function (lib, img, cjs) {

var p; // shortcut to reference prototypes

// stage content:
(lib.animation_gameplay = function() {
	this.initialize();

	// Layer 1
	this.robot = new lib.Robot();
	this.robot.setTransform(170,121.3,1.23,1.23,0,0,0,0.4,-5.9);

	this.addChild(this.robot);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(129.2,48.6,81.8,149.8);


// symbols:
(lib.Tween1 = function() {
	this.initialize();

	// Layer 1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#000000").s().p("AAAh6IgXB3QgSAGgMAQQgLARAAAUQgBAcAUATQATATAaAAQAbABATgUQATgTAAgbQABgVgMgRQgMgQgSgGIgYh3").cp();
	this.shape.setTransform(-5.5,0,1,1,90,0,0,0,5.6);

	this.addChild(this.shape);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(-12.2,-6.5,24.6,13.2);


(lib.normalRobot = function() {
	this.initialize();

	// Layer 1
	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#000000").s().p("AANgMIgZAAIAAAZIAZAAIAAgZ").cp();
	this.shape_1.setTransform(56.3,68.7);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#FFFFFF").s().p("AjwjCIHhAAIAAGGInhAAIAAmG").cp();
	this.shape_2.setTransform(50.5,68.7,0.328,0.328);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f("#000000").s().p("AgnAoIBPAAIAAhPIhPAAIAABP").cp();
	this.shape_3.setTransform(13.1,67.6,0.328,0.328);

	this.shape_4 = new cjs.Shape();
	this.shape_4.graphics.f("#FFFFFF").s().p("ADxDEInhAAIAAmGIHhAAIAAGG").cp();
	this.shape_4.setTransform(16.5,68.7,0.328,0.328);

	this.shape_5 = new cjs.Shape();
	this.shape_5.graphics.f("#FFFFFF").s().p("AgXAeIAvAAIAAg8IgvAAIAAA8").cp();
	this.shape_5.setTransform(36.5,86.6);

	this.shape_6 = new cjs.Shape();
	this.shape_6.graphics.f("#FFFFFF").s().p("AgXAYIAvAAIAAgvIgvAAIAAAv").cp();
	this.shape_6.setTransform(23.2,87.2);

	this.shape_7 = new cjs.Shape();
	this.shape_7.graphics.f("#FFFFFF").s().p("AhKCoICVAAIAAlPIiVAAIAAFP").cp();
	this.shape_7.setTransform(30,86.5,0.328,0.185);

	this.shape_8 = new cjs.Shape();
	this.shape_8.graphics.f("#FFFFFF").s().p("AhKBLICVAAIAAiVIiVAAIAACV").cp();
	this.shape_8.setTransform(42.8,87.2,0.328,0.328);

	this.shape_9 = new cjs.Shape();
	this.shape_9.graphics.f("#000000").s().p("AEUmOIg4AAIAAgjIi3AAIgaiAIgVAAIgaCAIi3AAIAAAjIg4AAIAAAiIg4AAIAANcQAAAbATAUQATATAbAAQAcAAATgTQATgUAAgbIGQAAQAAAbAUAUQATATAbAAQAbAAAUgTQATgUAAgbIAAtcIg4AAIAAgi").cp();
	this.shape_9.setTransform(33.3,56.2);

	this.addChild(this.shape_9,this.shape_8,this.shape_7,this.shape_6,this.shape_5,this.shape_4,this.shape_3,this.shape_2,this.shape_1);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,66.5,112.5);


(lib.Laser = function() {
	this.initialize();

	// Layer 1
	this.shape_10 = new cjs.Shape();
	this.shape_10.graphics.f().s("#CC0033").ss(1,1,1).p("Ag2AAIBtAA");
	this.shape_10.setTransform(117.7,-6.5);

	this.addChild(this.shape_10);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.incorrectRobot = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// timeline functions:
	this.frame_43 = function() {
		this.stop();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).wait(43).call(this.frame_43));

	// Layer 7
	this.shape_11 = new cjs.Shape();
	this.shape_11.graphics.f("#FF3300").s().p("ABSgCIhHBEQgGAIgGgIIgPgPQgHgIAHgIIBDhDQANgNAAgSQAAgSgNgMQgMgNgSAAIgpAAQgRAAgNANQgNANAAARQAAALgLAAIgVAAQgLAAAAgLQAAgkAagZQAZgZAjAAIApAAQAkAAAZAZQAZAZAAAkQAAAigZAbIAAAAAAKCWIgTAAQgLAAAAgLIAAgVQAAgLALAAIATAAQALAAAAALIAAAVQAAALgLAAIAAAA").cp();
	this.shape_11.setTransform(-16.8,10.9,1,1,0,0,0,-50,-28.5);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[{t:this.shape_11}]},2).to({state:[]},2).to({state:[{t:this.shape_11}]},2).to({state:[]},2).to({state:[{t:this.shape_11}]},2).wait(34));

	// FlashAICB
	this.shape_12 = new cjs.Shape();
	this.shape_12.graphics.f("#000000").s().p("AANgMIgZAAIAAAZIAZAAIAAgZ").cp();
	this.shape_12.setTransform(56.3,68.7);

	this.shape_13 = new cjs.Shape();
	this.shape_13.graphics.f("#FFFFFF").s().p("AjwjCIHhAAIAAGGInhAAIAAmG").cp();
	this.shape_13.setTransform(50.5,68.7,0.328,0.328);

	this.shape_14 = new cjs.Shape();
	this.shape_14.graphics.f().s("#FFFFFF").ss(2,1,1).p("AhIgLICSAX");
	this.shape_14.setTransform(47.8,66.4);

	this.shape_15 = new cjs.Shape();
	this.shape_15.graphics.f("#000000").s().p("AANgMIgZAAIAAAZIAZAAIAAgZ").cp();
	this.shape_15.setTransform(56.3,68.7);

	this.shape_16 = new cjs.Shape();
	this.shape_16.graphics.f().s("#FFFFFF").ss(2,1,1).p("AhFAaICLgz");
	this.shape_16.setTransform(47.8,66.4);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_13},{t:this.shape_12}]}).to({state:[{t:this.shape_14}]},2).to({state:[{t:this.shape_15},{t:this.shape_13},{t:this.shape_12}]},2).to({state:[{t:this.shape_16}]},2).to({state:[{t:this.shape_13},{t:this.shape_12}]},2).to({state:[{t:this.shape_16}]},2).to({state:[{t:this.shape_14}]},2).to({state:[{t:this.shape_13},{t:this.shape_12}]},2).wait(30));

	// lEye
	this.shape_17 = new cjs.Shape();
	this.shape_17.graphics.f("#FFFFFF").s().p("AgXAeIAvAAIAAg8IgvAAIAAA8").cp();
	this.shape_17.setTransform(36.5,86.6);

	this.shape_18 = new cjs.Shape();
	this.shape_18.graphics.f("#FFFFFF").s().p("AgXAYIAvAAIAAgvIgvAAIAAAv").cp();
	this.shape_18.setTransform(23.2,87.2);

	this.shape_19 = new cjs.Shape();
	this.shape_19.graphics.f("#FFFFFF").s().p("AhKCoICVAAIAAlPIiVAAIAAFP").cp();
	this.shape_19.setTransform(30,86.5,0.328,0.185);

	this.shape_20 = new cjs.Shape();
	this.shape_20.graphics.f("#FFFFFF").s().p("AhKBLICVAAIAAiVIiVAAIAACV").cp();
	this.shape_20.setTransform(42.8,87.2,0.328,0.328);

	this.shape_21 = new cjs.Shape();
	this.shape_21.graphics.f("#000000").s().p("AgnAoIBPAAIAAhPIhPAAIAABP").cp();
	this.shape_21.setTransform(13.1,67.6,0.328,0.328);

	this.shape_22 = new cjs.Shape();
	this.shape_22.graphics.f("#FFFFFF").s().p("ABPBAIidAAIAAh/ICdAAIAAB/").cp();
	this.shape_22.setTransform(16.5,68.8);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_22},{t:this.shape_21},{t:this.shape_20},{t:this.shape_19},{t:this.shape_18},{t:this.shape_17}]}).wait(44));

	// Layer 1
	this.shape_23 = new cjs.Shape();
	this.shape_23.graphics.f("#000000").s().p("AEUmOIg4AAIAAgjIi3AAIgaiAIgVAAIgaCAIi3AAIAAAjIg4AAIAAAiIg4AAIAANcQAAAbATAUQATATAbAAQAcAAATgTQATgUAAgbIGQAAQAAAbAUAUQATATAbAAQAbAAAUgTQATgUAAgbIAAtcIg4AAIAAgi").cp();
	this.shape_23.setTransform(33.3,56.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_23}]}).wait(44));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,66.5,112.5);


(lib.Eyebrow = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// eyebrows
	this.shape_24 = new cjs.Shape();
	this.shape_24.graphics.f().s("#FFFFFF").ss(1.7,1,1).p("AhMAAICZAA");
	this.shape_24.setTransform(17.4,58.5);

	this.shape_25 = new cjs.Shape();
	this.shape_25.graphics.f().s("#FFFFFF").ss(1.7,1,1).p("AhKAVQBCg1BTAP");
	this.shape_25.setTransform(17.7,57.4);

	this.shape_26 = new cjs.Shape();
	this.shape_26.graphics.f().s("#FFFFFF").ss(1.7,1,1).p("AhKAcQA5hYBcA1");
	this.shape_26.setTransform(17.5,56.1);

	this.shape_27 = new cjs.Shape();
	this.shape_27.graphics.f().s("#FFFFFF").ss(1.7,1,1).p("AhLAfQBBhoBWBI");
	this.shape_27.setTransform(17.2,54.2);

	this.shape_28 = new cjs.Shape();
	this.shape_28.graphics.f().s("#FFFFFF").ss(1.7,1,1).p("AhMAPQBMhFBNBJ");
	this.shape_28.setTransform(17.4,54.8);

	this.shape_29 = new cjs.Shape();
	this.shape_29.graphics.f().s("#FFFFFF").ss(1.7,1,1).p("AhMAIQBMghBNAh");
	this.shape_29.setTransform(17.4,56.7);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_24}]}).to({state:[{t:this.shape_25}]},1).to({state:[{t:this.shape_26}]},1).to({state:[{t:this.shape_27}]},1).to({state:[{t:this.shape_28}]},14).to({state:[{t:this.shape_29}]},1).to({state:[{t:this.shape_24}]},1).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,0,0);


(lib.Bulb = function() {
	this.initialize();

	// Layer 1
	this.shape_30 = new cjs.Shape();
	this.shape_30.graphics.f("#000000").s().p("ACfgkQgRAkggAXQgFAFgFAMQgEAIgFARQgFARgDAIQgFANgFAKIgEAIIgGgHQgYgggVgnIgCgCIACgDQAGgLAHgQQAnhRgRgmQgIgQgQgHQgKgEgOAAQgOAAgMAFQgQAHgIAQQgSAlAjBPQAIASAFAKIACADIgCADQgXAngYAfIgGAHIgFgIQgFgJgEgOQgDgHgFgRQgFgRgEgIQgFgMgFgFQgggXgRgkQgRgkAAgoQAAhJA0g1QAzgzBIAAQBJAAAzAzQA1A1AABJQAAAogSAkIAAAAADJhqQAAhUg7g6Qg7g7hTAAQhRAAg8A7Qg7A6AABUQAAAuAUAqQATAnAkAdQAJAHAHAQQAEAKAIAYQAKAiAIAQIAABaQAAADAFAJQAHALAIAMQAKAMAJAIQAHAGAEAAIA7AAQADAAAGgGQAJgJAKgNQAJgLAHgLQAFgIABgDIAAhaQAFgLAFgOQADgIAFgRQAIgYAEgKQAHgQAJgHQAkgdAUgnQATgqAAguIAAAAAAFhsQAKAAAGAEQAFACABAFQAHAMgGAaQgGAbgPAgIgHALIgDgLQgOgggEgaQgFgZAHgMQAGgNASAAIAAAAAAFBNQAPAZAQAWIAHAJIhWAAIAHgJQARgXAQgYIADgIIAFAI").cp();
	this.shape_30.setTransform(25.6,30.9);

	this.shape_31 = new cjs.Shape();
	this.shape_31.graphics.f().s("#000000").ss(2.9,1,1).p("AB/iJQABARAAARQAAArgJAmQgNAwgdApQgzBHhGAAQguAAglgd");
	this.shape_31.setTransform(12.8,75.9);

	this.addChild(this.shape_31,this.shape_30);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,45.8,89.8);


(lib.Bolt = function() {
	this.initialize();

	// Layer 1
	this.shape_32 = new cjs.Shape();
	this.shape_32.graphics.f("#000000").s().p("AAFhYIAAAAIgCgBIguA/IA5A8IgbA3IABABIABAAIA3g6Ig6g+IATg6").cp();
	this.shape_32.setTransform(4.4,9.1);

	this.addChild(this.shape_32);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,8.8,18.2);


(lib.scanRobot = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// eyesScan
	this.shape_33 = new cjs.Shape();
	this.shape_33.graphics.f("#000000").s().p("AjbAHIAAgZIAaAAIAAAZIgaAAADCgGIAbAAIAAAYIgbAAIAAgY").cp();
	this.shape_33.setTransform(35.6,68.2);

	this.shape_34 = new cjs.Shape();
	this.shape_34.graphics.f("#FFFFFF").s().p("AjHABIAaAAIAAgZIgaAAIAAAZAhZg/IAAB/IifAAIAAh/ICfAAADWgMIAAAYIAbAAIAAgYIgbAAABaBAIAAh/ICfAAIAAB/IifAA").cp();
	this.shape_34.setTransform(33.5,68.8);

	this.shape_35 = new cjs.Shape();
	this.shape_35.graphics.f("#FFFFFF").s().p("AivABIAbAAIAAgZIgbAAIAAAZAhZg/IAAB/IifAAIAAh/ICfAAADjgMIgbAAIAAAYIAbAAIAAgYABaBAIAAh/ICfAAIAAB/IifAA").cp();
	this.shape_35.setTransform(33.5,68.8);

	this.shape_36 = new cjs.Shape();
	this.shape_36.graphics.f("#000000").s().p("AjIAHIAAgZIAaAAIAAAZIgaAAADJgGIAAAYIgbAAIAAgYIAbAA").cp();
	this.shape_36.setTransform(36.1,68.2);

	this.shape_37 = new cjs.Shape();
	this.shape_37.graphics.f("#000000").s().p("AicAQIgbAAIAAgZIAbAAIAAAZACdgPIAbAAIAAAZIgbAAIAAgZ").cp();
	this.shape_37.setTransform(37,67.3);

	this.shape_38 = new cjs.Shape();
	this.shape_38.graphics.f("#FFFFFF").s().p("Ah5ABIAAgZIgbAAIAAAZIAbAAAhZg/IAAB/IifAAIAAh/ICfAAADAgdIAAAaIAbAAIAAgaIgbAAAD5g/IAAB/IifAAIAAh/ICfAA").cp();
	this.shape_38.setTransform(33.5,68.8);

	this.shape_39 = new cjs.Shape();
	this.shape_39.graphics.f("#000000").s().p("AiugSIAAAZIgaAAIAAgZIAaAAACuASIAAgYIAbAAIAAAYIgbAA").cp();
	this.shape_39.setTransform(36.1,68.2);

	this.shape_40 = new cjs.Shape();
	this.shape_40.graphics.f("#FFFFFF").s().p("Aj4BAIAAh/ICfAAIAAB/IifAAAiUgYIgbAAIAAAZIAbAAIAAgZAD5g/IAAB/IifAAIAAh/ICfAAADIAMIAbAAIAAgYIgbAAIAAAY").cp();
	this.shape_40.setTransform(33.5,68.8);

	this.shape_41 = new cjs.Shape();
	this.shape_41.graphics.f("#FFFFFF").s().p("AhZg/IAAB/IifAAIAAh/ICfAAAjHABIAaAAIAAgZIgaAAIAAAZABaBAIAAh/ICfAAIAAB/IifAAADxgMIgbAAIAAAYIAbAAIAAgY").cp();
	this.shape_41.setTransform(33.5,68.8);

	this.shape_42 = new cjs.Shape();
	this.shape_42.graphics.f("#000000").s().p("AjbAHIAAgZIAaAAIAAAZIgaAAADdgGIAAAYIgbAAIAAgYIAbAA").cp();
	this.shape_42.setTransform(35.6,68.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_34},{t:this.shape_33}]}).to({state:[{t:this.shape_36},{t:this.shape_35}]},1).to({state:[{t:this.shape_38},{t:this.shape_37}]},1).to({state:[{t:this.shape_40},{t:this.shape_39}]},21).to({state:[{t:this.shape_42},{t:this.shape_41}]},1).wait(1));

	// Layer 1
	this.shape_43 = new cjs.Shape();
	this.shape_43.graphics.f("#FFFFFF").s().p("AgXAeIAvAAIAAg8IgvAAIAAA8").cp();
	this.shape_43.setTransform(36.5,86.6);

	this.shape_44 = new cjs.Shape();
	this.shape_44.graphics.f("#FFFFFF").s().p("AgXAYIAvAAIAAgvIgvAAIAAAv").cp();
	this.shape_44.setTransform(23.2,87.2);

	this.shape_45 = new cjs.Shape();
	this.shape_45.graphics.f("#FFFFFF").s().p("AhKCoICVAAIAAlPIiVAAIAAFP").cp();
	this.shape_45.setTransform(30,86.5,0.328,0.185);

	this.shape_46 = new cjs.Shape();
	this.shape_46.graphics.f("#FFFFFF").s().p("AhKBLICVAAIAAiVIiVAAIAACV").cp();
	this.shape_46.setTransform(42.8,87.2,0.328,0.328);

	this.shape_47 = new cjs.Shape();
	this.shape_47.graphics.f("#000000").s().p("AEUmOIg4AAIAAgjIi3AAIgaiAIgVAAIgaCAIi3AAIAAAjIg4AAIAAAiIg4AAIAANcQAAAbATAUQATATAbAAQAcAAATgTQATgUAAgbIGQAAQAAAbAUAUQATATAbAAQAbAAAUgTQATgUAAgbIAAtcIg4AAIAAgi").cp();
	this.shape_47.setTransform(33.3,56.2);

	this.shape_48 = new cjs.Shape();
	this.shape_48.graphics.f("#000000").s().p("AANgMIgZAAIAAAZIAZAAIAAgZ").cp();
	this.shape_48.setTransform(56.3,68.7);

	this.shape_49 = new cjs.Shape();
	this.shape_49.graphics.f("#FFFFFF").s().p("AjwjCIHhAAIAAGGInhAAIAAmG").cp();
	this.shape_49.setTransform(50.5,68.7,0.328,0.328);

	this.shape_50 = new cjs.Shape();
	this.shape_50.graphics.f("#000000").s().p("AgnAoIBPAAIAAhPIhPAAIAABP").cp();
	this.shape_50.setTransform(13.1,67.6,0.328,0.328);

	this.shape_51 = new cjs.Shape();
	this.shape_51.graphics.f("#FFFFFF").s().p("ADxDEInhAAIAAmGIHhAAIAAGG").cp();
	this.shape_51.setTransform(16.5,68.7,0.328,0.328);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_47},{t:this.shape_46},{t:this.shape_45},{t:this.shape_44},{t:this.shape_43}]}).to({state:[{t:this.shape_47},{t:this.shape_46},{t:this.shape_45},{t:this.shape_44},{t:this.shape_43},{t:this.shape_51},{t:this.shape_50},{t:this.shape_49},{t:this.shape_48}]},24).wait(1));

	// laser
	this.instance = new lib.Laser();
	this.instance.setTransform(50.7,-1.6,0.307,1,0,0,0,112.2,-6.4);

	this.timeline.addTween(cjs.Tween.get(this.instance).to({scaleX:12.49,rotation:-18.1,x:51.3,y:-1},4).to({regX:112,regY:-6.5,scaleX:13.48,scaleY:0.71,rotation:0,skewX:45.7,skewY:28.5,x:49,y:-3.2},4).to({regX:111.9,regY:-6.4,scaleX:11.78,scaleY:0.88,rotation:6.6,skewX:0,skewY:0,x:47.8,y:-3.6},3).to({regY:-6.3,scaleX:13.65,scaleY:0.76,rotation:0,skewX:46.2,skewY:28.9,x:47.7,y:-3.1},2).to({scaleX:12.29,scaleY:0.93,rotation:-16.7,skewX:0,skewY:0,x:47.8,y:-3.8},3).to({regY:-6.5,scaleX:11.52,scaleY:0.95,rotation:3.5,x:47.9,y:-2.9},2).to({scaleX:11.85,scaleY:0.97,rotation:-16.5,x:47.8,y:-2.6},2).to({regX:112.2,regY:-6.3,scaleX:0.31,scaleY:1,rotation:0,x:50.7,y:-1.5},4).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,66.5,112.5);


(lib.Flipper = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{pointLeft:0,pointRight:20},true);

	// Layer 1
	this.instance_1 = new lib.Tween1("synched",0);
	this.instance_1.setTransform(0.8,-55.7,1,1,180,0,0,-5.5,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_1).to({rotation:270.1,x:1.2,y:-55.9},10).to({rotation:360,x:1.6,y:-55.6},10).to({rotation:270.1,x:1.2,y:-55.9},10).to({scaleX:1,scaleY:1,rotation:189.1,x:0.9,y:-55.7},9).wait(1));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-17,-62.3,24.6,13.2);


(lib.correctRobot = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// fills
	this.shape_52 = new cjs.Shape();
	this.shape_52.graphics.f("#FFFF00").s().p("AAhghIAABDIhBAAIAAhDIBBAA").cp();
	this.shape_52.setTransform(29.2,51.5);

	this.shape_53 = new cjs.Shape();
	this.shape_53.graphics.f("#FFFF00").s().p("AgIghIAABDIhFAAIAAhDIBFAAABOAiIhFAAIAAhDIBFAAIAABD").cp();
	this.shape_53.setTransform(33.6,51.5);

	this.shape_54 = new cjs.Shape();
	this.shape_54.graphics.f("#FFFF00").s().p("ABOgIIhFAAIAAhFIBFAAIAABFAgIAJIAABFIhFAAIAAhFIBFAAABOBOIhFAAIAAhFIBFAAIAABF").cp();
	this.shape_54.setTransform(33.6,47.1);

	this.shape_55 = new cjs.Shape();
	this.shape_55.graphics.f("#FFFF00").s().p("ABOgIIhFAAIAAhFIBFAAIAABFAgIhNIAABFIhFAAIAAhFIBFAAAgIAJIAABFIhFAAIAAhFIBFAAABOBOIhFAAIAAhFIBFAAIAABF").cp();
	this.shape_55.setTransform(33.6,47.1);

	this.shape_56 = new cjs.Shape();
	this.shape_56.graphics.f("#FFFF00").s().p("ABOAhIhFAAIAAhDIBFAAIAABDAhNgiIBFAAIAABDIhFAAIAAhDAhNgzIAAhGIBFAAIAABGIhFAAAgIA0IAABFIhFAAIAAhFIBFAAABOB5IhFAAIAAhFIBFAAIAABF").cp();
	this.shape_56.setTransform(33.6,42.7);

	this.shape_57 = new cjs.Shape();
	this.shape_57.graphics.f("#FFFF00").s().p("ABOgzIhFAAIAAhGIBFAAIAABGABOAhIhFAAIAAhDIBFAAIAABDAhNgiIBFAAIAABDIhFAAIAAhDAhNgzIAAhGIBFAAIAABGIhFAAAgIA0IAABFIhFAAIAAhFIBFAAABOB5IhFAAIAAhFIBFAAIAABF").cp();
	this.shape_57.setTransform(33.6,42.7);

	this.shape_58 = new cjs.Shape();
	this.shape_58.graphics.f("#FFFF00").s().p("ABOgHIhFAAIAAhFIBFAAIAABFABOBOIhFAAIAAhFIBFAAIAABFABOhfIhFAAIAAhFIBFAAIAABFAhNAJIBFAAIAABFIhFAAIAAhFAhNgHIAAhFIBFAAIAABFIhFAAAgIBhIAABFIhFAAIAAhFIBFAAABOCmIhFAAIAAhFIBFAAIAABF").cp();
	this.shape_58.setTransform(33.6,38.3);

	this.shape_59 = new cjs.Shape();
	this.shape_59.graphics.f("#FFFF00").s().p("ABOgHIhFAAIAAhFIBFAAIAABFABOBOIhFAAIAAhFIBFAAIAABFABOhfIhFAAIAAhFIBFAAIAABFAgIikIAABFIhFAAIAAhFIBFAAAhNAJIBFAAIAABFIhFAAIAAhFAgIhMIAABFIhFAAIAAhFIBFAAAgIBhIAABFIhFAAIAAhFIBFAAABOCmIhFAAIAAhFIBFAAIAABF").cp();
	this.shape_59.setTransform(33.6,38.3);

	this.shape_60 = new cjs.Shape();
	this.shape_60.graphics.f("#FFFF00").s().p("ABOgHIhFAAIAAhFIBFAAIAABFABOBOIhFAAIAAhFIBFAAIAABFABOhfIhFAAIAAhFIBFAAIAABFAgIikIAABFIhFAAIAAhFIBFAAAhNAJIBFAAIAABFIhFAAIAAhFAgIhMIAABFIhFAAIAAhFIBFAAAgIBhIAABFIhFAAIAAhFIBFAAAAJBhIBFAAIAABFIhFAAIAAhF").cp();
	this.shape_60.setTransform(33.6,38.3);

	this.shape_61 = new cjs.Shape();
	this.shape_61.graphics.f("#FFFF00").s().p("ABOgIIhFAAIAAhFIBFAAIAABFAhNhNIBFAAIAABFIhFAAIAAhFAgIAJIAABFIhFAAIAAhFIBFAAAAJBOIAAhFIBFAAIAABFIhFAA").cp();
	this.shape_61.setTransform(33.6,47.1);

	this.shape_62 = new cjs.Shape();
	this.shape_62.graphics.f("#FFFF00").s().p("AgIghIAABDIhFAAIAAhDIBFAAAAJghIBFAAIAABDIhFAAIAAhD").cp();
	this.shape_62.setTransform(33.6,51.5);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_52}]}).to({state:[{t:this.shape_53}]},1).to({state:[{t:this.shape_54}]},1).to({state:[{t:this.shape_55}]},1).to({state:[{t:this.shape_56}]},1).to({state:[{t:this.shape_57}]},1).to({state:[{t:this.shape_58}]},1).to({state:[{t:this.shape_59}]},1).to({state:[{t:this.shape_60}]},3).to({state:[{t:this.shape_57}]},12).to({state:[{t:this.shape_61}]},1).to({state:[{t:this.shape_62}]},1).wait(1));

	// grin
	this.shape_63 = new cjs.Shape();
	this.shape_63.graphics.f("#FFFFFF").s().p("AAJgeIAAA8IAyAAIAAg8IgyAAAh5gRIAAAvIAxAAIAAgvIgxAAABJAeIAxAAIAAgvIgxAAIAAAvAg2AeIAyAAIAAg8IgyAAIAAA8").cp();
	this.shape_63.setTransform(33,86.6);

	this.shape_64 = new cjs.Shape();
	this.shape_64.graphics.f("#FFFFFF").s().p("AAJgeIAAA8IAyAAIAAg8IgyAAAh5geIAAAwIAxAAIAAgwIgxAAABJASIAxAAIAAgwIgxAAIAAAwAgEgeIgyAAIAAA8IAyAAIAAg8").cp();
	this.shape_64.setTransform(33,86.6);

	this.shape_65 = new cjs.Shape();
	this.shape_65.graphics.f("#FFFFFF").s().p("AAJgVIAAA8IAyAAIAAg8IgyAAAh5gmIAAAvIAxAAIAAgvIgxAAABJAJIAxAAIAAgvIgxAAIAAAvAg2gVIAAA8IAyAAIAAg8IgyAA").cp();
	this.shape_65.setTransform(33,85.7);

	this.shape_66 = new cjs.Shape();
	this.shape_66.graphics.f("#FFFFFF").s().p("ABJAAIAxAAIAAgwIgxAAIAAAwAAJgLIAAA8IAyAAIAAg8IgyAAAh5gwIAAAwIAxAAIAAgwIgxAAAg2AxIAyAAIAAg8IgyAAIAAA8").cp();
	this.shape_66.setTransform(33,84.7);

	this.shape_67 = new cjs.Shape();
	this.shape_67.graphics.f("#FFFFFF").s().p("AAJgWIAAA8IAyAAIAAg8IgyAAAh5glIAAAvIAxAAIAAgvIgxAAABJAKIAxAAIAAgvIgxAAIAAAvAgEAmIAAg8IgyAAIAAA8IAyAA").cp();
	this.shape_67.setTransform(33,85.8);

	this.shape_68 = new cjs.Shape();
	this.shape_68.graphics.f("#FFFFFF").s().p("AAJgeIAAA8IAyAAIAAg8IgyAAAh5geIAAAwIAxAAIAAgwIgxAAABJASIAxAAIAAgwIgxAAIAAAwAgEAeIAAg8IgyAAIAAA8IAyAA").cp();
	this.shape_68.setTransform(33,86.6);

	this.shape_69 = new cjs.Shape();
	this.shape_69.graphics.f("#FFFFFF").s().p("AAJgeIAAA8IAyAAIAAg8IgyAAAh5gRIAAAvIAxAAIAAgvIgxAAAgEAeIAAg8IgyAAIAAA8IAyAAABJAeIAxAAIAAgvIgxAAIAAAv").cp();
	this.shape_69.setTransform(33,86.6);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_63}]}).to({state:[{t:this.shape_64}]},7).to({state:[{t:this.shape_65}]},1).to({state:[{t:this.shape_66}]},1).to({state:[{t:this.shape_67}]},13).to({state:[{t:this.shape_68}]},1).to({state:[{t:this.shape_69}]},1).wait(1));

	// FlashAICB
	this.shape_70 = new cjs.Shape();
	this.shape_70.graphics.f("#000000").s().p("AANgMIgZAAIAAAZIAZAAIAAgZ").cp();
	this.shape_70.setTransform(56.3,68.7);

	this.shape_71 = new cjs.Shape();
	this.shape_71.graphics.f("#FFFFFF").s().p("AjwjCIHhAAIAAGGInhAAIAAmG").cp();
	this.shape_71.setTransform(50.5,68.7,0.328,0.328);

	this.shape_72 = new cjs.Shape();
	this.shape_72.graphics.f("#000000").s().p("AgnAoIBPAAIAAhPIhPAAIAABP").cp();
	this.shape_72.setTransform(13.1,67.6,0.328,0.328);

	this.shape_73 = new cjs.Shape();
	this.shape_73.graphics.f("#FFFFFF").s().p("ADxDEInhAAIAAmGIHhAAIAAGG").cp();
	this.shape_73.setTransform(16.5,68.7,0.328,0.328);

	this.shape_74 = new cjs.Shape();
	this.shape_74.graphics.f("#000000").s().p("AEUmOIg4AAIAAgjIi3AAIgaiAIgVAAIgaCAIi3AAIAAAjIg4AAIAAAiIg4AAIAANcQAAAbATAUQATATAbAAQAcAAATgTQATgUAAgbIGQAAQAAAbAUAUQATATAbAAQAbAAAUgTQATgUAAgbIAAtcIg4AAIAAgi").cp();
	this.shape_74.setTransform(33.3,56.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_74},{t:this.shape_73},{t:this.shape_72},{t:this.shape_71},{t:this.shape_70}]}).wait(25));

	// bulb
	this.instance_2 = new lib.Bulb();
	this.instance_2.setTransform(32.8,64.1,0.808,0.808,120,0,0,22.4,45.9);

	this.timeline.addTween(cjs.Tween.get(this.instance_2).to({scaleX:1,scaleY:1,rotation:0,x:80.3,y:15.8},3).wait(18).to({scaleX:0.81,scaleY:0.81,rotation:120,x:32.8,y:64.1},3).wait(1));

	// bulbback
	this.shape_75 = new cjs.Shape();
	this.shape_75.graphics.f("#FFFF00").s().p("AhgjTQARgMAOgEQABAAAAAAQAagKA5AAQA0AAAMAKQAUATAaAZQAmAjAMAoQAJAdAAA7QAAAugOATQgGAJgyAtQgUASgWBFQgEAPgHAKQgRAbggAAQgvAAgcgbQgCgCgDgDQgMgPgUgrQgJgTgLgYQgLgbgjglQgZgZAAglQAAg+AGgaQALgnAlgjQATgRASgLIAAAA").cp();
	this.shape_75.setTransform(82.9,-4.8);

	this.shape_76 = new cjs.Shape();
	this.shape_76.graphics.f("#FFFF00").s().p("AhAjjQAagKA5AAQA0AAAMAKQAUATAaAZQAmAjAMAoQAJAdAAA7QAAAugOATQgGAJgyAtQgUASgWBFQgEAPgHAKQgRAbggAAQgvAAgcgbQgCgCgDgDQgMgPgUgrQgJgTgLgYQgLgbgjglQgZgZAAglQAAg+AGgaQALgnAlgjQATgRASgLQARgMAOgEQABAAAAAAIAAAA").cp();
	this.shape_76.setTransform(82.9,-4.8);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[{t:this.shape_75}]},10).to({state:[]},1).to({state:[{t:this.shape_76}]},1).to({state:[]},9).wait(4));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-7.3,0,81.3,112.5);


(lib.confusedRobot = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{},true);

	// Layer 2
	this.instance_3 = new lib.Eyebrow();
	this.instance_3.setTransform(50.1,57.2,1,1,0,0,180,17.4,58.5);

	this.instance_4 = new lib.Eyebrow();
	this.instance_4.setTransform(16.4,57.2,1,1,0,0,0,17.4,58.5);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_4},{t:this.instance_3}]}).wait(20));

	// Layer 4
	this.shape_77 = new cjs.Shape();
	this.shape_77.graphics.f("#000000").s().p("AANgMIgZAAIAAAZIAZAAIAAgZ").cp();
	this.shape_77.setTransform(55.4,68.7);

	this.shape_78 = new cjs.Shape();
	this.shape_78.graphics.f("#FFFFFF").s().p("AjwjCIHhAAIAAGGInhAAIAAmG").cp();
	this.shape_78.setTransform(50.5,68.7,0.328,0.328);

	this.shape_79 = new cjs.Shape();
	this.shape_79.graphics.f("#000000").s().p("AgnAoIBPAAIAAhPIhPAAIAABP").cp();
	this.shape_79.setTransform(13.9,67.6,0.328,0.328);

	this.shape_80 = new cjs.Shape();
	this.shape_80.graphics.f("#FFFFFF").s().p("ADxDEInhAAIAAmGIHhAAIAAGG").cp();
	this.shape_80.setTransform(16.5,68.7,0.328,0.328);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_80},{t:this.shape_79},{t:this.shape_78},{t:this.shape_77}]}).wait(20));

	// Layer 1
	this.shape_81 = new cjs.Shape();
	this.shape_81.graphics.f("#FFFFFF").s().p("AgXAeIAvAAIAAg8IgvAAIAAA8").cp();
	this.shape_81.setTransform(36.5,86.6);

	this.shape_82 = new cjs.Shape();
	this.shape_82.graphics.f("#FFFFFF").s().p("AgXAYIAvAAIAAgvIgvAAIAAAv").cp();
	this.shape_82.setTransform(23.2,87.2);

	this.shape_83 = new cjs.Shape();
	this.shape_83.graphics.f("#FFFFFF").s().p("AhKCoICVAAIAAlPIiVAAIAAFP").cp();
	this.shape_83.setTransform(30,86.5,0.328,0.185);

	this.shape_84 = new cjs.Shape();
	this.shape_84.graphics.f("#FFFFFF").s().p("AhKBLICVAAIAAiVIiVAAIAACV").cp();
	this.shape_84.setTransform(42.8,87.2,0.328,0.328);

	this.shape_85 = new cjs.Shape();
	this.shape_85.graphics.f("#000000").s().p("AEUmOIg4AAIAAgjIi3AAIgaiAIgVAAIgaCAIi3AAIAAAjIg4AAIAAAiIg4AAIAANcQAAAbATAUQATATAbAAQAcAAATgTQATgUAAgbIGQAAQAAAbAUAUQATATAbAAQAbAAAUgTQATgUAAgbIAAtcIg4AAIAAgi").cp();
	this.shape_85.setTransform(33.3,56.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_85},{t:this.shape_84},{t:this.shape_83},{t:this.shape_82},{t:this.shape_81}]}).wait(20));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(0,0,66.5,112.5);


(lib.Robot = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{scan:0,correctAnswer:46,incorrectAnswer:72,confused:96,default:117},true);

	// timeline functions:
	this.frame_0 = function() {
		this.twister.gotoAndPlay("pointLeft");
	}
	this.frame_20 = function() {
		this.twister.gotoAndStop("pointRight");
	}
	this.frame_45 = function() {
		this.twister.gotoAndPlay("pointRight"+1);
		this.gotoAndPlay("default");
	}
	this.frame_46 = function() {
		this.twister.play();
	}
	this.frame_71 = function() {
		this.gotoAndStop("default");
	}
	this.frame_72 = function() {
		this.twister.play();
	}
	this.frame_95 = function() {
		this.gotoAndStop("default");
	}
	this.frame_96 = function() {
		this.twister.play();
	}
	this.frame_116 = function() {
		this.gotoAndStop("default");
	}
	this.frame_117 = function() {
		this.stop();
		this.twister.play();
	}

	// actions tween:
	this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(20).call(this.frame_20).wait(25).call(this.frame_45).wait(1).call(this.frame_46).wait(25).call(this.frame_71).wait(1).call(this.frame_72).wait(23).call(this.frame_95).wait(1).call(this.frame_96).wait(20).call(this.frame_116).wait(1).call(this.frame_117).wait(3));

	// FlashAICB
	this.instance_5 = new lib.Bolt();
	this.instance_5.setTransform(28.6,-76.2,2.369,2.369,20.2,0,0,4.3,9);

	this.instance_6 = new lib.Bolt();
	this.instance_6.setTransform(-32.2,-73.7,2.369,2.369,-9.7,0,0,4.3,9);

	this.instance_7 = new lib.Bolt();
	this.instance_7.setTransform(-32.2,-73.7,2.369,2.369,-9.7,0,0,4.3,9);

	this.instance_8 = new lib.Bolt();
	this.instance_8.setTransform(-32.2,-73.7,2.369,2.369,-9.7,0,0,4.3,9);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[]},46).to({state:[]},25).to({state:[{t:this.instance_5,p:{rotation:20.2,x:28.6,y:-76.2}}]},13).to({state:[]},1).to({state:[{t:this.instance_6,p:{rotation:-9.7,x:-32.2,y:-73.7}},{t:this.instance_5,p:{rotation:20.2,x:28.6,y:-76.2}}]},1).to({state:[{t:this.instance_5,p:{rotation:20.2,x:28.6,y:-76.2}}]},1).to({state:[{t:this.instance_7,p:{scaleX:2.369,scaleY:2.369,rotation:-9.7,x:-32.2,y:-73.7}},{t:this.instance_6,p:{rotation:20.2,x:28.6,y:-76.2}},{t:this.instance_5,p:{rotation:50.2,x:59.9,y:-46.1}}]},1).to({state:[{t:this.instance_6,p:{rotation:-9.7,x:-32.2,y:-73.7}},{t:this.instance_5,p:{rotation:20.2,x:28.6,y:-76.2}}]},1).to({state:[{t:this.instance_8},{t:this.instance_7,p:{scaleX:2.644,scaleY:2.644,rotation:-54.7,x:-68,y:-48.6}},{t:this.instance_6,p:{rotation:20.2,x:28.6,y:-76.2}},{t:this.instance_5,p:{rotation:50.2,x:59.9,y:-46.1}}]},1).to({state:[{t:this.instance_6,p:{rotation:-9.7,x:-32.2,y:-73.7}},{t:this.instance_5,p:{rotation:50.2,x:59.9,y:-46.1}}]},1).to({state:[{t:this.instance_8},{t:this.instance_7,p:{scaleX:2.644,scaleY:2.644,rotation:-54.7,x:-68,y:-48.6}},{t:this.instance_6,p:{rotation:20.2,x:28.6,y:-76.2}},{t:this.instance_5,p:{rotation:50.2,x:59.9,y:-46.1}}]},1).to({state:[{t:this.instance_7,p:{scaleX:2.369,scaleY:2.369,rotation:-9.7,x:-32.2,y:-73.7}},{t:this.instance_6,p:{rotation:20.2,x:28.6,y:-76.2}},{t:this.instance_5,p:{rotation:50.2,x:59.9,y:-46.1}}]},1).to({state:[{t:this.instance_6,p:{rotation:-9.7,x:-32.2,y:-73.7}},{t:this.instance_5,p:{rotation:20.2,x:28.6,y:-76.2}}]},1).to({state:[{t:this.instance_5,p:{rotation:20.2,x:28.6,y:-76.2}}]},1).to({state:[]},1).to({state:[]},20).wait(5));

	// Layer 2
	this.twister = new lib.Flipper();
	this.twister.setTransform(-0.3,-58.3,1,1,0,0,0,-0.1,-55.8);

	this.timeline.addTween(cjs.Tween.get(this.twister).wait(79).to({rotation:-4.5,x:-12.1,y:-58},0).wait(1).to({regX:0,regY:-55.6,rotation:4.4,x:3.8,y:-58.1},0).wait(1).to({regX:0,regY:-55.7,rotation:0,x:-7.2,y:-58.2},0).wait(1).to({regX:0,regY:-55.6,rotation:4.4,x:3.8,y:-58.1},0).wait(1).to({regX:0,regY:-55.7,rotation:-4.5,x:-12.1,y:-58},0).wait(1).wait(1).to({regX:0,regY:-55.6,rotation:4.4,x:3.8,y:-58.1},0).wait(1).to({regX:0,regY:-55.7,rotation:0,x:-7.2,y:-58.2},0).wait(1).to({regX:0,regY:-55.6,rotation:4.4,x:3.8,y:-58.1},0).wait(1).to({regX:0,regY:-55.7,rotation:-4.5,x:-12.1,y:-58},0).wait(1).to({rotation:0,x:-0.2,y:-58.2},0).wait(32));

	// Layer 1
	this.instance_9 = new lib.normalRobot();
	this.instance_9.setTransform(0.5,0.5,1,1,0,0,0,33.2,56.2);

	this.instance_10 = new lib.scanRobot();
	this.instance_10.setTransform(0.5,0.5,1,1,0,0,0,33.2,56.2);

	this.instance_11 = new lib.correctRobot();
	this.instance_11.setTransform(0.5,0.5,1,1,0,0,0,33.2,56.2);

	this.instance_12 = new lib.incorrectRobot();
	this.instance_12.setTransform(0.5,0.5,1,1,0,0,0,33.2,56.2);

	this.instance_13 = new lib.confusedRobot();
	this.instance_13.setTransform(0.5,0.5,1,1,0,0,0,33.2,56.2);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_9}]}).to({state:[{t:this.instance_10}]},20).to({state:[{t:this.instance_11}]},26).to({state:[{t:this.instance_12,p:{rotation:0,x:0.5,y:0.5}}]},26).to({state:[{t:this.instance_12,p:{rotation:-4.6,x:-6.5,y:0.4}}]},7).to({state:[{t:this.instance_12,p:{rotation:4.4,x:0.1,y:0.4}}]},1).to({state:[{t:this.instance_12,p:{rotation:0,x:-6.4,y:0.5}}]},1).to({state:[{t:this.instance_12,p:{rotation:4.4,x:0.1,y:0.4}}]},1).to({state:[{t:this.instance_12,p:{rotation:-4.6,x:-6.5,y:0.4}}]},1).to({state:[{t:this.instance_12,p:{rotation:-4.6,x:-6.5,y:0.4}}]},1).to({state:[{t:this.instance_12,p:{rotation:4.4,x:0.1,y:0.4}}]},1).to({state:[{t:this.instance_12,p:{rotation:0,x:-6.4,y:0.5}}]},1).to({state:[{t:this.instance_12,p:{rotation:4.4,x:0.1,y:0.4}}]},1).to({state:[{t:this.instance_12,p:{rotation:-4.6,x:-6.5,y:0.4}}]},1).to({state:[{t:this.instance_12,p:{rotation:0,x:0.5,y:0.5}}]},1).to({state:[{t:this.instance_12,p:{rotation:0,x:0.5,y:0.5}}]},1).to({state:[{t:this.instance_9}]},4).to({state:[{t:this.instance_13}]},2).to({state:[{t:this.instance_13}]},20).to({state:[{t:this.instance_9}]},1).wait(4));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-32.7,-65,66.5,121.8);

})(lib = lib||{}, images = images||{}, createjs = createjs||{});
var lib, images, createjs;