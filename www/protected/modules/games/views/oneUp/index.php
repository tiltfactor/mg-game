<div id="gamearea">
  <div id="no_js">Unfortunately we can't show the game as it relies on JavaScript which appears to be disabled on your browser.</div>
  <!-- Images from the database appear here --> 
  <div id="stage">
      <div id="header" class="group">
          <a href="#menu-left">
              <span class="words hidden">Words</span>
              <span class="back hidden">Back</span>
          </a>
          <a href="#menu-right" class="right setting"></a>
      </div>
      <div id="content" class="group">
          <div id="main_screen">
              <div class="back_black header">
                  <div class="group title">WELCOME <span class="username"></span></div>
                  <div>
                      <a href="#" location="new_game" class="big_button new_game"><span>NEW GAME</span></a>
                  </div>
              </div>
          </div>

          <div id="new_game" class="hidden">
              <h2>NEW GAME</h2>
              <div class="back_blue row"><a href="#" location="find_opponent">Opponent by User Name</a></div>
              <div class="back_blue row"><a href="#" location="make_challenge">Random Opponent</a></div>
              <div class="back_blue row"><a href="#" location="find_opponent">Facebook Friend</a></div>
          </div>

          <div id="find_opponent" class="hidden">
              <h2>ENTER A USER NAME</h2>
              <div><input type="text" name="opponent_name" class="opponent_name" /></div>
              <a href="#" location="make_challenge" class="big_button play"><span>PLAY</span></a>
          </div>

          <div id="game_screen" class="hidden">

          </div>

          <div id="game_customize" class="hidden">
              <h2>CUSTOMIZE YOUR GAME</h2>
              <div class="padding">Share your interests and you might see more images with those subjects!</div>
              <div class="text-center"><input type="text" placeholder="I'm interested in..." /></div>
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
              need to load template here
          </div>

          <div id="how_to" class="hidden">
              <h2>How to Play</h2>
              <div id="image_gallery">
                  <div number="1"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_1.jpg" /></div>
                  <div number="2" class="hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_2.jpg" width="320" height="502" /></div>
                  <div number="3" class="hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_3.jpg" width="320" height="502" /></div>
                  <div number="4" class="hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_4.jpg" width="320" height="502" /></div>
                  <div number="5" class="hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_5.jpg" width="320" height="502" /></div>
                  <div number="6" class="hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_6.jpg" width="320" height="502" /></div>
                  <div number="7" class="hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_7.jpg" width="320" height="502" /></div>
                  <div number="8" class="hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_8.jpg" width="320" height="502" /></div>
                  <div number="9" class="hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_9.jpg" width="320" height="502" /></div>
                  <div number="10" class="hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_10.jpg" width="320" height="502" /></div>
              </div>
          </div>

          <div id="account" class="hidden">
              <h2>Account</h2>
              <div class="back_blue row"><a href="#" location="account_settings">UPDATE ACCOUNT SETTINGS</a></div>
              <div id="account_info">
              </div>
          </div>
      </div>
      <nav id="menu-left">

      </nav>
      <nav id="menu-right">
          <ul>
              <li class="back_blue row"><a href="#" location="main_screen"><span>PLAY</span></a></li>
              <li class="back_blue row"><a href="#" location="game_customize"><span>CUSTOMIZE</span></a></li>
              <li class="back_blue row"><a href="#" location="how_to"><span>HOW TO PLAY</span></a></li>
              <li class="back_blue row"><a href="#" location="learn_more"><span>LEARN MORE</span></a></li>
              <li class="back_blue row"><a href="#" location="account"><span>ACCOUNT</span></a></li>
          </ul>
      </nav>
    <!-- user text field -->
    <div id="fieldholder" class="clearfix">   
      <form action="#"><textarea name="words" cols="50" rows="8" id="words"></textarea></form> 
    </div>  
    <div id="scores"></div>
    <div id="licences"></div>
    <div id="more_info"></div>
    <div id="words_to_avoid"></div>
    <div id="partner-waiting"></div>
  </div>
</div>


<!--<div>
    <h3 class="padding">Your Playlist</h3>
    TODO
</div>-->

<script id="template-account_playlist" type="text/x-jquery-tmpl">
    <div id="play_lists">
        <h3>YOUR PLAYLIST</h3>
        {{each play_lists}}
            {{if isBanned != true}}
            <div opponent_id="${id}" class="back_yellow row">
                ${name}
                <div class="delete right"></div>
            </div>
            {{/if}}
        {{/each}}
    </div>
</script>

<script id="template-account_interest" type="text/x-jquery-tmpl">
    <div id="interests">
        <h3>YOUR INTERESTS</h3>
        {{each interests}}
        <div opponent_id="${id}" class="back_yellow row">
            ${interest}
            <div class="delete right"></div>
        </div>
        {{/each}}
    </div>
</script>

<script id="template-account_bookmark" type="text/x-jquery-tmpl">
    <div id="bookmarks" >
        <h3 class="no_margin">YOUR BOOKMARKED IMAGES</h3>
        <div class="group" >
            <div class="bookmark">
            {{each bookmarked}}
                <img src="${thumbnail}" class="show_big" scaled="${scaled}" />
            {{/each}}
            </div>
        </div>
    </div>
</script>

<script id="template-challenges" type="text/x-jquery-tmpl">
    <div id="challenges">
        <div id="challenges_received" class="list_challenges">
            <h3 class="no_margin">YOUR TURN</h3>
            <div class="no_value hidden">Challenge anyone. Start to play!</div>
            {{each received}}
            <div opponent_id="${id}" class="back_yellow row">
                <span class="start_game" type="accept_challenge"><span class="username">${username}</span> CHALLENGED YOU</span>
                <div class="delete right"></div>
            </div>
            {{/each}}

            {{each your_turn}}
            <div opponent_id="${id}" class="back_yellow row">
                <span class="start_game" type="game">GAME WITH <span class="username">${username}</span></span>
                <div class="delete right"></div>
            </div>
            {{/each}}

        </div>
        <div id="challenges_sent" class="list_challenges">
            <h3>WAITING</h3>
            <div class="no_value hidden">Noone waits for you!</div>
            {{each sent}}
            <div opponent_id="${id}" class="back_gray row">
                GAME WITH ${username}
                <div class="delete right"></div>
            </div>
            {{/each}}

            {{each waiting_turn}}
            <div opponent_id="${id}" class="back_gray row">
                GAME WITH ${username}
                <div class="delete right"></div>
            </div>
            {{/each}}
        </div>
    </div>
</script>

<script id="template-game_screen" type="text/x-jquery-tmpl">
    <div class="row back_yellow">
        ROUND ${turn}
        <div class="right">
            <div>You ${score}</div>
            <div>${opponent_name} ${opponentScore}</div>
        </div>
    </div>
    <img src="${media.imageScaled}" />
    <div class="words">
        {{each(j, subItem) tags.word}}
            <div class="back_gray row">
                <span>${subItem.point}</span>
                ${subItem.tag}
                <div>$(subItem.comment)</div>
            </div>
        {{/each}}

        {{for(i = tags.num_words; i < 3; i++)}}
            <div class="row"><input type="text" placeholder="Add a word" /></div>
        {{/for }}
    </div>

</script>

<script id="template-favorite_institutions" type="text/x-jquery-tmpl">
    <div id="listing">
        <div class="padding">When you add an archive to your favorites, you will see more images from that archive when you play.</div>
        <div id="favorite_institutions"  class="padding" align="center">
            <div id="list_institutions" class="group">
                {{each all_institution}}
                <div institution_id="${id}" class="left">
                    <a href="" title="${name}"><img class="institution_logo" src="${logo}" width="70" height="70" /></a>
                </div>
                {{/each}}
            </div>
        </div>
    </div>
</script>
<script id="template-final-summary" type="text/x-jquery-tmpl">
</script>
<script id="template-make-sound" type="text/x-jquery-tmpl">
    <audio id='make_sound' style="height: 0px;">
        <source src="${ogg_path}" type="audio/ogg">
        <source src="${mp3_path}" type="audio/mpeg">
    </audio>
</script>