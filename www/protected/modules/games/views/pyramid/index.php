<div id="splash_home">
    <input type="hidden" id="game_uri" value="<?php echo Yii::app()->baseUrl; ?>/index.php/games/Pyramid/" />
    <div id="stage">
        <div id="header" class="group">
            <a href="#menu-left" class="header_mm_left">
                <span class="words hidden top_btn">Words</span>
                <span class="back hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/back.png" /></span>
            </a>
            <a href="#menu-right" class="right setting"></a>
        </div>
        <div class="content" id="content">
            <div class="main_screen" id="main_screen">
                <div class="top"></div>
                <div class="splash_logo">
                    <!-- Replace text with logo graphic -->
                    <img src="<?php echo $asset_url; ?>/images/splash_logo.png" />
                    <!--<div class="spacial_font with_borders logo_text">PYRAMID TAG</div>-->

                    <div id="splash_title">
                    </div>
                    <div class="spacial_font size_20 div_center logo_subtext text_left">We showed this image to our panel of experts and had each of them describe it in one word.  How many of our experts' words can you match in 2 minutes?!</div>
                </div>
                <div class="text_left">
                    <a href="<?php echo $game_url; ?>/Pyramid/play" class="hover_btn">
                        <img src="<?php echo $asset_url; ?>/images/pyramid-start-btn_off.png" class="middle_height" />
                        <span style="display: none;"><img src="<?php echo $asset_url; ?>/images/pyramid-start-btn_on.png" class="middle_height" /></span>
                    </a>
                </div>
            </div>

            <div id="login" class="text-center index_screen hidden">
                <div class="logo"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/pyramid/images/splash_logo.png" /></div>
                <div class="button">
                    <input class="input" type="text" autocapitalize="off" autocorrect="off" autocomplete="off" id="username" name="username" placeholder="Username" tabindex="1" />
                </div>
                <div class="button">
                    <input class="input" type="password" autocapitalize="off" autocorrect="off" autocomplete="off" id="password" name="password" placeholder="Password" tabindex="2" />
                </div>
                <div class="button">
                    <input id="rememberMe" type="checkbox" value="1" name="rememberMe" style="width:20px; height: 20px;" tabindex="3">
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
                <div id="facebook"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/pyramid/images/facebook.png" /></div>
            </div>

            <div id="register" class="text-center index_screen hidden">
                <div class="logo"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/pyramid/images/splash_logo.png" /></div>
                <div class="button">
                    <input class="input" type="text" autocapitalize="off" autocorrect="off" autocomplete="off" id="username" name="username" placeholder="Choose Username" value="" tabindex="1" />
                </div>
                <div class="button">
                    <input class="input" type="password" autocapitalize="off" autocorrect="off" autocomplete="off" id="password" name="password" placeholder="Choose Password" value="" tabindex="2" />
                </div>
                <div class="button">
                    <input class="input" type="password" autocapitalize="off" autocorrect="off" autocomplete="off" id="verifyPassword" name="verifyPassword" placeholder="Verify Password" value="" tabindex="3" />
                </div>
                <div class="button">
                    <input class="input" type="email" autocapitalize="off" autocorrect="off" autocomplete="off" id="email" name="email" placeholder="Choose E-mail" tabindex="4" value="" />
                </div>
                <div class="button">
                    <a href="#" id="btn_register" class="button login"><span>START PLAYING</span></a>
                </div>
            </div>

            <div id="how_to" class="hidden">
                <h2>HOW TO PLAY</h2>
                <div class="padding">
                    This is just a custom text that need to be verified.
                </div>
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

        </div>
        <nav id="menu-left">
        </nav>
        <nav id="menu-right" style="visibility: hidden;">
            <ul>
                <li class="back_blue row"><div><a href="#" location="main_screen"><span>HOME</span></a></div></li>
                <li class="back_blue row hidden" id="mmenuPlay"><div><a href="<?php echo Yii::app()->baseUrl; ?>/index.php/games/Pyramid/play/"><span>PLAY</span></a></div></li>
                <li class="back_blue row touch" id="mmenuRegister"><div><a href="#" location="register"><span>REGISTER</span></a></div></li>
                <li class="back_blue row touch" id="mmenuLogin"><div><a  href="#" location="login"><span>LOGIN</span></a></div></li>
                <li class="back_blue row"><div><a href="#" location="how_to"><span>HOW TO PLAY</span></a></div></li>
                <li class="back_blue row"><div><a href="#" location="learn_more"><span>LEARN MORE</span></a></div></li>
                <li class="back_blue row hidden touch" id="mmenuLogout"><div><a href="#" location="logout"><span>LOGOUT</span></a></div></li>
            </ul>
        </nav>
    </div>
</div>
