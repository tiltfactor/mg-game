MG_GAME_STUPIDROBOT = function ($) {
    return $.extend(MG_GAME_API, {
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
        
        // the following variable is newly added in stupidrobot:
        startingLevel: 4,
        level: null,
        maxLevel: 13,
        letterWidthInEms: 0.67,
        speed: 200,
        secs: 120,
        fields: null,
        animation: null,

        init: function (options) {
        	console.log("init");
        	//pass function
        	//alert("inputFields click");
        	console.log('do we get in ongameinit?');
            var settings = $.extend(options, {
                ongameinit: MG_GAME_STUPIDROBOT.ongameinit
            });
            
        	
        	$("#inputFields .button").click(function(){
        		$("#inputFields span").eq(MG_GAME_STUPIDROBOT.level - MG_GAME_STUPIDROBOT.startingLevel).addClass("passed");
        		MG_GAME_STUPIDROBOT.level++;
        		MG_GAME_STUPIDROBOT.setLevel();
        		}
        	);
        	
        	MG_GAME_STUPIDROBOT.level = MG_GAME_STUPIDROBOT.startingLevel;

            //alert("inputArea val");
        	MG_GAME_STUPIDROBOT.wordField = $("#inputArea");
        	$("#inputArea").val("");
        	 $("#inputArea").keypress(function(e){
        	 	var keyCode = e.keyCode || e.which;
                
                if(keyCode === 13){
                	MG_GAME_STUPIDROBOT.evalWord();
                }         
        	 });
        //set original level
        	MG_GAME_STUPIDROBOT.timerTick();
        	MG_GAME_STUPIDROBOT.setLevel();
        	
        		//set up animation
        		
        	//alert("animation");
        	//console.log("animation");
        	var canvas = document.getElementById("canvas");
        	animation = new lib.animation_gameplay("meow");

        	var stage = new createjs.Stage(canvas);
        	stage.addChild(animation);
        	stage.update();
        	
        	createjs.Ticker.setFPS(24);
        	createjs.Ticker.addListener(stage);
        	
    		var loadScreen=document.getElementById("loading");
        	loadScreen.parentNode.removeChild(loadScreen);	
        	
        	MG_GAME_API.game_init(settings);

        	console.log("end of init");
        	
        },
        
        roundOver:function () {
        	alert("all done");
        },
        
        setLevel: function (){
            console.log("setlevel");
        	if(MG_GAME_STUPIDROBOT.level > MG_GAME_STUPIDROBOT.maxLevel){
        		MG_GAME_STUPIDROBOT.roundOver();
        		return;
        	}
        	//console.log("MG_GAME_STUPIDROBOT.level in setLevel: " + MG_GAME_STUPIDROBOT.level * 0.67 + "em");
        	$("#inputArea").animate({width:MG_GAME_STUPIDROBOT.level * 0.67 + "em"});
        	$("#inputArea").attr("maxlength", MG_GAME_STUPIDROBOT.level);
        	$("#gameMessage").html("INPUT A "+ MG_GAME_STUPIDROBOT.level+" LETTER WORD");

        	$("#inputFields span").eq(MG_GAME_STUPIDROBOT.level - MG_GAME_STUPIDROBOT.startingLevel).addClass("hilight");

        },
        
        flashMessage: function (message, color){
        	console.log("flashMessage");
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
        	},1500);
        },
        
        evalWord: function (){
            console.log("evalWord");
        	var word=$("#inputArea").val();
        	$("#inputArea").val("");
        	// evaluate for word too short
        	if(word.length < MG_GAME_STUPIDROBOT.level){
        		console.log("too short");
        		return;
        	}
        	
        	// randomly assigns 50% chance of correct. Replace this with
			// evaluation for word match
        	else if(Math.round(Math.random()*100) % 2){
        		MG_GAME_STUPIDROBOT.flashMessage("NGR ERROR: TRY AGAIN", "red");
        		animation.robot.gotoAndPlay("incorrectAnswer");
        	}
        	else{
        		$("#inputFields span").eq(MG_GAME_STUPIDROBOT.level-MG_GAME_STUPIDROBOT.startingLevel).addClass("completed");
        		MG_GAME_STUPIDROBOT.level++;
        		MG_GAME_STUPIDROBOT.setLevel();
        	// set MG_GAME_STUPIDROBOT.level BEFORE flash message
        		MG_GAME_STUPIDROBOT.flashMessage("WORD ACCEPTED!", "green");
        		animation.robot.gotoAndPlay("correctAnswer");
        	}
        },
        
        timerTick: function (){
            console.log("timerTick");
        	currentMinutes = Math.floor(MG_GAME_STUPIDROBOT.secs / 60);
            currentSeconds = MG_GAME_STUPIDROBOT.secs % 60;
            if(currentSeconds <= 9) currentSeconds = "0" + currentSeconds;
           	$("#timer").html(currentMinutes + ":" + currentSeconds);
           	// document.getElementById("timerText").innerHTML = currentMinutes +
			// ":" + currentSeconds; //Set the element id you need the time put
			// into.
            if(MG_GAME_STUPIDROBOT.secs <= 0 ){
            	MG_GAME_STUPIDROBOT.roundOver();
            	return;
            }
            
            setTimeout('MG_GAME_STUPIDROBOT.timerTick()',1000);
            MG_GAME_STUPIDROBOT.secs--;

        },
        
        /*
		 * on callback for the submit button
		 */
        onsubmit:function () {
        	console.log("onsubmit");
            if (!MG_GAME_STUPIDROBOT.busy) {
                var tags = $.trim(MG_GAME_STUPIDROBOT.wordField.val());
                if (tags == "") {
                    $().toastmessage("showToast", {
                        text:"<p>Oops! Type something!</p>",
                        position:"tops-center",
                        type:"notice",
                        background: "#F1F1F1"
                    });
                    // MG_GAME_PYRAMID.playSound('try_again');

                } else if (tags.length < (MG_GAME_STUPIDROBOT.level + MG_GAME_STUPIDROBOT.level_step)) {
                    $().toastmessage("showToast", {
                        text: "not enough letters!",// "That wasn't a " +
													// (MG_GAME_PYRAMID.level +
													// MG_GAME_PYRAMID.level_step)
													// + " letters word!",
                        position:"tops-center",
                        type:"notice",
                        background: "#F1F1F1"
                    });
                    // MG_GAME_PYRAMID.playSound('try_again');
                }
                else if (tags.length > (MG_GAME_STUPIDROBOT.level + MG_GAME_STUPIDROBOT.level_step)) {
                    $().toastmessage("showToast", {
                        text:"too many letters!",
                        position:"tops-center",
                        type:"notice",
                        background: "#F1F1F1"
                    });
                    // MG_GAME_PYRAMID.playSound('try_again');
                }
                // check if these special characters are present, and if
				// present, complain
                // forbid: `~!@#$%^&*()_=+{}|<>./?;:[]\",'
                // TODO: Turn this into a function maybe..
                else if (/[`~!@#$%^&*()_=+{}|<>./?;:\[\]\\",']/g.test(tags)) {
                    $().toastmessage("showToast", {
                        text:"special character not allowed!",
                        position:"tops-center",
                        type:"notice",
                        background: "#F1F1F1"
                    });
                    // MG_GAME_PYRAMID.playSound('try_again');
                }
                else if($.inArrayIn(tags, MG_GAME_STUPIDROBOT.words) !== -1){
                    $().toastmessage("showToast", {
                        text:"already tried that!",
                        position:"tops-center",
                        type:"notice",
                        background: "#F1F1F1"
                    });
                    // MG_GAME_PYRAMID.playSound('try_again');
                } else {
                	MG_GAME_STUPIDROBOT.words.push(tags);
                    // text entered
                    // MG_GAME_API.curtain.show();
                    // MG_GAME_PYRAMID.busy = true;

                    // send ajax call as POST request to validate a turn
                    MG_API.ajaxCall('/games/play/gid/' + MG_GAME_API.settings.gid, function (response) {
                        if (MG_API.checkResponse(response)) {
                        	MG_GAME_STUPIDROBOT.wordField.val("");
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
                }
            }
            return false;
        },
        
        /*
		 * evaluate each response from /api/games/play calls (POST or GET)
		 */
        onresponse:function (response) {
        	console.log("onresponse");
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
/*
 * var myArray = ['Our test sample agrees!', "You've guessed it!", 'Your word
 * matched!']; $().toastmessage("showToast", { text:
 * myArray[Math.floor(Math.random() * myArray.length)], position:"tops-center",
 * type:"notice" });
 */
                        MG_GAME_STUPIDROBOT.levels.push(accepted);
                        MG_GAME_STUPIDROBOT.nextlevel(false);
                    } else {
                    		// no match -- feedback
                        var myArray = ['No match. Try again?', "That's not what our experts said!", "Sorry, our experts don't agree!"];
                        $().toastmessage("showToast", {
                            text: myArray[Math.floor(Math.random() * myArray.length)],
                            position:"tops-center",
                            type:"notice",
                            background: "red"
                        });
                        // MG_GAME_PYRAMID.playSound('fail_sound');
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
        	console.log('in renderTurn');
        	console.log("image url: " + response.turn.medias[0].full_size);


                var turn_info = {
                    url: response.turn.medias[0].full_size,
                    url_full_size: response.turn.medias[0].full_size,
                    licence_info: MG_GAME_API.parseLicenceInfo(response.turn.licences)
                };

                
                $("#imageContainer").find("img").attr("src", turn_info.url);

            MG_GAME_STUPIDROBOT.wordField.focus();
        },
        
        ongameinit:function (response) {
        	console.log('ongameinit to with response, about to go in onresponse');
        	MG_GAME_STUPIDROBOT.onresponse(response);
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
