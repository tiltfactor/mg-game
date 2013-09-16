<div id="gamearea">
  <div id="no_js">Unfortunately we can't show the game as it relies on JavaScript which appears to be disabled on your browser.</div>
  <!-- Images from the database appear here --> 
  <div id="stage">
      <div id="header">
          <a href="#menu-left" class="hidden">left</a>
          <a href="#menu-right" class="right">Settings</a>
      </div>
      <div id="content">
          <div id="main_screen">
              WELCOME <span class="username"></span>
              <a href="#" location="new_game" class="button new_game">NEW GAME</a>
          </div>

          <div id="new_game" class="hidden">
              <h2>NEW GAME</h2>
              <div><a href="#" location="find_opponent">Opponent by User Name</a></div>
              <div><a href="#" location="make_challenge">Random Opponent</a></div>
              <div><a href="#" location="find_opponent">Facebook Friend</a></div>
          </div>

          <div id="find_opponent" class="hidden">
              <h2>ENTER A USER NAME</h2>
              <input type="text" name="opponent_name" class="opponent_name" />
              <a href="#" location="make_challenge" class="button play">PLAY</a>
          </div>

          <div id="game_settings" class="hidden">
              <h2>Game settings</h2>
              <div>Tell us what interests you and we will show you more images from those subjects when you play</div>
              <div>I'm interested in...</div>
              <div id="favorite_institutions">
                  When you add an archive to your favorites, you will see more images from that archive when you play.
              </div>
              <h3>Featured Archives</h3>
              <select>
                  <option>Browse All Archives</option>
              </select>
          </div>

          <div id="learn_more" class="hidden">
              <h2>Learn More</h2>
              <div>One Up is part of a suite of games from the
                  Metadata Games project. Metadata Games is a
                  Free and Open Source (FOSS) online game
                  system for gathering useful data on photo,
                  audio, and moving image artifacts. By playing,
                  you have a direct impact on the preservation
                  and accessibility of vital cultural heritage
                  collections for future generations.</div>
              <div>
                  Metadata Games is created by the Tiltfactor
                  Laboratory at Dartmouth College, with support
                  from the National Endowment for the
                  Humanities (NEH) and the American Council of
                  Learned Societies (ACLS).
              </div>
              <h3>METADATAGAMES</h3>
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
              <div>Add image slide left right</div>
          </div>

          <div id="account" class="hidden">
              <h2>Account</h2>
              <div>Update Account Settings</div>
              <div id="bookmarked_images">
                  <div>You do not have bookmarked Images.</div>
                  <div>Your Bookmarked Images</div>
              </div>
              <div>
                  <h3>Your Interests</h3>
                  TODO
              </div>
              <div>
                  <h3>Your Playlist</h3>
                  TODO
              </div>
          </div>
      </div>
      <nav id="menu-left">

      </nav>
      <nav id="menu-right">
          <ul>
              <li><a href="#" location="main_screen">PLAY</a></li>
              <li><a href="#" location="game_customize">CUSTOMIZE</a></li>
              <li><a href="#" location="how_to">HOW TO PLAY</a></li>
              <li><a href="#" location="learn_more">LEARN MORE</a></li>
              <li><a href="#" location="account">ACCOUNT</a></li>
          </ul>
      </nav>



    <div id="holder">
      <div id="image_container" class="clearfix"></div>
    </div>
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
<script id="template-challenges" type="text/x-jquery-tmpl">
    <div id="challenges">
        <div id="challenges_sent" class="list_challenges">
            <h3>YOUR TURN</h3>
            <div class="no_value hidden">You didn't challenge anyone!</div>
            {{each sent}}
            <div opponent_id="${opponent_id}">
                <div>${opponent_name}</div>
                <div class="delete">X</div>
            </div>
            {{/each}}
        </div>
        <div id="challenges_received" class="list_challenges">
            <h3>WAITING</h3>
            <div class="no_value hidden">Noone challenged you!</div>
            {{each received}}
            <div opponent_id="${opponent_id}">
                <div>${opponent_name}</div>
                <div class="delete">X</div>
            </div>
            {{/each}}
        </div>
    </div>
</script>
<script id="template-favorite_institutions" type="text/x-jquery-tmpl">
    <div id="list_institutions">
        {{each institution}}
        <div institution_id="${id}">
            ${name}
            <a href=""><img src="${logo}" width="25" height="25" /></a>
        </div>
        {{/each}}
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