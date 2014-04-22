<div id="gamearea">
  <div id="no_js">Unfortunately we can't show the game as it relies on JavaScript which appears to be disabled on your browser.</div>
  <!-- Images from the database appear here --> 
  <div id="logo"></div>
  <div id="wikipedia">
    <div class="tab-container">
      <div class="tab blue-tab"><span>Wikipedia</span></div>
      <div class="tab search-tab">
        <textarea name="search" cols="50" id="search" placeholder="Search Wikipedia"></textarea>
        <div class="blue-button" id="button-search"><a href="#" target="_blank">Search</a></div>
      </div>
    </div>
  </div>
  <div id="stage">
    <div id="zentag"> 
      <img src="<?php echo GamesModule::getAssetsUrl(); ?>/blshipstag/images/ships_tag_logo_shadow.png" alt="Ships Tag" />
    </div>
    <div class="top-interface">
      <div id="scores"></div>
    </div>
    <div id="holder">
      <div id="image_container" class="clearfix"></div>
      <img class="magnify" src="<?php echo GamesModule::getAssetsUrl(); ?>/blshipstag/images/magnify.png" alt="" />
    </div>
    <!-- user text field -->
    <div id="fieldholder" class="clearfix">   
      <form action="#"><textarea name="words" cols="50" id="words" placeholder="type, tags, here"></textarea></form> 
    </div>  
    <div id="box1"> 
      <div class="blue-button" id="button-play"><a href="#">Submit</a></div>
      <div class="blue-button" id="button-pass"><a href="#">Skip</a></div>
    </div>
    <div class="clear"> </div>
  </div> 
</div>
<div id="dark-footer">
  <a href="http://www.tiltfactor.org" title="visit tiltfactor.org"</a><img src="<?php echo GamesModule::getAssetsUrl(); ?>/blportraittag/images/logo_tiltfactor.png" alt="Tiltfactor" />
  <a href="http://www.Dartmouth.edu" title="visit Dartmouth.edu"</a><img src="<?php echo GamesModule::getAssetsUrl(); ?>/blportraittag/images/logo_dartmouth.png" alt="Dartmouth" />
  <a href="http://www.acls.org" title="visit acls.org"</a><img src="<?php echo GamesModule::getAssetsUrl(); ?>/blportraittag/images/logo_acls.png" alt="ACLS" />
  <a href="http://www.neh.gov/" title="visit neh.gov"</a><img src="<?php echo GamesModule::getAssetsUrl(); ?>/blportraittag/images/logo_neh.png" alt="National Endowment for the Humanities" />
</div>
<script id="template-scores" type="text/x-jquery-tmpl">
  <div class="total_turns">Turn: <span>${current_turn}</span>/<span>${turns}</span></div>
  <div class="current_score">Score: <span>${current_score}</span></div>
  <div class="how-to-play">How to Play</div>
</script>
<script id="template-turn" type="text/x-jquery-tmpl">
  <div style="text-align:center" class="clearfix">
    <a href="${url_full_size}" rel="zoom" title="${licence_info}"><img src="${url}" alt="game image" /></a>
  </div>
</script>
<script id="template-final-summary" type="text/x-jquery-tmpl">
  <div class="smallholder left" id="smallholder0"> 
    <a href="${url_full_size_1}" rel="zoom" title="${licence_info_1}"><img class="scoreimages" src="${url_1}" alt="game image" /></a>
  </div> 
  <div class="smallholder" id="smallholder1"> 
    <a href="${url_full_size_2}" rel="zoom" title="${licence_info_2}"><img class="scoreimages" src="${url_2}" alt="game image" /></a>
  </div> 
  <div class="smallholder left" id="smallholder2"> 
    <a href="${url_full_size_3}" rel="zoom" title="${licence_info_3}"><img class="scoreimages" src="${url_3}" alt="game image" /></a>
  </div> 
  <div class="smallholder" id="smallholder3"> 
    <a href="${url_full_size_4}" rel="zoom" title="${licence_info_4}"><img class="scoreimages" src="${url_4}" alt="game image" /></a>
  </div> 
</script>
<script id="template-final-summary-play-once" type="text/x-jquery-tmpl">
  <div style="text-align:center" class="clearfix">
    <a href="${url_full_size}" rel="zoom" title="${licence_info}"><img src="${url}" alt="game image" /></a>
  </div>
</script>
<script id="template-final-info" type="text/x-jquery-tmpl">
  <p class="final">Congratulations <b>${user_name}</b>, you scored <b>${current_score}</b> points in this game.</p>
</script>
<script id="template-final-tags-new" type="text/x-jquery-tmpl">
  <p class="tag-info">New tag(s): <b>'${tags_new}'</b> scoring <b>${tags_new_score}</b> point(s)</p>
</script>
<script id="template-final-tags-matched" type="text/x-jquery-tmpl">
  <p class="tag-info">Matched tag(s): <b>'${tags_matched}'</b> scoring <b>${tags_matched_score}</b> point(s).</p>
</script>
<script id="template-final-info-play-once" type="text/x-jquery-tmpl">
  You'll be redirected in <span id="remainingTime">${remainingTime}</span> seconds. <a href="${play_once_and_move_on_url}">Click here to proceed right away.</a></p>
</script>
<script id="template-info-modal-critical-error" type="text/x-jquery-tmpl">
  ${error} <p>Return to the <a href="${arcade_url}">arcade</a>.</p>
</script>
<script id="template-game-description" type="text/x-jquery-tmpl">
  <div id="game_description">
    <h2>How to Play</h2>
    <ol>
      <li>Describe the image as accurately as you can.</li> 
      <li>Use commas to separate phrases or individual words.</li>
      <li>Hit enter or click Submit when done.</li>
      <li>Click Skip to skip an image.</li>
      <li>Click on the image to see a full-screen version.</li>
    </ul>
  </div>
</script>
