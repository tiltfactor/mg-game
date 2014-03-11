MG_GAME_STUPIDROBOT = function ($) {
    return $.extend(MG_GAME_API, {
        init_options: null,
        server_init: false,
        loadgame: "",
        fancyboxes: "",
        main_menu_bar: null,

        // the following is copied from pyramid tag
        wordField: null,
        playOnceMoveOnFinalScreenWaitingTime: 15000, // milliseconds
        submitButton: null,
        media: null,
        licence_info: [],
        more_info: null,
        levels: [],
        // level:1,
        pass_penalty: 0, // in seconds
        level_step: 3,
        words: [],
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
        scorehtml: "",
        wordsAccepted: 0,
        inputlength: 0,
        shift_detected: false,
        mediaGet: false,
        timerInit: false,
        remoteProcessing: false,

        // new added for scoring
        isRenderFinaled: false,
        wordSpaces: null,
        wordArray: ["!", "!", "!", "!", "!", "!", "!", "!", "!", "!"],
        //wordArray:["!","word","word","word","word","!","!","!","!","!",],
        a: "",
        p: null,
        i: 0,
        activeLine: 0,
        scorestage: null,
        scorelevel: 0,

        // new added for splash page
        idx_paragraphArray: null,
        idx_introText: ["Meet Stupid Robot.",
            "Stupid Robot looks at everything but understands nothing.",
            "Can you help?",
            "Tell Stupid Robot what is in the image.",
            "Stupid Robot has enough memory for 1 word of each different length.",
            "Can you teach Stupid Robot 10 words about the image?",
            "Sometimes Stupid Robot doesn't understand a word at all.",
            "When this happens, Stupid Robot learns that word for next time.",
            "Try a different word of that length until Stupid Robot understands.",
            "With your help, Stupid Robot will learn and evolve!"],
        idx_a: "",
        idx_p: null,
        idx_i: 0,
        idx_activeLine: 0,
        introTextSpeedUp: 1,


        idx_scrollIn: function () {
            MG_GAME_STUPIDROBOT.idx_p = MG_GAME_STUPIDROBOT.idx_paragraphArray[MG_GAME_STUPIDROBOT.idx_activeLine];
            MG_GAME_STUPIDROBOT.idx_i++;
            if (MG_GAME_STUPIDROBOT.idx_i > MG_GAME_STUPIDROBOT.idx_introText[MG_GAME_STUPIDROBOT.idx_activeLine].length) {

                MG_GAME_STUPIDROBOT.idx_paragraphArray[MG_GAME_STUPIDROBOT.idx_activeLine].innerHTML = MG_GAME_STUPIDROBOT.idx_a;
                MG_GAME_STUPIDROBOT.idx_activeLine++;
                MG_GAME_STUPIDROBOT.idx_i = 0;

                if (MG_GAME_STUPIDROBOT.idx_activeLine >= MG_GAME_STUPIDROBOT.idx_introText.length) {
                    if ($("#bootButton").is(':hidden')) {
                        $("#bootButton").show();
                    }
                    return;
                }

                setTimeout("MG_GAME_STUPIDROBOT.idx_scrollIn()", 1400 / MG_GAME_STUPIDROBOT.introTextSpeedUp / MG_GAME_STUPIDROBOT.introTextSpeedUp);
                return;
            }

            MG_GAME_STUPIDROBOT.idx_a = MG_GAME_STUPIDROBOT.idx_introText[MG_GAME_STUPIDROBOT.idx_activeLine].substring(0, MG_GAME_STUPIDROBOT.idx_i);
            MG_GAME_STUPIDROBOT.idx_p.innerHTML = MG_GAME_STUPIDROBOT.idx_a + "_";
            setTimeout("MG_GAME_STUPIDROBOT.idx_scrollIn()", 20 / MG_GAME_STUPIDROBOT.introTextSpeedUp);
        },


        idx_init: function (options) {
            // the following three lines is for merging
            MG_GAME_STUPIDROBOT.loadgame = $("#loadgame").html();
            $("#loadgame").html("");
            $("#loadgame").hide();
            MG_GAME_STUPIDROBOT.fancyboxes = $("[id^='fancybox']")

            MG_GAME_STUPIDROBOT.main_menu_bar = $("#mainmenu_save").html();

            $(".manifest").hide();
            canvas = document.getElementById("canvas");
            canvas.width = window.innerWidth;
            window.onresize = function () {
                canvas.width = window.innerWidth;
            };
            images = images || {};
            var manifest = [
                {src: $(".manifest").find('img').eq(0).attr('src'), id: "Bitmap3"},
                {src: $(".manifest").find('img').eq(1).attr('src'), id: "Bitmap7"},
                {src: $(".manifest").find('img').eq(2).attr('src'), id: "Bitmap5"},
                {src: $(".manifest").find('img').eq(3).attr('src'), id: "Bitmap6"},
                {src: $(".manifest").find('img').eq(4).attr('src'), id: "FlashAICB"},
                {src: $(".manifest").find('img').eq(5).attr('src'), id: "tree"}
            ];
            var loader = new createjs.LoadQueue(false);
            loader.addEventListener("fileload", MG_GAME_STUPIDROBOT.idx_handleFileLoad);
            loader.addEventListener("complete", MG_GAME_STUPIDROBOT.idx_handleComplete);
            loader.loadManifest(manifest);

            // set up scroller
            var paragraphCollection = document.getElementsByClassName("scrollText");
            MG_GAME_STUPIDROBOT.idx_paragraphArray = Array.prototype.slice.call(paragraphCollection);
            MG_GAME_STUPIDROBOT.idx_paragraphArray.push(document.getElementById("lastScrollText"));

            // fix the loop sound problem after merging them together
            // 1 is because there is only one loop audio in background
            $(".audio_on").hide();
            $("#button-loop-1").click(function () {
                $(".audio_on").toggle();
                $(".audio_off").toggle();
            });

            // boot game
            $("#bootButton").click(function () {
                // this several code is for violent merging
                $("#welcomepage").remove();
//                $("#header").remove();
                $("body").attr('id', 'gameContent');
                $("body").removeClass("splashContent");
                $("body").addClass("gameContent");
                $("body").append(MG_GAME_STUPIDROBOT.loadgame);
//                $("body").append(MG_GAME_STUPIDROBOT.fancyboxes);
                MG_GAME_STUPIDROBOT.init_options = options;
                MG_GAME_STUPIDROBOT.init(options);
                //MG_GAME_STUPIDROBOT.init(options);
            });
        },


        idx_handleFileLoad: function (evt) {
            if (evt.item.type == "image") {
                images[evt.item.id] = evt.result;
            }
        },

        idx_handleComplete: function () {
            // console.log("complete");
            var loadScreen = document.getElementById("loading");
            loadScreen.parentNode.removeChild(loadScreen);


            exportRoot = new lib.animation_intro();

            stage = new createjs.Stage(canvas);
            stage.addChild(exportRoot);
            stage.update();

            createjs.Ticker.setFPS(24);
            createjs.Ticker.addEventListener("tick", stage);

            setTimeout("MG_GAME_STUPIDROBOT.idx_scrollIn()", 2000);

            $("#idx_skipanimate").click(function () {
                MG_GAME_STUPIDROBOT.introTextSpeedUp = 1000;
                MG_GAME_STUPIDROBOT.idx_scrollIn();
                $("#bootButton").show();
            });

        },

        init: function (options, noTicker) {
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

            //$("body").prepend(MG_GAME_STUPIDROBOT.main_menu_bar);

            var game_assets_uri = $("#game_assets_uri").val();
            // console.log("jackjackjack" + game_assets_uri);

            // initiate server communication,
            // be carefule of the multi-rounds
            if (!MG_GAME_STUPIDROBOT.server_init) {
                // console.log("initiate with server: " +
                // MG_GAME_STUPIDROBOT.server_init);
                var settings = $.extend(options, {
                    ongameinit: MG_GAME_STUPIDROBOT.ongameinit
                });
                MG_GAME_API.game_init(settings);
                MG_GAME_STUPIDROBOT.server_init = true;
            } else {
                // send ajax call as POST request to validate a turn
                //console.log('before: ' + MG_GAME_STUPIDROBOT.media.media_id);
                MG_API.ajaxCall('/games/play/gid/' + MG_GAME_API.settings.gid, function (response) {
                    if (MG_API.checkResponse(response)) {
                        //console.log('after: ' + MG_GAME_STUPIDROBOT.media.media_id);
                        MG_GAME_STUPIDROBOT.onresponse(response);
                    }
                    return false;
                }, {
                    type: 'post',
                    data: { // this is the data needed for the turn
                        turn: 1,
                        played_game_id: MG_GAME_STUPIDROBOT.game.played_game_id,
                        'submissions': [
                            {
                                media_id: MG_GAME_STUPIDROBOT.media.media_id,
                                tags: "pass",
                                pass: true,
                                reboot: 1
                            }
                        ]
                    }
                });
            }

            MG_GAME_STUPIDROBOT.sounds = {
                fail_sound: game_assets_uri + 'audio/sound_fail.mp3',
                scan_sound: game_assets_uri + 'audio/scan2.mp3',
                letter_0: game_assets_uri + 'audio/sound0.mp3',
                letter_1: game_assets_uri + 'audio/sound1.mp3',
                letter_2: game_assets_uri + 'audio/sound2.mp3',
                letter_3: game_assets_uri + 'audio/sound3.mp3',
                letter_4: game_assets_uri + 'audio/sound4.mp3',
                letter_5: game_assets_uri + 'audio/sound5.mp3',
                letter_6: game_assets_uri + 'audio/sound6.mp3',
                letter_7: game_assets_uri + 'audio/sound7.mp3',
                next_level: game_assets_uri + 'audio/right.mp3',
                confused: game_assets_uri + 'audio/confused2.mp3',
                try_again: game_assets_uri + 'audio/tryagain.mp3',
                score_1: game_assets_uri + 'audio/score_1.mp3',
                score_2: game_assets_uri + 'audio/score_2.mp3',
                score_3: game_assets_uri + 'audio/score_3.mp3',
                score_4: game_assets_uri + 'audio/score_4.mp3',
                score_5: game_assets_uri + 'audio/score_5.mp3'

            };
            $.each(MG_GAME_STUPIDROBOT.sounds, function (index, source) {
                MG_GAME_STUPIDROBOT.sound[index] = new Sound(source);
            });

            $("#pass").click(function () {
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
                        type: 'post',
                        data: { // this is the data needed for the turn
                            turn: 1,
                            played_game_id: MG_GAME_STUPIDROBOT.game.played_game_id,
                            'submissions': [
                                {
                                    media_id: MG_GAME_STUPIDROBOT.media.media_id,
                                    tags: "pass",
                                    pass: true,
                                    reboot: 0
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
            $(".audio_on").hide();
            $("#button-loop-1").click(function () {
                audio.play(1);
                $(".audio_on").toggle();
                $(".audio_off").toggle();
            });

            // done button for finishing the game immediately
            $("#gamedone").click(function () {
                MG_GAME_STUPIDROBOT.secs = 0;
            });

            // set arbitrary level
            $("#pass").hide();

            MG_GAME_STUPIDROBOT.level = MG_GAME_STUPIDROBOT.startingLevel;

            // alert("inputArea val");
            MG_GAME_STUPIDROBOT.wordField = $("#inputArea");
            $("#inputArea").val("");
            MG_GAME_STUPIDROBOT.inputlength = 0;
            $("#inputArea").keypress(function (e) {
                var keyCode = e.keyCode || e.which;
                var word = $("#inputArea").val();
                //console.log("keyCode: " + keyCode);

                if (keyCode === 13) {
                    MG_GAME_STUPIDROBOT.beforeSubmit();
                }

            });

            // release shift key
            $("#inputArea").keyup(function (event) {
                if (event.which == 16)
                    MG_GAME_STUPIDROBOT.shift_detected = false;
            });

            $("#inputArea").keydown(function (event) {
                //console.log(event.which);
                if (event.which == 16) {
                    // keep track of shift key
                    MG_GAME_STUPIDROBOT.shift_detected = true;
                } else if (event.which == 8) {
                    //console.log("go back");
                    if (MG_GAME_STUPIDROBOT.inputlength > 0)
                        MG_GAME_STUPIDROBOT.inputlength--;
                    MG_GAME_STUPIDROBOT.setNewLevel();
                }
                else if (MG_GAME_STUPIDROBOT.isLetter(event.which)) {
                    //console.log(MG_GAME_STUPIDROBOT.inputlength + " , " + MG_GAME_STUPIDROBOT.maxLevel);
                    if (MG_GAME_STUPIDROBOT.inputlength < MG_GAME_STUPIDROBOT.maxLevel) {
                        MG_GAME_STUPIDROBOT.inputlength++;
                        MG_GAME_STUPIDROBOT.setNewLevel();
                    }
                }
            });

            $(":input").not(".input").bind("keydown", function (event) {
                return ((event.which >= 97 && event.which <= 122) || (event.which >= 65 && event.which <= 90) || event.which === 8 || event.which === 13);
            });

            $("#inputArea").bind("keyup change", function (event) {
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
                /*
                 if (/[`~!@#$%^&*()_=+{}|<>./?;:\[\]\\",']/g.test(str)) {
                 MG_GAME_STUPIDROBOT.flashMessage("Don't feed me strange letter!", "red");
                 animation.robot.gotoAndPlay("error");
                 MG_GAME_STUPIDROBOT.playSound('fail_sound');
                 str = str.replace(/[`~!@#$%^&*()_=+{}|<>. /?;:\[\]\\",']/g, "");
                 $("#inputArea").val(str);
                 console.log("strange!!");
                 if(MG_GAME_STUPIDROBOT.inputlength > 0)
                 MG_GAME_STUPIDROBOT.inputlength--;
                 MG_GAME_STUPIDROBOT.setNewLevel();
                 }*/
                str = str.replace(/[`~!@#$%^&*()_=+{}|<>. /?;:\[\]\\",']/g, "");
                //console.log($("#inputArea").width());
                //$("#inputArea").val(str);

                if (event.keyCode != '13' && event.keyCode != '8' && event.keyCode != '46' && event.keyCode != '32') {
                    // num_sound = (input_length -1) % 8;
                    num_sound = (input_length - 1) < 7 ? (input_length - 1) : 7; // modified
                    // by
                    // Jack
                    // Guan
                    // 13/09/2013


                    if (input_length > MG_GAME_STUPIDROBOT.level + 3) {
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

            // set original level
            if (typeof(noTicker) == 'undefined')
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

            var loadScreen = document.getElementById("loading");
            loadScreen.parentNode.removeChild(loadScreen);

            // ANIMATION ADDITION ~ play "scan" when animation launches. Use
            // this code to cause animation to scan new images
            setTimeout(function () {
                MG_GAME_STUPIDROBOT.playSound('scan_sound');
                animation.robot.gotoAndPlay("scan");
            }, 1400);


        },

        setLevel: function () {
            // console.log("setlevel");
            if (MG_GAME_STUPIDROBOT.level > MG_GAME_STUPIDROBOT.maxLevel) {
                MG_GAME_STUPIDROBOT.renderFinal();
                return;
            }
            $("#inputArea").animate({width: MG_GAME_STUPIDROBOT.level * 0.67 + "em"});
            $("#inputArea").attr("maxlength", MG_GAME_STUPIDROBOT.maxlevel);
            $("#gameMessage").html("PLEASE INPUT WORD, HUMAN");

            $("#inputFields span").eq(MG_GAME_STUPIDROBOT.level - MG_GAME_STUPIDROBOT.startingLevel).addClass("hilight");
        },

        isLetter: function (e) {
            // console.log(MG_GAME_STUPIDROBOT.shift_detected);
            if (MG_GAME_STUPIDROBOT.shift_detected) {
                return false;
            }
            return (e >= 0x41 && e <= 0x5A)
                || (e >= 0x61 && e <= 0x7A);
        },

        setNewLevel: function () {
            //console.log("setNewlevel: " + MG_GAME_STUPIDROBOT.inputlength);
            if (MG_GAME_STUPIDROBOT.inputlength < 4)
                MG_GAME_STUPIDROBOT.level = 4;
            else
                MG_GAME_STUPIDROBOT.level = MG_GAME_STUPIDROBOT.inputlength;
            $("#inputArea").animate({width: MG_GAME_STUPIDROBOT.level * 0.67 + "em"}, 50);
            $("#inputArea").attr("maxlength", MG_GAME_STUPIDROBOT.maxLevel);
            //$("#gameMessage").html("PLEASE INPUT WORD, HUMAN");
            $("#inputFields span").removeClass("hilight");
            $("#inputFields span").eq(MG_GAME_STUPIDROBOT.level - MG_GAME_STUPIDROBOT.startingLevel).addClass("hilight");
        },

        flashMessage: function (message, color) {
            // console.log("flashMessage");
            var savedMessage = $("#gameMessage").html();
            $("#gameMessage").html(message);
            $("#gameMessage").css("color", color);
            $("#gameMessage").fadeOut(100);
            $("#gameMessage").fadeIn(100);
            $("#gameMessage").fadeOut(100);
            $("#gameMessage").fadeIn(100);

            setTimeout(function () {
                $("#gameMessage").fadeOut(100);
                $("#gameMessage").html(savedMessage);
                $("#gameMessage").css("color", "black");
                $("#gameMessage").fadeIn(100);
            }, 1625);
        },

        timerTick: function (isInit) {
            if (typeof(isInit) === 'undefined') {
                if (!MG_GAME_STUPIDROBOT.timerInit) {
//                    console.log("timerInit: " + MG_GAME_STUPIDROBOT.timerInit)
                    MG_GAME_STUPIDROBOT.timerInit = true;
//                    console.log("timerInit 2: " + MG_GAME_STUPIDROBOT.timerInit)
                }
                else
                    return; // block the replicate timerTick initialization
            }
            // console.log("timerTick");
            currentMinutes = Math.floor(MG_GAME_STUPIDROBOT.secs / 60);
            currentSeconds = MG_GAME_STUPIDROBOT.secs % 60;
            if (currentSeconds <= 9) currentSeconds = "0" + currentSeconds;
            $("#timer").html(currentMinutes + ":" + currentSeconds);
            // document.getElementById("timerText").innerHTML = currentMinutes +
            // ":" + currentSeconds; //Set the element id you need the time put
            // into.
            if (MG_GAME_STUPIDROBOT.secs <= 0) {
                MG_GAME_STUPIDROBOT.renderFinal();
                return;
            }

            setTimeout('MG_GAME_STUPIDROBOT.timerTick(true)', 1000);
            MG_GAME_STUPIDROBOT.secs--;
        },

        playSound: function (index) {
            // MG_GAME_STUPIDROBOT.sound[index].loop = true;
            MG_GAME_STUPIDROBOT.sound[index].play(MG_GAME_STUPIDROBOT.sounds[index]);
        },

        /*
         * on callback for the submit button
         */
        beforeSubmit: function () {
            // console.log("nmit");
            var tags = $.trim(MG_GAME_STUPIDROBOT.wordField.val());
            // evaluate for word too short
            // set false for testing turn handling in the sever side
            // if(tags.length < MG_GAME_STUPIDROBOT.level){
            //console.log(MG_GAME_STUPIDROBOT.wordArray[tags.length] + " " + tags.length);
            if (tags.length < 4) {
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
            else if ($.inArrayIn(tags, MG_GAME_STUPIDROBOT.words) !== -1) {
                animation.robot.gotoAndPlay("error");
                MG_GAME_STUPIDROBOT.flashMessage("You already tried that!", "red");
                MG_GAME_STUPIDROBOT.playSound('fail_sound');
                console.log(MG_GAME_STUPIDROBOT.words);
            }
            else if (MG_GAME_STUPIDROBOT.wordArray[tags.length - 4] != "!") {
                animation.robot.gotoAndPlay("error");
                MG_GAME_STUPIDROBOT.flashMessage("Try a different length!", "red");
                MG_GAME_STUPIDROBOT.playSound('fail_sound');
            } else {
                /*                if (!MG_GAME_STUPIDROBOT.remoteProcessing) {
                 MG_GAME_STUPIDROBOT.remoteProcessing = true;
                 } else {
                 MG_GAME_STUPIDROBOT.flashMessage("SLOW DOWN! TOO FAST!", "red");
                 animation.robot.gotoAndPlay("error");
                 MG_GAME_STUPIDROBOT.playSound('confused');
                 return false;
                 }*/
                MG_GAME_STUPIDROBOT.onsubmit(tags);
                /*
                 // ajax call to the nlp api
                 $.ajax({
                 type: "GET",
                 // url: "http://localhost:8139/possible_wordcheck",
                 url: MG_STUPIDROBOT.nlp_api_url + "/possible_wordcheck",
                 timeout: 5000,
                 data: { input: tags },
                 dataType: "json",
                 error: function (o) {
                 // console.log(o);
                 console.log('error with nlp api, so proceeding with the game');
                 console.log(MG_STUPIDROBOT.nlp_api_url);
                 MG_GAME_STUPIDROBOT.onsubmit(tags);
                 }
                 }).done(function (o) {
                 console.log("nlp response!");
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
                 });*/
            }
            return false;
        },

        onsubmit: function (tags) {
            $("#inputArea").val("");
            MG_GAME_STUPIDROBOT.words.push(tags);
            console.log("onsubmit: media_id " + MG_GAME_STUPIDROBOT.media.media_id);
            // send ajax call as POST request to validate a turn
            MG_API.ajaxCall('/games/play/gid/' + MG_GAME_API.settings.gid, function (response) {
                console.log("onsubmit: " + MG_GAME_API.settings.gid);
                if (MG_API.checkResponse(response)) {
                    MG_GAME_STUPIDROBOT.onresponse(response);
                }
                return false;
            }, {
                type: 'post',
                data: { // this is the data needed for the turn
                    turn: 1,
                    played_game_id: MG_GAME_STUPIDROBOT.game.played_game_id,
                    'submissions': [
                        {
                            media_id: MG_GAME_STUPIDROBOT.media.media_id,
                            pass: false,
                            tags: tags.toLowerCase(),
                            reboot: 0
                        }
                    ]
                }
            });
        },

        /*
         * evaluate each response from /api/games/play calls (POST or GET)
         */
        onresponse: function (response) {
            // console.log("onresponse");
            MG_GAME_API.curtain.hide();

            if ($.trim(MG_GAME_STUPIDROBOT.game.more_info_url) != "")
                MG_GAME_STUPIDROBOT.more_info = {url: MG_GAME_STUPIDROBOT.game.more_info_url, name: MG_GAME_STUPIDROBOT.game.name};

            //console.log("onresponse: " + response.turn.medias[0].full_size);
            //console.log("onresponse: " + response.turn.medias[0].media_id);


            if (!MG_GAME_STUPIDROBOT.mediaGet) {
                if (response.turn.medias) {
                    MG_GAME_STUPIDROBOT.media = response.turn.medias[0];
                }
                else {
                    console.log("meida not getted, try to get it again");
                    MG_GAME_STUPIDROBOT.re_init(true);
                    return;
                }
            }

            var accepted = {
                level: 1,
                tag: ""
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

                    if (turn.medias[0].nlp_test == -1) {
                        console.log('error with nlp api');
                        console.log(MG_STUPIDROBOT.nlp_api_url);
                    } else if (turn.medias[0].nlp_test == 0) {
                        animation.robot.gotoAndPlay("error");
                        MG_GAME_STUPIDROBOT.flashMessage("That's not a word...", "red");
                        MG_GAME_STUPIDROBOT.playSound('fail_sound');
                    } else if (turn.medias[0].tag_accepted) {
                        accepted.level = turn.medias[0].level;
                        accepted.tag = tag;

                        MG_GAME_STUPIDROBOT.levels.push(accepted);
                        // console.log(MG_GAME_STUPIDROBOT.level + " and " +
                        // tag.tag);

                        MG_GAME_STUPIDROBOT.wordArray[MG_GAME_STUPIDROBOT.inputlength - 4] = tag.tag;
                        $("#inputFields span").eq(MG_GAME_STUPIDROBOT.level - MG_GAME_STUPIDROBOT.startingLevel).addClass("completed");
                        //MG_GAME_STUPIDROBOT.level++;
                        MG_GAME_STUPIDROBOT.setLevel();
                        MG_GAME_STUPIDROBOT.wordsAccepted++;
                        if (MG_GAME_STUPIDROBOT.wordsAccepted > MG_GAME_STUPIDROBOT.maxLevel) {
                            MG_GAME_STUPIDROBOT.renderFinal();
                            return;
                        }
                        MG_GAME_STUPIDROBOT.inputlength = 0;
                        MG_GAME_STUPIDROBOT.setNewLevel();

//                     	console.log("correct");

                        MG_GAME_STUPIDROBOT.flashMessage("SO <em>THAT'S</em> WHAT THAT IS!", "green");
                        animation.robot.gotoAndPlay("correctAnswer");
                        MG_GAME_STUPIDROBOT.playSound('next_level');

                    } else {
                        // no match -- feedback
                        // console.log("not accepted");
                        MG_GAME_STUPIDROBOT.inputlength = 0;
                        MG_GAME_STUPIDROBOT.setNewLevel();

                        MG_GAME_STUPIDROBOT.flashMessage("AH, A NEW WORD?", "blue");
                        animation.robot.gotoAndPlay("incorrectAnswer");
                        MG_GAME_STUPIDROBOT.playSound('confused');
                    }
                    MG_GAME_STUPIDROBOT.remoteProcessing = false;
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

            if (!MG_GAME_STUPIDROBOT.mediaGet) {
                MG_GAME_STUPIDROBOT.mediaGet = true;
                var turn_info = {
                    url: response.turn.medias[0].full_size,
                    url_full_size: response.turn.medias[0].full_size,
                    licence_info: MG_GAME_API.parseLicenceInfo(response.turn.licences)
                };

                $("#imageContainer").find("img").attr("src", turn_info.url);
                $("#imageContainer").find("a").attr("href", turn_info.url);
                $("#imageContainer").find("a").attr("title", turn_info.licence_info);
                $("a[rel='zoom']").fancybox({overlayColor: '#000'});

                var tmpImg = new Image();
                tmpImg.src = turn_info.url; //or  document.images[i].src;
//                tmpImg.src = $("#imageContainer").find("img").attr("src"); //or  document.images[i].src;
                $(tmpImg).on('load', function () {
                    // auto resize the image
//                    imageH = tmpImg.height;
//                    imageW = tmpImg.width;
                    imageH = $("#gameImage").height();
                    imageW = $("#gameImage").width();
                    if (imageW > imageH) {
                        $("#gameImage").width($("#imageContainer").width());
                        $("#gameImage").height($("#gameImage").height() * $("#gameImage").width() / imageW);
//                        tmpImg.width = $("#imageContainer").width() * 1.1;
//                        tmpImg.height = tmpImg.height * tmpImg.width / imageW;
                        $("#gameImage").css("margin-top", function () {
                            return ($("#container").height() - $("#gameImage").height()) / 2;
                        });
                    } else {
//                        tmpImg.height= $("#container").height() * 0.9;
//                        tmpImg.width  = tmpImg.width * tmpImg.height / imageH;
                        $("#gameImage").height($("#imageContainer").height() * 0.9);
                        $("#gameImage").width($("#gameImage").width() * $("#gameImage").height() / imageH);
                        $("#gameImage").css("margin-left", function () {
                            return ($("#imageContainer").width() - $("#gameImage").width()) / 2;
                        });
                    }
                });


            } else {
                MG_GAME_STUPIDROBOT.mediaGet = true;
            }
//            console.log($("a[rel='zoom']").attr("href"))

            MG_GAME_STUPIDROBOT.wordField.focus();
        },

        ongameinit: function (response) {
            // console.log('ongameinit to with response, about to go in
            // onresponse');
            console.log("ongameinit: ");
            MG_GAME_STUPIDROBOT.onresponse(response);
        },

        scrollIn: function () {
            // console.log("scrollIn");
            // console.log("MG_GAME_STUPIDROBOT.scrollIn");
            MG_GAME_STUPIDROBOT.p = MG_GAME_STUPIDROBOT.wordSpaces[MG_GAME_STUPIDROBOT.activeLine];
            MG_GAME_STUPIDROBOT.i++;
            // console.log("activeLine: " + MG_GAME_STUPIDROBOT.activeLine);
            if (MG_GAME_STUPIDROBOT.activeLine >= 10) {
                // scroll is finished

                createjs.Ticker.setFPS(24);
                createjs.Ticker.addListener(MG_GAME_STUPIDROBOT.scorestage);
                return;
            }
            if (MG_GAME_STUPIDROBOT.i > MG_GAME_STUPIDROBOT.wordArray[MG_GAME_STUPIDROBOT.activeLine].length) {
                MG_GAME_STUPIDROBOT.wordSpaces[MG_GAME_STUPIDROBOT.activeLine].innerHTML = MG_GAME_STUPIDROBOT.a;
                MG_GAME_STUPIDROBOT.activeLine++;
                MG_GAME_STUPIDROBOT.i = 0;

                setTimeout("MG_GAME_STUPIDROBOT.scrollIn()", 25);
                return;
            }
            MG_GAME_STUPIDROBOT.a = MG_GAME_STUPIDROBOT.wordArray[MG_GAME_STUPIDROBOT.activeLine].substring(0, MG_GAME_STUPIDROBOT.i);
            if (MG_GAME_STUPIDROBOT.a == "!") {
                MG_GAME_STUPIDROBOT.i = 0;
                setTimeout("MG_GAME_STUPIDROBOT.scrollIn()", 25);
                MG_GAME_STUPIDROBOT.p.style.backgroundColor = "black";
                MG_GAME_STUPIDROBOT.activeLine++;
                // console.log(MG_GAME_STUPIDROBOT.activeLine + " and2 " +
                // MG_GAME_STUPIDROBOT.wordArray.length);

                return;
            }


            MG_GAME_STUPIDROBOT.p.innerHTML = MG_GAME_STUPIDROBOT.a + "_";

            setTimeout("MG_GAME_STUPIDROBOT.scrollIn()", 25);
        },

        renderFinal: function () {
            if (MG_GAME_STUPIDROBOT.isRenderFinaled == true)
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
            $("#game").remove();
            $("#score").show();
            $("#score").html(MG_GAME_STUPIDROBOT.scorehtml);
            // passed levels should be added as "!"

            $("#reboot").click(function () {
                MG_GAME_STUPIDROBOT.re_init();
            });

            // determine level by length of word array, minus passes
            for (var i = 0; i < MG_GAME_STUPIDROBOT.wordArray.length; i++) {
                if (MG_GAME_STUPIDROBOT.wordArray[i] != "!") {
                    MG_GAME_STUPIDROBOT.scorelevel++;
                }
            }
            // set up text message
            var message = document.getElementById("gameMessage");
            var messageString;
            switch (MG_GAME_STUPIDROBOT.scorelevel) {
                case 0:
                    messageString = "I NEED MORE HELP. TRY AGAIN?";
                    break;
                case 1:
                    messageString = "I FEEL AN ITTY BITTY BIT SMARTER!";
                    MG_GAME_STUPIDROBOT.playSound('score_1');
                    break;
                case 2:
                    messageString = "I AM SLIGHTLY SMARTER!";
                    MG_GAME_STUPIDROBOT.playSound('score_2');
                    break;
                case 3:
                    messageString = "STUPID ROBOT SEEKS MORE KNOWLEDGE!";
                    MG_GAME_STUPIDROBOT.playSound('score_3');
                    break;
                case 4:
                    messageString = "I'VE LEARNED SO MUCH!";
                    MG_GAME_STUPIDROBOT.playSound('score_4');
                    break;
                case 5:
                    messageString = "THEY SHOULD CALL ME SMARTY ROBOT!";
                    MG_GAME_STUPIDROBOT.playSound('score_5');
                    break;
                case 6:
                    messageString = "NEXT TIME, I'LL TEACH YOU!";
                    // MG_GAME_STUPIDROBOT.playSound('score_6');
                    break;
                case 7:
                    messageString = "I FEEL... SOPHISTICATED!";
                    break;
                case 8:
                    messageString = "I AM READY TO TAKE ON DEEP BLUE!";
                    break;
                case 9:
                    messageString = "ALL YOUR TAGS ARE BELONG TO ME!";
                    break;
                default:
                    messageString = "I FEEL AN ITTY BITTY BIT SMARTER.";
            }

            message.innerHTML = "YOU TAUGHT ME " + MG_GAME_STUPIDROBOT.scorelevel + " WORDS!<br>" + messageString;

            var canvas = document.getElementById("canvas");
            var exportRoot = new lib.animation_score(MG_GAME_STUPIDROBOT.scorelevel);

            // console.log("MG_GAME_STUPIDROBOT.scorelevel: " +
            // MG_GAME_STUPIDROBOT.scorelevel);

            MG_GAME_STUPIDROBOT.scorestage = new createjs.Stage(canvas);
            MG_GAME_STUPIDROBOT.scorestage.addChild(exportRoot);
            MG_GAME_STUPIDROBOT.scorestage.update();

            // set up scroller
            var wordspaceCollection = document.getElementsByClassName("underlinedText");
            MG_GAME_STUPIDROBOT.wordSpaces = Array.prototype.slice.call(wordspaceCollection);
            MG_GAME_STUPIDROBOT.scrollIn();
        },

        re_init: function (noTicker) {
            // the following is copied from pyramid tag
            MG_GAME_STUPIDROBOT.wordField = null;
            MG_GAME_STUPIDROBOT.playOnceMoveOnFinalScreenWaitingTime = 15000; // milliseconds
            MG_GAME_STUPIDROBOT.submitButton = null;
            //MG_GAME_STUPIDROBOT.media=null;
            MG_GAME_STUPIDROBOT.licence_info = [];
            MG_GAME_STUPIDROBOT.more_info = null;
            MG_GAME_STUPIDROBOT.levels = [];
            MG_GAME_STUPIDROBOT.pass_penalty = 0; // in seconds
            MG_GAME_STUPIDROBOT.level_step = 3;
            MG_GAME_STUPIDROBOT.words = [];
            MG_GAME_STUPIDROBOT.sound = {};
            MG_GAME_STUPIDROBOT.sounds = {};

            // the following variable is newly added in stupidrobot for gaming =
            MG_GAME_STUPIDROBOT.startingLevel = 4;
            MG_GAME_STUPIDROBOT.level = null;
            MG_GAME_STUPIDROBOT.maxLevel = 13;
            MG_GAME_STUPIDROBOT.letterWidthInEms = 0.67;
            MG_GAME_STUPIDROBOT.speed = 200;
            MG_GAME_STUPIDROBOT.secs = 120;
            MG_GAME_STUPIDROBOT.fields = null;
            MG_GAME_STUPIDROBOT.animation = null;
            MG_GAME_STUPIDROBOT.scorehtml = "";
            // MG_GAME_STUPIDROBOT.loadgame = "";
            MG_GAME_STUPIDROBOT.wordsAccepted = 0;
            MG_GAME_STUPIDROBOT.inputlength = 0;
            //MG_GAME_STUPIDROBOT.main_menu_bar =  null;
            MG_GAME_STUPIDROBOT.shift_detected = false;
            MG_GAME_STUPIDROBOT.mediaGet = false;
            MG_GAME_STUPIDROBOT.timerInit = false;

            // new added for scoring
            MG_GAME_STUPIDROBOT.isRenderFinaled = false;
            MG_GAME_STUPIDROBOT.wordSpaces = null;
            MG_GAME_STUPIDROBOT.wordArray = ["!", "!", "!", "!", "!", "!", "!", "!", "!", "!", ];
            // wordArray = ["word";
            //"word";"word";"word";"word";"word";"word";"word";"word";"word";];
            MG_GAME_STUPIDROBOT.a = "";
            MG_GAME_STUPIDROBOT.p = null;
            MG_GAME_STUPIDROBOT.i = 0;
            MG_GAME_STUPIDROBOT.activeLine = 0;
            MG_GAME_STUPIDROBOT.scorestage = null;
            MG_GAME_STUPIDROBOT.scorelevel = 0;

            $("#loadgame").remove();
            $("#score").remove();
            $("#game").remove();
            $("#button-loop-1").remove();
            $("body").append(MG_GAME_STUPIDROBOT.loadgame);
//            console.log(MG_GAME_STUPIDROBOT.loadgame);
            MG_GAME_STUPIDROBOT.init(MG_GAME_STUPIDROBOT.init_options, noTicker);
        }

    });
}(jQuery);


/* For the new side panel */
$('#sidepanel #tab').toggle(function () {
    $(this).attr("class", "tab_open");
    $('#sidepanel').animate({'right': 0});
}, function () {
    // Question: Why does '-290' work, and '-300' push the arrow too
    // far right?
    $(this).attr("class", "tab_closed");
    $('#sidepanel').animate({'right': -290});
});

function onResize() {
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

(function ($) {
    $.extend({
        // Case insensative inArray
        inArrayIn: function (elem, arr, i) {
            // not looking for a string anyways, use default method
            if (typeof elem !== 'string') {
                return $.inArrayIn.apply(this, arguments);
            }
            // confirm array is populated
            if (arr) {
                var len = arr.length;
                i = i ? (i < 0 ? Math.max(0, len + i) : i) : 0;
                elem = elem.toLowerCase();
                for (; i < len; i++) {
                    if (i in arr && arr[i].toLowerCase() == elem) {
                        return i;
                    }
                }
            }
            // stick with inArray/indexOf and return -1 on no match
            return -1;
        }
    })
})(jQuery);
