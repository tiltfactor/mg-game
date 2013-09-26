<div id="gamearea">
  <div id="no_js">Unfortunately we can't show the game as it relies on JavaScript which appears to be disabled on your browser.</div>
  <!-- Images from the database appear here --> 
  <div id="stage">
      <div id="header" class="group">
          <a href="#menu-left" class="header_mm_left">
              <span class="words hidden top_btn">Words</span>
              <span class="back hidden"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/back.png" /></span>
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
              <div class="padding text-center"><input type="text" id="input_opponent" name="opponent_name" class="opponent_name" /></div>
              <div class="margin_topBottom"><a href="#" location="make_challenge" class="big_button play"><span>PLAY</span></a></div>
          </div>

          <div id="game_screen" class="hidden">

          </div>

          <div id="final_screen" class="hidden">

          </div>

          <div id="game_customize" class="hidden">
              <h2>CUSTOMIZE YOUR GAME</h2>
              <div class="padding">Share your interests and you might see more images with those subjects!</div>
              <div class="new_interest text-center"><input id="new_interest" type="text" placeholder="I'm interested in..." /></div>
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
                  <div number="1" class="text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_1.jpg" /></div>
                  <div number="2" class="hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_2.jpg" width="320" height="502" /></div>
                  <div number="3" class="hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_3.jpg" width="320" height="502" /></div>
                  <div number="4" class="hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_4.jpg" width="320" height="502" /></div>
                  <div number="5" class="hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_5.jpg" width="320" height="502" /></div>
                  <div number="6" class="hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_6.jpg" width="320" height="502" /></div>
                  <div number="7" class="hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_7.jpg" width="320" height="502" /></div>
                  <div number="8" class="hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_8.jpg" width="320" height="502" /></div>
                  <div number="9" class="hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_9.jpg" width="320" height="502" /></div>
                  <div number="10" class="hidden text-center"><img src="<?php echo GamesModule::getAssetsUrl(); ?>/oneup/images/help/help_10.jpg" width="320" height="502" /></div>
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
      <nav id="menu-right">
          <ul>
              <li class="back_blue row"><a href="#" location="main_screen"><span>PLAY</span></a></li>
              <li class="back_blue row"><a href="#" location="game_customize"><span>CUSTOMIZE</span></a></li>
              <li class="back_blue row"><a href="#" location="how_to"><span>HOW TO PLAY</span></a></li>
              <li class="back_blue row"><a href="#" location="learn_more"><span>LEARN MORE</span></a></li>
              <li class="back_blue row"><a href="#" location="account"><span>ACCOUNT</span></a></li>
          </ul>
      </nav>
  </div>
</div>

<script id="template-word_screen" type="text/x-jquery-tmpl">
    <div class="row back_dark_gray">
        <span class="round">ROUND <span>${current_level}</span></span>
        <div class="right header_scores">
            <div class="you">You <span>${score}</span></div>
            <div class="opponent">${opponentName} ${opponentScore}</div>
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
    <div class="row back_dark_gray">
        <span class="round">${game_result}</span>
        <div class="right header_scores">
            <div class="you">You <span>${score}</span></div>
            <div class="opponent">${opponentName} ${opponentScore}</div>
        </div>
    </div>
    <h4 class="text-center">${congratulation_text}</h4>
    <br/>
    <div>
        <a href="#" opponent="${opponentName}" class="big_button rematch"><span>REMATCH</span></a>
    </div>
    <br/>
    <br/>

    <div class="text-center">
        <img src="${media.thumbnail}" /> <br/><br/>
        <span class="bookmark_image top_btn">Bookmark this image</span><br/><br/>
    </div>
    <h3>${opponentName} SAID <span>ROUND 1</span></h3>
    {{html opponent.round_1}}
    <h3><span>ROUND 2</span></h3>
    {{html opponent.round_2}}
    <h3><span>ROUND 3</span></h3>
    {{html opponent.round_3}}
    <h3>YOU SAID <span>ROUND 1</span></h3>
    {{html you.round_1}}
    <h3><span>ROUND 2</span></h3>
    {{html you.round_2}}
    <h3><span>ROUND 3</span></h3>
    {{html you.round_3}}
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
            <span class="institution">${name}</span>
            <div class="delete right"></div>
        </div>
        {{/if}}
    {{/each}}
</script>

<script id="template-account_interest" type="text/x-jquery-tmpl">
    {{each interests}}
    <div interest_id="${id}" class="back_yellow row">
        ${interest}
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
                <span class="start_game" type="show_final">GAME WITH <span class="username">${opponentName}</span> FINISHED</span>
            </div>
            {{/each}}
            <div class="no_value hidden">Challenge anyone. Start to play!</div>
            {{each received}}
            <div opponent_id="${id}" playedGameId="" class="back_yellow row">
                <span class="start_game" type="accept_challenge"><span class="username">${username}</span> CHALLENGED YOU</span>
                <div class="delete right"></div>
            </div>
            {{/each}}

            {{each your_turn}}
            <div opponent_id="${opponentId}" playedGameId="${playedGameId}" class="back_yellow row">
                <span class="start_game" type="game">GAME WITH <span class="username">${opponentName}</span></span>
                <div class="delete right"></div>
            </div>
            {{/each}}

        </div>
        <div id="challenges_sent" class="list_challenges">
            <h3>WAITING</h3>
            <div class="no_value hidden">Noone waits for you!</div>
            {{each sent}}
            <div opponent_id="${id}" playedGameId="" class="back_gray row">
                GAME WITH ${username}
                <div class="delete right"></div>
            </div>
            {{/each}}

            {{each waiting_turn}}
            <div opponent_id="${opponentId}" playedGameId="${playedGameId}" class="back_gray row">
                GAME WITH ${opponentName}
                <div class="delete right"></div>
            </div>
            {{/each}}
        </div>
    </div>
</script>

<script id="template-game_screen" type="text/x-jquery-tmpl">
    <input type="hidden" id="" />
    <div class="row back_dark_gray">
        <span class="round" status="playing" opponent="${opponentStatus}">ROUND ${current_level}</span>
        <div class="right header_scores">
            <div class="you">You <span>${turn.score}</span></div>
            <div class="opponent">${opponentName} ${turn.opponentScore}</div>
        </div>
    </div>
    <div class="main_gray">
        {{each(i, media_item) turn.media}}
        <img src="${media_item.imageFullSize}" />
        {{/each}}
    </div>
    <div class="words">
        {{each current_turn_tag}}
            {{html div}}
        {{/each}}

        {{for(i = num_words; i < 3; i++)}}
            <div class="small_row blank_bar">ADD A WORD</div>
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