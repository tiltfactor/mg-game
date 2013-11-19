<div id="gamearea">
    <input type="hidden" id="game_assets_uri" value="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/" />
    <div id="no_js" class="hidden">Unfortunately we can't show the game as it relies on JavaScript which appears to be disabled on your browser.</div>
    <!-- Images from the database appear here -->
    <div id="stage">
        <div id="header" class="group">
            <a href="#menu-left" class="header_mm_left">
                <span class="words hidden top_btn">Words</span>
                <span class="back hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/back.png" /></span>
            </a>
            <a href="#menu-right" class="right setting hidden"></a>
        </div>
        <div id="content" class="group">
            <div id="login" class="text-center index_screen hidden">
                <div class="logo"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/logo.png" /></div>
                <div class="button">
                    <input type="text" autocapitalize="off" autocorrect="off" autocomplete="off" id="username" name="username" placeholder="Username" />
                </div>
                <div class="button">
                    <input type="password" autocapitalize="off" autocorrect="off" autocomplete="off" id="password" name="password" placeholder="Password" />
                </div>
                <div class="button">
                    <input id="rememberMe" type="checkbox" value="1" name="rememberMe" style="width:20px;">
                    <label for="rememberMe">Remember me next time</label>
                </div>
                <div class="button">
                    <a href="#" id="btn_login" class="button login"><span>LOGIN</span></a>
                </div>
                <div class="button">
                    or
                </div>
                <div class="button">
                    <a href="#" location="register" class="button new_user"><span>GET A USERNAME</span></a>
                    <span class="hidden"><a href=""></a></span>
                </div>
                <div id="facebook"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/facebook.png" /></div>
            </div>
            <div id="register" class="text-center index_screen hidden">
                <div class="logo"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/logo.png" /></div>
                <div class="button">
                    <input type="text" autocapitalize="off" autocorrect="off" autocomplete="off" id="username" name="username" placeholder="Choose a username" value="" tabindex="1" />
                </div>
                <div class="button">
                    <input type="password" autocapitalize="off" autocorrect="off" autocomplete="off" id="password" name="password" placeholder="Choose a password" value="" tabindex="2" />
                </div>
                <div class="button">
                    <input type="password" autocapitalize="off" autocorrect="off" autocomplete="off" id="verifyPassword" name="verifyPassword" placeholder="Verify Password" value="" tabindex="3" />
                </div>
                <div class="button">
                    <input type="email" autocapitalize="off" autocorrect="off" autocomplete="off" id="email" name="email" placeholder="Choose an e-mail" tabindex="4" value="" />
                </div>
                <div class="button">
                    <a href="#" id="btn_register" class="button login"><span>START PLAYING</span></a>
                </div>
            </div>
            <div id="account_update" class="hidden text-center">

            </div>
            <div id="main_screen" class="hidden">
                <div class="back_black header">
                    <div class="group title">WELCOME <span class="username"></span></div>
                    <div>
                        <a href="#" location="new_game" class="big_button new_game"><span>NEW GAME</span></a>
                    </div>
                </div>
            </div>

            <div id="new_game" class="hidden">
                <h2>NEW GAME</h2>
                <div class="back_blue row"><div><a href="#" location="find_opponent">Opponent by User Name</a></div></div>
                <div class="back_blue row"><div><a href="#" location="make_challenge">Random Opponent</a></div></div>
                <div class="back_blue row"><div><a href="#" location="find_opponent">Facebook Friend</a></div></div>
            </div>

            <div id="find_opponent" class="hidden">
                <h2>ENTER A USER NAME</h2>
                <div class="padding text-center"><input autocapitalize="off" autocorrect="off" autocomplete="off" type="text" id="input_opponent" name="opponent_name" class="opponent_name" /></div>
                <div class="margin_topBottom"><a href="#" location="make_challenge" class="big_button play"><span>PLAY</span></a></div>
            </div>

            <div id="game_screen" class="hidden">

            </div>

            <div id="final_screen" class="hidden">

            </div>

            <div id="game_customize" class="hidden">
                <h2>CUSTOMIZE YOUR GAME</h2>
                <div class="padding div_text">Share your interests and you might see more images with those subjects! Use commas to separate interests.</div>
                <div class="new_interest text-center"><input autocapitalize="off" autocorrect="off" autocomplete="off" id="new_interest" type="text" placeholder="I'm interested in..." /></div>
                <hr />
            </div>

            <div id="learn_more" class="hidden">
                <h2>Learn More</h2>
                <div class="padding">One Up is part of a suite of games from the
                    Metadata Games project. Metadata Games is a
                    Free and Open Source (FOSS) online game
                    system for gathering useful data on photo,
                    audio, and moving image artifacts. By playing,
                    you have a direct impact on the preservation
                    and accessibility of vital cultural heritage
                    collections for future generations.</div>
                <div class="padding">
                    Metadata Games is created by the Tiltfactor
                    Laboratory at Dartmouth College, with support
                    from the National Endowment for the
                    Humanities (NEH) and the American Council of
                    Learned Societies (ACLS).
                </div>
                <h3 class="padding">METADATAGAMES</h3>
                <div>
                    <span class="tiltfactor_logo" />
                    <span class="dartmouth_logo" />
                    <span class="neh_logo" />
                </div>

            </div>

            <div id="institution_info" class="hidden">

            </div>

            <div id="how_to" class="hidden">
                <h2>How to Play</h2>
                <div id="image_gallery">
                    <div number="1" data-number = "1" class="row text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_1.jpg" width="320" height="455"/></div>
                    <div number="2" data-number = "2" class="row hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_2.jpg" width="320" height="455" /></div>
                    <div number="3" data-number = "3" class="row hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_3.jpg" width="320" height="455" /></div>
                    <div number="4" data-number = "4" class="row hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_4.jpg" width="320" height="455" /></div>
                    <div number="5" data-number = "5" class="row hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_5.jpg" width="320" height="455" /></div>
                    <div number="6" data-number = "6" class="row hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_6.jpg" width="320" height="455" /></div>
                    <div number="7" data-number = "7" class="row hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_7.jpg" width="320" height="455" /></div>
                    <div number="8" data-number = "8" class="row hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_8.jpg" width="320" height="455" /></div>
                    <div number="9" data-number = "9" class="row hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_9.jpg" width="320" height="455" /></div>
                    <div number="10" data-number = "10" class="row hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_10.jpg" width="320" height="455" /></div>
                </div>
            </div>

            <div id="account" class="hidden">
                <h2>Account</h2>
                <div class="back_blue row row_link"><div><a href="#" location="account_update">UPDATE ACCOUNT SETTINGS</a></div></div>
                <div id="account_info">
                    <div id="bookmarks">
                        <h3 class="no_margin">YOUR BOOKMARKED IMAGES</h3>
                        <div id="account_bookmark" class="group">
                        </div>
                    </div>

                    <div id="play_lists">
                        <h3>YOUR PLAYLIST</h3>
                        <div id="account_playlist" class="group"></div>
                    </div>

                    <div id="interests">
                        <h3>YOUR INTERESTS</h3>
                        <div id="account_interest" class="group"></div>
                    </div>
                </div>
            </div>

            <div id="word_screen" class="hidden">

            </div>
        </div>
        <nav id="menu-left">
        </nav>
        <nav id="menu-right" style="visibility: hidden;">
            <ul>
                <li class="back_blue row"><div><a href="#" location="main_screen"><span>PLAY</span></a></div></li>
                <li class="back_blue row"><div><a href="#" location="game_customize"><span>CUSTOMIZE</span></a></div></li>
                <li class="back_blue row"><div><a href="#" location="how_to"><span>HOW TO PLAY</span></a></div></li>
                <li class="back_blue row"><div><a href="#" location="learn_more"><span>LEARN MORE</span></a></div></li>
                <li class="back_blue row"><div><a href="#" location="account"><span>ACCOUNT</span></a></div></li>
                <li class="back_blue row"><div><a href="#" location="logout"><span>LOGOUT</span></a></div></li>
            </ul>
        </nav>
    </div>
</div>

<script id="template-account_update" type="text/x-jquery-tmpl">
    <div class="button">
        <input type="text" autocapitalize="off" autocorrect="off" autocomplete="off" id="username" name="username" placeholder="Change username" value="${username}" tabindex="1" />
    </div>
    <div class="button">
        <input type="password" autocapitalize="off" autocorrect="off" autocomplete="off" id="password" name="password" placeholder="Change password" value="" tabindex="2" />
    </div>
    <div class="button">
        <input type="email" autocapitalize="off" autocorrect="off" autocomplete="off" id="email" name="email" placeholder="Change e-mail" value="${email}" tabindex="3" value="" />
    </div>
    <div class="button">
        <a href="#" id="btn_update" class="button login"><span>UPDATE</span></a>
    </div>
</script>

<script id="template-word_screen" type="text/x-jquery-tmpl">
    <div class="row back_dark_gray round_row">
        <div class="no_right_padding" style="white-space: auto !important;">
            <span class="round">ROUND <span>${current_level}</span></span>
            <div class="right header_scores">
                <div class="you"><span class="active_player">You</span> <label>${score}</label></div>
                <div class="opponent">${opponentName} <label>${opponentScore}</label></div>
            </div>
        </div>
    </div>
    <h3>ROUND 1</h3>
    {{html round_1}}
    <h3>ROUND 2</h3>
    {{html round_2}}
    <h3>ROUND 3</h3>
    {{html round_3}}
</script>

<script id="template-final_screen" type="text/x-jquery-tmpl">
    <div class="row back_dark_gray no_right_padding">
        <div class="no_right_padding">
            <span class="round">${game_result}</span>
            <div class="right header_scores">
                <div class="you">You <label>${score}</label></div>
                <div class="opponent">${opponentName} <label>${opponentScore}</label></div>
            </div>
        </div>
    </div>
    <h4 class="text-center" style="padding-left:5px;padding-right:5px;">${congratulation_text}</h4>
    <br/>
    <div>
        <a href="#" opponent="${opponentName}" class="big_button rematch"><span>REMATCH</span></a>
    </div>
    <br/>
    <br/>

    <div class="group" style="min-height:200px;">
        <div class="bookmark_img">
            <div class="left" style="padding: 0 10px 10px 10px;"><img src="${media.imageScaled}" class="left" style="max-width:250px;" id="mediaImg"/></div>
            <div style="color:#9FA1A4;">This image provided by ${media.collection} at ${media.institution}</div>
            <div style="margin-top:25px;"><a href="${media.instWebsite}" target="_blank" style="color:#9FA1A4;"> Learn more about the collection (...)</a></div>

            <div style="clear:both;">
                <input type="checkbox" id="bookmark_image" class="checkbox" /> <label for="bookmark_image" class="bookmark_image top_btn">Bookmark this image</label>
            </div>
        </div>
    </div>
    <h3>YOU SAID <span>ROUND 1</span></h3>
    {{html you.round_1}}
    <h3><span>ROUND 2</span></h3>
    {{html you.round_2}}
    <h3><span>ROUND 3</span></h3>
    {{html you.round_3}}
    <div id='overlay'></div>
    <div class="fade">
        <h3>${opponentName} SAID <span>ROUND 1</span></h3>
        {{html opponent.round_1}}
        <h3><span>ROUND 2</span></h3>
        {{html opponent.round_2}}
        <h3><span>ROUND 3</span></h3>
        {{html opponent.round_3}}
    </div>
</script>

<script id="template-show_institution" type="text/x-jquery-tmpl">
    <div class="padding" style="width: 320px;">
        <div class="text-center"><img src="${logo}" /></div>
        <h4>${name}</h4>
        <div>${description}</div>
    </div>
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

<script id="template-account_interest" type="text/x-jquery-tmpl">
    {{each interests}}
    <div interest_id="${id}" class="back_yellow row">
        <div>${interest}</div>
        <div class="delete right"></div>
    </div>
    {{/each}}
</script>

<script id="template-account_bookmark" type="text/x-jquery-tmpl">
    <div class="bookmark">
        {{each bookmarked}}
        <img src="${thumbnail}" class="show_big" scaled="${scaled}" />
        {{/each}}
    </div>
</script>

<script id="template-challenges" type="text/x-jquery-tmpl">
    <div id="challenges">
        <div id="challenges_received" class="list_challenges">
            <h3 class="no_margin">YOUR TURN</h3>
            {{each finished_games}}
            <div opponent_id="${opponentId}" playedGameId="${playedGameId}" class="back_yellow row">
                <div class="start_game" type="show_final">GAME WITH <span class="username">${opponentName}</span> FINISHED</div>
            </div>
            {{/each}}
            <div class="no_value hidden">Challenge anyone. Start to play!</div>
            {{each received}}
            <div opponent_id="${id}" playedGameId="" class="back_yellow row">
                <div class="start_game" type="accept_challenge"><span class="username">${username}</span> CHALLENGED YOU</div>
                <div class="delete right"></div>
            </div>
            {{/each}}

            {{each your_turn}}
            <div opponent_id="${opponentId}" playedGameId="${playedGameId}" class="back_yellow row">
                <div class="start_game" type="game">GAME WITH <span class="username">${opponentName}</span></div>
                <div class="delete right"></div>
            </div>
            {{/each}}

        </div>
        <div id="challenges_sent" class="list_challenges">
            <h3>WAITING</h3>
            <div class="no_value hidden">No one waits for you!</div>
            {{each sent}}
            <div opponent_id="${id}" playedGameId="" class="back_gray row">
                <div>GAME WITH <span class="username">${username}</span></div>
                <div class="delete right"></div>
            </div>
            {{/each}}

            {{each waiting_turn}}
            <div opponent_id="${opponentId}" playedGameId="${playedGameId}" class="back_gray row">
                <div>GAME WITH <span class="username">${opponentName}</span></div>
                <div class="delete right"></div>
            </div>
            {{/each}}
        </div>
    </div>
</script>

<script id="template-game_screen" type="text/x-jquery-tmpl">
    <div class="row back_dark_gray no_right_padding">
        <div class="no_right_padding"><span class="round" status="playing" opponent="${opponentStatus}">ROUND ${current_level}</span></div>
        <div class="right header_scores">
            <div class="you"><span class="active_player">You</span> <label>${turn.score}</label></div>
            <div class="opponent"><span class="waiting_player">${opponentName}</span> <label>${turn.opponentScore}</label></div>
        </div>
    </div>
    <div class="main_gray">
        {{each(i, media_item) turn.media}}
        <img src="${media_item.imageFullSize}" id="game_image" />
        {{/each}}
    </div>
    <div class="words">
        {{each current_turn_tag}}
        {{html div}}
        {{/each}}

        {{for(i = num_words; i < 3; i++)}}
        <div class="small_row blank_bar add_word"><div>ADD A WORD</div></div>
        {{/for }}
    </div>

</script>

<script id="template-favorite_institutions" type="text/x-jquery-tmpl">
    <div id="listing">
        <div class="padding">When you add an archive to your favorites, you will see more images from that archive when you play.</div>
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
</script>

<script id="template-make-sound" type="text/x-jquery-tmpl">
    <audio id='make_sound' style="height: 0px;">
        <source src="${ogg_path}" type="audio/ogg">
        <source src="${mp3_path}" type="audio/mpeg">
    </audio>
</script>
