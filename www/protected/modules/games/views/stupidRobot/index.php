<!DOCTYPE html>
<html class="no-js" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Stupid Robot</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->

    <!--link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/vendor/modernizr-2.6.2.min.js"></script-->
</head>

<body class="splashContent">
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Add your site or application content here -->

<div id = "welcomepage">
<div id="loading">loading!</div>

<div class="manifest" id="tree">

    <img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/Bitmap3.jpg"/>
    <img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/Bitmap7.jpg"/>
    <img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/Bitmap5.jpg"/>
    <img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/Bitmap6.jpg"/>
    <img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/FlashAICB.png"/>
    <img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/tree.jpg"/>
</div>

<canvas id="canvas" width=960 height=180></canvas>

<button class="audio-button" id="button-loop-1" type="button" value="1">
    <img class="audio_off" src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/audio-off.png"/>
    <img class="audio_on" src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/audio-on.png"/>
</button>

<div id="container">


    <h1 class="clearfix">STUPID ROBOT</h1>

    <p class="scrollText">&nbsp;</p>

    <p class="scrollText">&nbsp;</p>

    <p class="scrollText">&nbsp;</p>
    <br>

    <p class="scrollText">&nbsp;</p>
    <br>

    <p class="scrollText">&nbsp;</p>

    <p class="scrollText">&nbsp;</p>
    <br>

    <p class="scrollText">&nbsp;</p>

    <p class="scrollText">&nbsp;</p>

    <p class="scrollText">&nbsp;</p>
    <br>

    <p class="scrollText">&nbsp;</p>
    <br>
    <span id='idx_skipanimate'>skip animation >></span>
    <div>
    <button id="bootButton" class="clearfix button">PLAY</button>
    </div>
</div>
</div>


<div id="loadgame">
<input type="hidden" id="game_assets_uri" value="<?php echo GamesModule::getAssetsUrl() . '/stupidrobot/'; ?>"/>


<button class="audio-button" id="button-loop-1" type="button" value="1">
    <img class="audio_off" src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/audio-off.png"/>
    <img class="audio_on" src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidrobot/images/audio-on.png"/>
</button>


<div id="game">
    <div id="loading">loading!</div>

    <!--[if lt IE 8]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a
        href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Add your site or application content here -->
    <div id="container">
        <div class="leftBox clearfix2">
            <span id="timer"></span>
            <span id="gameMessage">STAND BY</span>
            <input type=text id="inputArea" class="underlinedText clearfix2">
            <!-- span id = "underline">jack</span-->
            <div id="inputFields" class="clearfix2">
                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span>
            </div>
            <a class="button" id="pass">pass</a>
            <canvas class="clearfix" id="canvas" width="342" height="212"></canvas>
            <a class="button" id="gamedone" type="button" value="1">QUIT</a>
        </div>
        <div class="rightBox" id="imageContainer">
            <a class="gameImageLink" href="" rel="zoom" title=""><img id="gameImage" src="" alt="game image"/></a>
            <!--center><img src=""/></center-->
        </div>
    </div>
</div>


<div id="score">

    <div id="container">
        <div class="leftBox clearfix">
            <span id="gameMessage">I NOW COMPREHEND 6 NEW WORDS<br>I AM SOMEWHAT SMARTER!</span>
            <br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><span
                class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><span
                class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <br><a class="button" id="reboot">REBOOT</a>
        </div>
        <div class="rightBox" id="imageContainer">
            <canvas class="clearfix" id="canvas" width="1000" height="1000"></canvas>
        </div>
    </div>
</div>


<div style="height: 0px; padding: 0; margin: 0; overflow:scroll;">

    <script id="template-licence" type="text/x-jquery-tmpl">
        <h4>${name}</h4>

        <p>${description}</p>





    </script>

    <script id="template-make-sound" type="text/x-jquery-tmpl">
        <audio id='make_sound' style="height: 0px;">
            <source src="${ogg_path}" type="audio/ogg">
            <source src="${mp3_path}" type="audio/mpeg">
        </audio>





    </script>

    <script id="template-account_bookmark" type="text/x-jquery-tmpl">
        <div class="bookmark">
            {{each bookmarked}}
            <img src="${thumbnail}" class="show_big" scaled="${scaled}" />
            {{/each}}
        </div>





    </script>

    <script id="template-account_interest" type="text/x-jquery-tmpl">
        {{each interests}}
        <div interest_id="${id}" class="back_yellow row">
            <div>${interest}</div>
            <div class="delete right"></div>
        </div>
        {{/each}}





    </script>

    <script id="template-account_playlist" type="text/x-jquery-tmpl">
        {{each play_lists}}
        {{if isBanned != true}}
        <div institution_id="${id}" class="back_yellow row">
            <div><span class="institution">${name}</span></div>
            <div class="delete right"></div>
        </div>
        {{/if}}
        {{/each}}





    </script>

    <script id="template-account_update" type="text/x-jquery-tmpl">
        <div class="button">
            <input type="text" class="input" autocapitalize="off" autocorrect="off" autocomplete="off" id="username" name="username" placeholder="Change username" value="${username}" tabindex="1" />
        </div>
        <div class="button">
            <input type="password" class="input" autocapitalize="off" autocorrect="off" autocomplete="off" id="password" name="password" placeholder="Change password" value="" tabindex="2" />
        </div>
        <div class="button">
            <input type="email" class="input" autocapitalize="off" autocorrect="off" autocomplete="off" id="email" name="email" placeholder="Change e-mail" value="${email}" tabindex="3" value="" />
        </div>
        <div class="button">
            <a href="#" id="btn_update" class="button login"><span>UPDATE</span></a>
        </div>





    </script>

    <!--    <script id="template-favorite_institutions" type="text/x-jquery-tmpl">
            <div id="listing">
                <div class="padding div_text">When you add an archive to your favorites, you will see more images from that archive when you play.</div>
                <div id="favorite_institutions"  class="padding" align="center">
                    <div id="list_institutions" class="group">
                        {{each all_institution}}
                        <div institution_id="${id}" class="institution left right_padding">
                            <a href="" title="${name}"><img class="institution_logo" src="${logo}" width="70" height="70" /></a>
                        </div>
                        {{/each}}
                    </div>
                </div>
            </div>
        </script>-->

    <script id="template-favorite_institutions" type="text/x-jquery-tmpl">
    </script>

    <script id="template-show_institution" type="text/x-jquery-tmpl">
        <div class="padding" style="width: 320px;">
            <div class="text-center"><img src="${logo}" /></div>
            <h4>${name}</h4>
            <div>${description}</div>
        </div>





    </script>

    <script id="template-turn" type="text/x-jquery-tmpl">
        <div style="text-align:center">
            <img src="${url}" alt="game image" id="image_to_tag" style="width: auto !important; height: auto !important; "/>
        </div>





    </script>
    <script id="template-pyramid-step" type="text/x-jquery-tmpl">
        <div style="margin:5px auto;background-color:#EEEEEE;border:1px solid #CCCCCC;width:${width}px;">${tag}</div>





    </script>
    <script id="template-final-summary-play-once" type="text/x-jquery-tmpl">
        <div style="text-align:center" class="group">
            <a href="${url_full_size}" rel="zoom" title="${licence_info}"><img src="${url}" alt="game image"/></a>
        </div>





    </script>
    <script id="template-more-info" type="text/x-jquery-tmpl">
        <a href="${url}">Click here to learn more about ${name}</a>





    </script>
    <script id="template-final-info" type="text/x-jquery-tmpl">
        <div class="final">${finalMsg}<br />${finalMsg_2ndline}</div>
        <div class="level_9 pyramid">&nbsp;</div>
        <div class="level_8 pyramid">&nbsp;</div>
        <div class="level_7 pyramid">&nbsp;</div>
        <div class="level_6 pyramid">&nbsp;</div>
        <div class="level_5 pyramid">&nbsp;</div>
        <div class="level_4 pyramid">&nbsp;</div>
        <div class="level_3 pyramid">&nbsp;</div>
        <div class="level_2 pyramid">&nbsp;</div>
        <div class="level_1 pyramid"></div>
        <div class="new_game"><a href="#" id="button-play-again"><span>&nbsp;</span></a></div>





    </script>
    <script id="template-final-info-play-once" type="text/x-jquery-tmpl">
        You'll be redirected in <span id="remainingTime">${remainingTime}</span> seconds. <a
            href="${play_once_and_move_on_url}">Click here to proceed right away.</a></p>





    </script>
    <script id="template-info-modal-critical-error" type="text/x-jquery-tmpl">
        ${error} <p>Return to the <a href="${arcade_url}">arcade</a>.</p>





    </script>
</div>


</div>


</body>
</html>
