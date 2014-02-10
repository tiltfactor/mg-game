MG_GAME_STUPIDROBOT = function ($) {
    return $.extend(MG_GAME_API, {
    	init_options:null,
    	server_init:false,

    	// the following is copied from pyramid tag
        wordField:null,
        playOnceMoveOnFinalScreenWaitingTime:15000, // milliseconds
        submitButton:null,
        media:null,
        licence_info:[],
        more_info:null,
        levels:[],
        // level:1,
        pass_penalty: 0, // in seconds
        level_step:3,
        words:[],
        sound: {},
        sounds: {},

        // the following variable is newly added in stupidrobot for gaming:
        startingLevel: 4,
        level: null,
        maxLevel: 13,
        letterWidthInEms: 0.67,
        speed: 200,
        secs: 120,
        fields: null,
        animation: null,
        scorehtml:"",
        loadgame:"",
        wordsAccepted: 0,
        inputlength: 0,
        main_menu_bar: null,

        // new added for scoring
        isRenderFinaled: false,
    	wordSpaces:null,
    	wordArray:["!", "!", "!", "!", "!", "!", "!", "!", "!", "!",],
    	// wordArray:["word",
		 //"word","word","word","word","word","word","word","word","word",],
    	a:"",
    	p:null,
    	i:0,
    	activeLine:0,
    	scorestage: null,
    	scorelevel:0,

    	// new added for splash page
    	idx_paragraphArray: null,
    	idx_introText: ["Meet Stupid Robot.",
    	"Stupid Robot looks at everything but understands nothing.",
    	"Can you help?",
    	"Fill Stupid Robot’s input fields by describing what is in the image.",
    	"Sometimes Stupid Robot has a **DNC ERROR** and can’t process a word.",
    	"** Does Not Compute **",
    	"If that happens, try another word until you find one that works.",
    	"Stupid Robot can only understand short words at first,",
    	"but with your help, Stupid Robot will learn and evolve!"],
    	idx_a : "",
    	idx_p: null,
    	idx_i:0,
    	idx_activeLine:0,

    	idx_scrollIn:function () {
    		MG_GAME_STUPIDROBOT.idx_p=MG_GAME_STUPIDROBOT.idx_paragraphArray[MG_GAME_STUPIDROBOT.idx_activeLine];
    		MG_GAME_STUPIDROBOT.idx_i++;
    		if(MG_GAME_STUPIDROBOT.idx_i > MG_GAME_STUPIDROBOT.idx_introText[MG_GAME_STUPIDROBOT.idx_activeLine].length) {

    			MG_GAME_STUPIDROBOT.idx_paragraphArray[MG_GAME_STUPIDROBOT.idx_activeLine].innerHTML = MG_GAME_STUPIDROBOT.idx_a;
    			MG_GAME_STUPIDROBOT.idx_activeLine++;
    			MG_GAME_STUPIDROBOT.idx_i=0;

    			if(MG_GAME_STUPIDROBOT.idx_activeLine >= MG_GAME_STUPIDROBOT.idx_introText.length){
    				return;
    				}

    			setTimeout("MG_GAME_STUPIDROBOT.idx_scrollIn()",1400);
    			return;
    		 }

    		MG_GAME_STUPIDROBOT.idx_a = MG_GAME_STUPIDROBOT.idx_introText[MG_GAME_STUPIDROBOT.idx_activeLine].substring(0,MG_GAME_STUPIDROBOT.idx_i);
    		MG_GAME_STUPIDROBOT.idx_p.innerHTML = MG_GAME_STUPIDROBOT.idx_a+"_";
    		setTimeout("MG_GAME_STUPIDROBOT.idx_scrollIn()",20);
    	},



    	idx_init:function (options){
    		// the following three lines is for merging
    		MG_GAME_STUPIDROBOT.loadgame = $("#loadgame").html();
    		$("#loadgame").html("");
    		$("#loadgame").hide();
    		MG_GAME_STUPIDROBOT.main_menu_bar = $("#mainmenu_save").html();

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
    		loader.addEventListener("fileload", MG_GAME_STUPIDROBOT.idx_handleFileLoad);
    		loader.addEventListener("complete", MG_GAME_STUPIDROBOT.idx_handleComplete);
    		loader.loadManifest(manifest);

    		// set up scroller
    		var paragraphCollection=document.getElementsByClassName("scrollText");
    		MG_GAME_STUPIDROBOT.idx_paragraphArray = Array.prototype.slice.call( paragraphCollection );
    		MG_GAME_STUPIDROBOT.idx_paragraphArray.push(document.getElementById("lastScrollText"));

    		// boot game
    		$("#bootButton").click(function(){
    			// this several code is for violent merging
    			$("body").html("");
    			$("body").attr('id','gameContent');
    			$("body").removeClass("splashContent");
    			$("body").addClass("gameContent");
    			$("body").html(MG_GAME_STUPIDROBOT.loadgame);
    			MG_GAME_STUPIDROBOT.init_options = options;
    			MG_GAME_STUPIDROBOT.init(options);
    		});
    	},


    	idx_handleFileLoad:function (evt) {
    		if (evt.item.type == "image") { images[evt.item.id] = evt.result; }
    	},

    	idx_handleComplete:function () {
    		// console.log("complete");
    		var loadScreen=document.getElementById("loading");
    		loadScreen.parentNode.removeChild(loadScreen);


    		exportRoot = new lib.animation_intro();

    		stage = new createjs.Stage(canvas);
    		stage.addChild(exportRoot);
    		stage.update();

    		createjs.Ticker.setFPS(24);
    		createjs.Ticker.addEventListener("tick", stage);

    		setTimeout("MG_GAME_STUPIDROBOT.idx_scrollIn()",2000);

    	},

        init: function (options) {
        	// console.log("init");
        	// TO ZARA: line 46~48, this is point when I load the play page, in
			// your case
        	// your first page would be the splash page. At this very moment of
        	// loading (window.onload in your place), I simply store the html
        	// that is about to be deleted first, and then actually erase it.
        	// By doing so I can handle the conflict of names in html easily
        	MG_GAME_STUPIDROBOT.scorehtml = $("#score").html();
        	$("#score").html("");
        	$("#score").hide();
            var settings = $.extend(options, {
                ongameinit: MG_GAME_STUPIDROBOT.ongameinit
            });
            $("body").prepend(MG_GAME_STUPIDROBOT.main_menu_bar);

            var game_assets_uri = $("#game_assets_uri").val();
            // console.log("jackjackjack" + game_assets_uri);

            MG_GAME_STUPIDROBOT.sounds = {
                fail_sound: game_assets_uri + 'audio/sound_fail.mp3',
                scan_sound: game_assets_uri + 'audio/scan2.mp3',
                letter_0  : game_assets_uri + 'audio/sound0.mp3',
                letter_1  : game_assets_uri + 'audio/sound1.mp3',
                letter_2  : game_assets_uri + 'audio/sound2.mp3',
                letter_3  : game_assets_uri + 'audio/sound3.mp3',
                letter_4  : game_assets_uri + 'audio/sound4.mp3',
                letter_5  : game_assets_uri + 'audio/sound5.mp3',
                letter_6  : game_assets_uri + 'audio/sound6.mp3',
                letter_7  : game_assets_uri + 'audio/sound7.mp3',
                next_level: game_assets_uri + 'audio/right.mp3',
                confused	: game_assets_uri + 'audio/confused2.mp3',
                try_again : game_assets_uri + 'audio/tryagain.mp3',
                score_1   : game_assets_uri + 'audio/score_1.mp3',
                score_2   : game_assets_uri + 'audio/score_2.mp3',
                score_3   : game_assets_uri + 'audio/score_3.mp3',
                score_4   : game_assets_uri + 'audio/score_4.mp3',
                score_5   : game_assets_uri + 'audio/score_5.mp3'

            };
            $.each(MG_GAME_STUPIDROBOT.sounds, function(index, source) {
            	MG_GAME_STUPIDROBOT.sound[index] = new Sound(source);
            });

        	$("#pass").click(function(){
        		$("#inputFields span").eq(MG_GAME_STUPIDROBOT.level - MG_GAME_STUPIDROBOT.startingLevel).addClass("passed");
        		MG_GAME_STUPIDROBOT.level++;
        		MG_GAME_STUPIDROBOT.setLevel();
        		MG_GAME_STUPIDROBOT.playSound('next_level');
        		// ANIMATION ADDITION ~ play "confused" animation for passing
        		animation.robot.gotoAndPlay("confused");

                // send ajax call as POST request to validate a turn
                MG_API.ajaxCall('/games/play/gid/' + MG_GAME_API.settings.gid, function (response) {
                    if (MG_API.checkResponse(response)) {
                    	MG_GAME_STUPIDROBOT.onresponse(response);
                    }
                    return false;
                }, {
                    type:'post',
                    data:{ // this is the data needed for the turn
                        turn: 1,
                        played_game_id:MG_GAME_STUPIDROBOT.game.played_game_id,
                        'submissions':[
                            {
                                media_id:MG_GAME_STUPIDROBOT.media.media_id,
                                tags: "pass",
                                pass: true
                            }
                        ]
                    }
                });
        		}
        	);

        	// fix the loop sound problem after merging them together
            // 1 is because there is only one loop audio in background
            audio.play(1);
            audio.play(1);
        	$("#button-loop-1").click(function(){
        		audio.play(1);
        	});

        	// done button for finishing the game immediately
        	$("#gamedone").click(function(){
        		MG_GAME_STUPIDROBOT.secs = 0;
        	});

        	// set arbitrary level
        	$("#pass").hide();

        	MG_GAME_STUPIDROBOT.level = MG_GAME_STUPIDROBOT.startingLevel;

            // alert("inputArea val");
        	MG_GAME_STUPIDROBOT.wordField = $("#inputArea");
        	$("#inputArea").val("");
        	MG_GAME_STUPIDROBOT.inputlength = 0;
        	$("#inputArea").keypress(function(e){
        	 	var keyCode = e.keyCode || e.which;
        	 	var word=$("#inputArea").val();
        	 	// console.log("keypressed");

                if(keyCode === 13){

                	MG_GAME_STUPIDROBOT. beforeSubmit();
                    return false;
                }

        	 });

        	$("#inputArea").keydown(function(event){
        		// console.log("keydown");
        		if(event.which == 8) {
        			// console.log("go back");
        			if(MG_GAME_STUPIDROBOT.inputlength > 0) MG_GAME_STUPIDROBOT.inputlength--;
        			MG_GAME_STUPIDROBOT.setNewLevel();
        		}
        		else if( MG_GAME_STUPIDROBOT.isNumOrLetter(event.which) ) {
        			// console.log(MG_GAME_STUPIDROBOT.inputlength + " , " + MG_GAME_STUPIDROBOT.maxLevel);
        			if(MG_GAME_STUPIDROBOT.inputlength < MG_GAME_STUPIDROBOT.maxLevel){
	        			MG_GAME_STUPIDROBOT.inputlength++;
	        			MG_GAME_STUPIDROBOT.setNewLevel();
        			}
        		}
        	});

        	 $("#inputArea").bind("keyup change", function(event) {
                 var this_input = $(this),
                     str = $("#inputArea").val(),
                     input_length = parseInt(str.length, 10);

                 str = str.replace(/[^\w\s]|_/g, "");

                 // special chars are forbidden at kb level and the game also
					// complains
                 // if the user inputs it.
                 // however, just to be safe, strip the special chars if
					// still present
                 // forbid: `~!@#$%^&*()_=+{}|<>./?;:[]\",'
                 // allowed: -
                 str = str.replace(/[`~!@#$%^&*()_=+{}|<>./?;:\[\]\\",']/g, "");
                 // console.log(str);

                 if (event.keyCode != '13' && event.keyCode != '8' && event.keyCode != '46' && event.keyCode != '32') {
                     // num_sound = (input_length -1) % 8;
                     num_sound = (input_length -1) < 7 ? (input_length -1) : 7; // modified
																				// by
																				// Jack
																				// Guan
																				// 13/09/2013


                     if (input_length > MG_GAME_STUPIDROBOT.level  + 3) {
                    	 MG_GAME_STUPIDROBOT.playSound('fail_sound');

                         /*
							 * // this removes extra characters
							 * this_input.val(function(index, value){ return
							 * value.substr(0, value.length-1); });
							 */
                     } else {
                    	 // console.log('letter_' + num_sound);
                    	 MG_GAME_STUPIDROBOT.playSound('letter_' + num_sound);
                     }
                 }

                 return event.which != 32;
             });

        	// initiate server communication
            if(!MG_GAME_STUPIDROBOT.server_init){
            	// console.log("initiate with server: " +
				// MG_GAME_STUPIDROBOT.server_init);
            	MG_GAME_API.game_init(settings);
            	MG_GAME_STUPIDROBOT.server_init = true;
            }

        	// set original level
        	MG_GAME_STUPIDROBOT.timerTick();
        	MG_GAME_STUPIDROBOT.setLevel();

    		// set up animation
        	var canvas = document.getElementById("canvas");
        	animation = new lib.animation_gameplay("meow");

        	var stage = new createjs.Stage(canvas);
        	stage.addChild(animation);
        	stage.update();

        	createjs.Ticker.setFPS(24);
        	createjs.Ticker.addListener(stage);

        	var loadScreen=document.getElementById("loading");
        	loadScreen.parentNode.removeChild(loadScreen);

        	// ANIMATION ADDITION ~ play "scan" when animation launches. Use
			// this code to cause animation to scan new images
        	setTimeout(function(){
        	  MG_GAME_STUPIDROBOT.playSound('scan_sound');
        		animation.robot.gotoAndPlay("scan");
        	},1400);

        	// console.log("end of init");

        },

        setLevel: function (){
            // console.log("setlevel");
        	if(MG_GAME_STUPIDROBOT.level > MG_GAME_STUPIDROBOT.maxLevel){
        		MG_GAME_STUPIDROBOT.renderFinal();
        		return;
        	}
        	$("#inputArea").animate({width:MG_GAME_STUPIDROBOT.level * 0.67 + "em"});
        	$("#inputArea").attr("maxlength", MG_GAME_STUPIDROBOT.maxlevel);
        	$("#gameMessage").html("PLEASE INPUT WORD, HUMAN");

        	$("#inputFields span").eq(MG_GAME_STUPIDROBOT.level - MG_GAME_STUPIDROBOT.startingLevel).addClass("hilight");
        },

        isNumOrLetter: function(e){
        	return (e >= 0x30 && e <= 0x39)
        		|| (e >= 0x41 && e <= 0x5A)
        		|| (e >= 0x61 && e <= 0x7A);
        },

        setNewLevel: function (){
            // console.log("setlevel");
        	if(MG_GAME_STUPIDROBOT.inputlength < 4)
        		MG_GAME_STUPIDROBOT.level = 4;
        	else
        		MG_GAME_STUPIDROBOT.level = MG_GAME_STUPIDROBOT.inputlength;
        	$("#inputArea").animate({width:MG_GAME_STUPIDROBOT.level * 0.67 + "em"}, 10);
        	$("#inputArea").attr("maxlength", MG_GAME_STUPIDROBOT.maxLevel);
        	$("#gameMessage").html("PLEASE INPUT WORD, HUMAN");
        	$("#inputFields span").removeClass("hilight");
        	$("#inputFields span").eq(MG_GAME_STUPIDROBOT.level - MG_GAME_STUPIDROBOT.startingLevel).addClass("hilight");
        },

        flashMessage: function (message, color){
        	// console.log("flashMessage");
        	var savedMessage=$("#gameMessage").html();
        	$("#gameMessage").html(message);
        	$("#gameMessage").css("color", color);
        	$("#gameMessage").fadeOut(100);
        	$("#gameMessage").fadeIn(100);
        	$("#gameMessage").fadeOut(100);
        	$("#gameMessage").fadeIn(100);

        	setTimeout(function(){
        		$("#gameMessage").fadeOut(100);
        		$("#gameMessage").html(savedMessage);
        		$("#gameMessage").css("color", "black");
        		$("#gameMessage").fadeIn(100);
        	},1625);
        },

        timerTick: function (){
            // console.log("timerTick");
        	currentMinutes = Math.floor(MG_GAME_STUPIDROBOT.secs / 60);
            currentSeconds = MG_GAME_STUPIDROBOT.secs % 60;
            if(currentSeconds <= 9) currentSeconds = "0" + currentSeconds;
           	$("#timer").html(currentMinutes + ":" + currentSeconds);
           	// document.getElementById("timerText").innerHTML = currentMinutes +
			// ":" + currentSeconds; //Set the element id you need the time put
			// into.
            if(MG_GAME_STUPIDROBOT.secs <= 0 ){
            	MG_GAME_STUPIDROBOT.renderFinal();
            	return;
            }

            setTimeout('MG_GAME_STUPIDROBOT.timerTick()',1000);
            MG_GAME_STUPIDROBOT.secs--;

        },

        playSound: function (index) {
        	// MG_GAME_STUPIDROBOT.sound[index].loop = true;
        	MG_GAME_STUPIDROBOT.sound[index].play(MG_GAME_STUPIDROBOT.sounds[index]);
        },

        /*
		 * on callback for the submit button
		 */
        beforeSubmit:function () {
        	// console.log("onsubmit");
            var tags = $.trim(MG_GAME_STUPIDROBOT.wordField.val());
        	// evaluate for word too short
            // set false for testing turn handling in the sever side
        	// if(tags.length < MG_GAME_STUPIDROBOT.level){
            //console.log(MG_GAME_STUPIDROBOT.wordArray[tags.length] + " " + tags.length);
        	if(tags.length < 4){
        		console.log("too short");
        		// ANIMATION ADDITION ~ play "confused" animation for passing
        		animation.robot.gotoAndPlay("error");

        		 MG_GAME_STUPIDROBOT.playSound('fail_sound');

        		MG_GAME_STUPIDROBOT.flashMessage("Too short!", "red");
        	}
        	else if (/[`~!@#$%^&*()_=+{}|<>./?;:\[\]\\",']/g.test(tags)) {
        		MG_GAME_STUPIDROBOT.flashMessage("Symbols not allowed!", "red");
        		    animation.robot.gotoAndPlay("error");
                MG_GAME_STUPIDROBOT.playSound('fail_sound');
            }
            else if($.inArrayIn(tags, MG_GAME_STUPIDROBOT.words) !== -1 ){
            	animation.robot.gotoAndPlay("error");
            	MG_GAME_STUPIDROBOT.flashMessage("You already tried that!", "red");
                MG_GAME_STUPIDROBOT.playSound('fail_sound');
            }
            else if(MG_GAME_STUPIDROBOT.wordArray[tags.length - 4] != "!"){
            	animation.robot.gotoAndPlay("error");
            	MG_GAME_STUPIDROBOT.flashMessage("Try a different length!", "red");
                MG_GAME_STUPIDROBOT.playSound('fail_sound');
            }else{
                // ajax call to the nlp api
                $.ajax({
                    type: "GET",
                    // url: "http://localhost:8139/possible_wordcheck",
                    url: MG_STUPIDROBOT.nlp_api_url + "/possible_wordcheck",
                    timeout: 5000,
                    data: { input: tags },
                    dataType: "json",
                    error: function( o ) {
                        // console.log(o);
                        console.log('error with nlp api, so proceeding with the game');
                        console.log(MG_STUPIDROBOT.nlp_api_url);
                        MG_GAME_STUPIDROBOT.onsubmit(tags);
                    }
                }).done(function( o ) {
                    // console.log(o);
                    var is_word = o.response;
                    if (!is_word) {
                        // console.log(tags+' is not a word.');
                    	animation.robot.gotoAndPlay("error");
                    	MG_GAME_STUPIDROBOT.flashMessage("That's not a word...", "red");
                    	MG_GAME_STUPIDROBOT.playSound('fail_sound');
                    }
                    else {
                        // console.log(tags+' could be a word.');
                        // console.log('nlp api call done, result not false so
						// proceeding with game');
                    	MG_GAME_STUPIDROBOT.onsubmit(tags);
                    }
                });
            }
            return false;
        },

        onsubmit:function (tags) {
        	MG_GAME_STUPIDROBOT.words.push(tags);
            // send ajax call as POST request to validate a turn
            MG_API.ajaxCall('/games/play/gid/' + MG_GAME_API.settings.gid, function (response) {
                if (MG_API.checkResponse(response)) {
                	MG_GAME_STUPIDROBOT.onresponse(response);
                }
                return false;
            }, {
                type:'post',
                data:{ // this is the data needed for the turn
                    turn: 1,
                    played_game_id: MG_GAME_STUPIDROBOT.game.played_game_id,
                    'submissions':[
                        {
                            media_id: MG_GAME_STUPIDROBOT.media.media_id,
                            pass: false,
                            tags: tags.toLowerCase()
                        }
                    ]
                }
            });
        },

        /*
		 * evaluate each response from /api/games/play calls (POST or GET)
		 */
        onresponse:function (response) {
        	// console.log("onresponse");
            MG_GAME_API.curtain.hide();

            if ($.trim(MG_GAME_STUPIDROBOT.game.more_info_url) != "")
            	MG_GAME_STUPIDROBOT.more_info = {url:MG_GAME_STUPIDROBOT.game.more_info_url, name:MG_GAME_STUPIDROBOT.game.name};

            MG_GAME_STUPIDROBOT.media = response.turn.medias[0]

            var accepted = {
                level:1,
                tag:""
            };

            var turn = response.turn;
            for (i_img in turn.tags.user) {
                var media = turn.tags.user[i_img];
                for (i_tag in media) {
                    // PASSING: If we find the passing tag, we just skip it.
                    if (i_tag == MG_GAME_STUPIDROBOT.passStringFiltered) {
                        continue;
                    }
                    var tag = media[i_tag];

                    if (turn.medias[0].tag_accepted) {
                        accepted.level = turn.medias[0].level;
                        accepted.tag = tag;

                        MG_GAME_STUPIDROBOT.levels.push(accepted);
                        // console.log(MG_GAME_STUPIDROBOT.level + " and " +
						// tag.tag);

                        MG_GAME_STUPIDROBOT.wordArray[MG_GAME_STUPIDROBOT.level - 4] = tag.tag;
                		$("#inputFields span").eq(MG_GAME_STUPIDROBOT.level-MG_GAME_STUPIDROBOT.startingLevel).addClass("completed");
                		MG_GAME_STUPIDROBOT.level++;
                		MG_GAME_STUPIDROBOT.setLevel();
                		MG_GAME_STUPIDROBOT.wordsAccepted++;
                		if(MG_GAME_STUPIDROBOT.wordsAccepted > MG_GAME_STUPIDROBOT.maxLevel){
                			MG_GAME_STUPIDROBOT.renderFinal();
                			return;
                		}
                    	$("#inputArea").val("");
                    	MG_GAME_STUPIDROBOT.inputlength = 0;
                    	MG_GAME_STUPIDROBOT.setNewLevel();

//                     	console.log("correct");

                    	MG_GAME_STUPIDROBOT.flashMessage("STUPID ROBOT KNOWS THAT NOW!", "green");
                    	animation.robot.gotoAndPlay("correctAnswer");
                    	MG_GAME_STUPIDROBOT.playSound('next_level');

                    } else {
                    		// no match -- feedback
                    	// console.log("not accepted");
                    	MG_GAME_STUPIDROBOT.flashMessage("DOES NOT COMPUTE: TRY AGAIN?", "red");
                		animation.robot.gotoAndPlay("incorrectAnswer");
                		MG_GAME_STUPIDROBOT.playSound('confused');
                    }
                }
            }

            if (turn.licences.length) {
                for (licence in turn.licences) { // licences
                    var found = false;
                    for (l_index in MG_GAME_STUPIDROBOT.licence_info) {
                        if (MG_GAME_STUPIDROBOT.licence_info[l_index].id == turn.licences[licence].id) {
                            found = true;
                            break;
                        }
                    }

                    if (!found)
                    	MG_GAME_STUPIDROBOT.licence_info.push(turn.licences[licence]);
                }
            }
            MG_GAME_STUPIDROBOT.renderTurn(response);
        },

        /*
		 * display games turn
		 */
        renderTurn: function (response) {
        	// console.log('in renderTurn');
        	// console.log("image url: " + response.turn.medias[0].full_size);


                var turn_info = {
                    url: response.turn.medias[0].full_size,
                    url_full_size: response.turn.medias[0].full_size,
                    licence_info: MG_GAME_API.parseLicenceInfo(response.turn.licences)
                };

                $("#imageContainer").find("img").attr("src", turn_info.url);

            MG_GAME_STUPIDROBOT.wordField.focus();
        },

        ongameinit:function (response) {
        	// console.log('ongameinit to with response, about to go in
			// onresponse');
        	MG_GAME_STUPIDROBOT.onresponse(response);
        },

        scrollIn:function () {
        	// console.log("scrollIn");
        	// console.log("MG_GAME_STUPIDROBOT.scrollIn");
        	MG_GAME_STUPIDROBOT.p=MG_GAME_STUPIDROBOT.wordSpaces[MG_GAME_STUPIDROBOT.activeLine];
        	MG_GAME_STUPIDROBOT.i++;
        	// console.log("activeLine: " + MG_GAME_STUPIDROBOT.activeLine);
    		if(MG_GAME_STUPIDROBOT.activeLine >= 10){
    			// scroll is finished

    			createjs.Ticker.setFPS(24);
    			createjs.Ticker.addListener(MG_GAME_STUPIDROBOT.scorestage);
    			return;
			}
        	if(MG_GAME_STUPIDROBOT.i > MG_GAME_STUPIDROBOT.wordArray[MG_GAME_STUPIDROBOT.activeLine].length) {
        		MG_GAME_STUPIDROBOT.wordSpaces[MG_GAME_STUPIDROBOT.activeLine].innerHTML = MG_GAME_STUPIDROBOT.a;
        		MG_GAME_STUPIDROBOT.activeLine++;
        		MG_GAME_STUPIDROBOT.i=0;

        		setTimeout("MG_GAME_STUPIDROBOT.scrollIn()",25);
        		return;
        	 }
        	MG_GAME_STUPIDROBOT.a = MG_GAME_STUPIDROBOT.wordArray[MG_GAME_STUPIDROBOT.activeLine].substring(0,MG_GAME_STUPIDROBOT.i);
        	if(MG_GAME_STUPIDROBOT.a=="!"){
        		MG_GAME_STUPIDROBOT.i=0;
        		setTimeout("MG_GAME_STUPIDROBOT.scrollIn()",25);
        		MG_GAME_STUPIDROBOT.p.style.backgroundColor = "black";
        		MG_GAME_STUPIDROBOT.activeLine++;
            	// console.log(MG_GAME_STUPIDROBOT.activeLine + " and2 " +
				// MG_GAME_STUPIDROBOT.wordArray.length);

        		return;
        	}


        	MG_GAME_STUPIDROBOT.p.innerHTML = MG_GAME_STUPIDROBOT.a+"_";

        	setTimeout("MG_GAME_STUPIDROBOT.scrollIn()",25);
        },

        renderFinal:function () {
        	if(MG_GAME_STUPIDROBOT.isRenderFinaled == true)
        		return;
        	else
        		MG_GAME_STUPIDROBOT.isRenderFinaled = true;
        	// console.log("renderFinal");
        	// TO ZARA: line 404~407, this is point when I about to display the
			// score page
        	// I simply make game page empty by using $("#game").html(""), or
        	// you can store the html in a vairable before you erase them.
        	$("#game").html("");
        	$("#game").hide();
        	$("#score").show();
        	$("#score").html(MG_GAME_STUPIDROBOT.scorehtml);
			// passed levels should be added as "!"

        	MG_GAME_API.releaseOnBeforeUnload();
        	$("#reboot").click(function(){
        		location.reload();
        	});

			// determine level by length of word array, minus passes
			for(var i=0; i<MG_GAME_STUPIDROBOT.wordArray.length; i++){
				if(MG_GAME_STUPIDROBOT.wordArray[i] != "!"){
					MG_GAME_STUPIDROBOT.scorelevel++;
				}
			}
			// set up text message
			var message=document.getElementById("gameMessage");
			var messageString;
			switch(MG_GAME_STUPIDROBOT.scorelevel){
				case 0:
				messageString="STUPID ROBOT NEEDS MORE HELP. TRY AGAIN?";
				break;
				case 1:
				messageString="STUPID ROBOT AN ITTY BITTY BIT SMARTER.";
				MG_GAME_STUPIDROBOT.playSound('score_1');
				break;
				case 2:
				messageString="STUPID ROBOT A TINY BIT SMARTER.";
				MG_GAME_STUPIDROBOT.playSound('score_2');
				break;
				case 3:
				messageString="STUPID ROBOT SLIGHTLY SMARTER.";
				MG_GAME_STUPIDROBOT.playSound('score_3');
				break;
				case 4:
				messageString="STUPID ROBOT LEVELING UP!";
				MG_GAME_STUPIDROBOT.playSound('score_4');
				break;
				case 5:
				messageString="STUPID ROBOT SEEKS MORE KNOWLEDGE.";
				MG_GAME_STUPIDROBOT.playSound('score_5');
				break;
				case 6:
				messageString="BRING IT ON HUMAN.";
				MG_GAME_STUPIDROBOT.playSound('score_6');
				break;
				case 7:
				messageString="STUPID ROBOT READY TO TAKE ON DEEP BLUE.";
				break;
				case 8:
				messageString="THE NAME IS SMARTY ROBOT.";
				break;
				case 9:
				messageString="ALL YOUR TAGS ARE BELONG TO STUPID ROBOT.";
				break;
				default:
				messageString="STUPID ROBOT AN ITTY BITTY BIT SMARTER.";
			}

			// $("#gameMessage2").html("YOU TAUGHT STUPID ROBOT
			// "+MG_GAME_STUPIDROBOT.scorelevel+" WORDS!<br>"+messageString);
			message.innerHTML="YOU TAUGHT STUPID ROBOT "+MG_GAME_STUPIDROBOT.scorelevel+" WORDS!<br>"+messageString;

			var canvas = document.getElementById("canvas");
			var exportRoot = new lib.animation_score(MG_GAME_STUPIDROBOT.scorelevel);

			// console.log("MG_GAME_STUPIDROBOT.scorelevel: " +
			// MG_GAME_STUPIDROBOT.scorelevel);

			MG_GAME_STUPIDROBOT.scorestage = new createjs.Stage(canvas);
			MG_GAME_STUPIDROBOT.scorestage.addChild(exportRoot);
			MG_GAME_STUPIDROBOT.scorestage.update();

			// set up scroller
			var wordspaceCollection=document.getElementsByClassName("underlinedText");
			MG_GAME_STUPIDROBOT.wordSpaces = Array.prototype.slice.call( wordspaceCollection );
			MG_GAME_STUPIDROBOT.scrollIn();
        },

    });
}(jQuery);


/* For the new side panel */
$('#sidepanel #tab').toggle(function () {
    $(this).attr("class", "tab_open");
    $('#sidepanel').animate({'right':0});
}, function () {
    // Question: Why does '-290' work, and '-300' push the arrow too
    // far right?
    $(this).attr("class", "tab_closed");
    $('#sidepanel').animate({'right':-290});
});

function onResize () {
    var max_height,
        gamearea = $("#gamearea");

    // $("#content header div").css("left", 0);
// $("#input_area input").css("width", $(window).width()-195 );
    // $("#input_area input").css('cssText', "width: " + $(window).width()-150 +
	// "px !important, border: 1px solid pink !important" );
   // $("#content").css("min-height", device_ratio*($(window).height() -
	// ($("#header").outerHeight() + $("#content footer").outerHeight())));

    // $("#container").css("height", device_ratio*($(window).height() - 210));

        max_height = $(window).height() - 34 - $("#content header").outerHeight() - $("#content footer").outerHeight() - parseInt(gamearea.css('padding-top'), 10) - parseInt(gamearea.css('padding-bottom'), 10) - 30;
        if (max_height < 200) max_height = 200;
        $("#image_to_tag").css({'max-height': max_height, 'max-width': $(window).width() - 35});
        $("#gamearea").css("height", max_height);
/*
 * } else { if ($("body").hasClass("touch_device")) { max_height =
 * $(window).height() - $("#header").outerHeight() - $("#content
 * header").outerHeight() - $("#content footer").outerHeight() -
 * parseInt(gamearea.css('padding-top'), 10) -
 * parseInt(gamearea.css('padding-bottom'), 10); } else { max_height =
 * $(window).height() - $("#content header").outerHeight() - $("#content
 * footer").outerHeight() - parseInt(gamearea.css('padding-top'), 10) -
 * parseInt(gamearea.css('padding-bottom'), 10); } if (max_height < 200)
 * max_height = 200; $("#image_to_tag").css({'max-height': max_height,
 * 'max-width': $(window).width() - 45}); $("#gamearea").css("height",
 * max_height); }
 */

    // $("#content header div").centerHorizontal();
    $("#content header div").css({"width": parseInt($("#input_area").css("width"), 10) + parseInt($("#countdown").outerWidth(), 10) + 30});
    // $("#content header div input").css("border", '1px solid pink');
    $("nav .mm-inner").css('width', $(window).width());
}

(function($){
    $.extend({
        // Case insensative inArray
        inArrayIn: function(elem, arr, i){
            // not looking for a string anyways, use default method
            if (typeof elem !== 'string'){
                return $.inArrayIn.apply(this, arguments);
            }
            // confirm array is populated
            if (arr){
                var len = arr.length;
                i = i ? (i < 0 ? Math.max(0, len + i) : i) : 0;
                elem = elem.toLowerCase();
                for (; i < len; i++){
                    if (i in arr && arr[i].toLowerCase() == elem){
                        return i;
                    }
                }
            }
            // stick with inArray/indexOf and return -1 on no match
            return -1;
        }
    })
})(jQuery);
