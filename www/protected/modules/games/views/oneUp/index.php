<div id="gamearea">
    <input type="hidden" id="game_assets_uri" value="<?php echo GamesModule::getAssetsUrl(); ?>" />
    <input type="hidden" id="game_uri" value="<?php echo Yii::app()->baseUrl; ?>" />
    <div id="no_js">Unfortunately we can't show the game as it relies on JavaScript which appears to be disabled on your browser.</div>
    <!-- Images from the database appear here -->
    <div id="stage">
        <div id="header" class="group">
            <a href="#menu-left" class="header_mm_left">
                <span class="back hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/back.png" /></span>
            </a>
            <a href="#menu-right" class="right hidden"></a>
        </div>
        <div id="content" class="group">
            <div id="main_screen" class="index_screen">
                <div class="text-center">
                    <div><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/logo.png" /></div>
                    <div class="button">
                       <input type="text" placeholder="Username" />
                    </div>
                    <div class="button">
                       <input type="password" placeholder="Password" />
                    </div>
                    <div class="button">
                        <a href="#" location="login" class="button login"><span>LOGIN</span></a>
                    </div>
                    <div class="button">
                        or
                    </div>
                    <div class="button">
                        <a href="#" location="new_user" class="button new_user"><span>GET A USERNAME</span></a>
                    </div>
                    <img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/facebook.png" />
                </div>
            </div>

            <div id="account" class="hidden">
                <h2>Account</h2>
                <div class="back_blue row"><a href="#" location="account_settings">UPDATE ACCOUNT SETTINGS</a></div>
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
    </div>
</div>

<script id="template-account_playlist" type="text/x-jquery-tmpl">
    {{each play_lists}}
    {{if isBanned != true}}
    <div institution_id="${id}" class="back_yellow row">
        <span class="institution">${name}</span>
        <div class="delete right"></div>
    </div>
    {{/if}}
    {{/each}}
</script>

<script id="template-make-sound" type="text/x-jquery-tmpl">
    <audio id='make_sound' style="height: 0px;">
        <source src="${ogg_path}" type="audio/ogg">
        <source src="${mp3_path}" type="audio/mpeg">
    </audio>
</script>