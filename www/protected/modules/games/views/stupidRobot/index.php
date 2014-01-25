<!DOCTYPE html>
<html class="no-js">
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
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
			
        <!-- Add your site or application content here -->
               			<div id="loading">loading!</div>

        <div class="manifest" id="tree">
        	<img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidRobot/images/Bitmap3.jpg" />
         	<img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidRobot/images/Bitmap7.jpg" />
         	<img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidRobot/images/Bitmap5.jpg" />
         	<img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidRobot/images/Bitmap6.jpg" />
         	<img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidRobot/images/FlashAICB.png" />
         	<img src="<?php echo GamesModule::getAssetsUrl(); ?>/stupidRobot/images/tree.jpg" />
        </div>
              			
	       	     <canvas id="canvas" width=960 height=180></canvas>
       			<div id="container">
					<span id="bootButton" class="clearfix button">BOOT<br>GAME</span>
	       	        <h1 class="clearfix">STUPID ROBOT</h1>
					<p class="scrollText">&nbsp;</p>
					<p class="scrollText">&nbsp;</p>
					<p class="scrollText">&nbsp;</p>
					<p class="scrollText">&nbsp;</p>
					<p class="scrollText">&nbsp;</p>
					<p class="scrollText">&nbsp;</p>
					<p id="lastScrollText">&nbsp;</p>
					<br>
					<p class="scrollText">&nbsp;</p>
			</div>


	    <div id="loadgame">
    	 <input type="hidden" id="game_assets_uri" value="<?php echo GamesModule::getAssetsUrl() . '/stupidRobot/'; ?>" />
    	 <input type="hidden" id="loopsound" value="<?php echo GamesModule::getAssetsUrl() . '/pyramid/'; ?>" />
    	 
		<form>
			<button class="button" id="button-loop-1" type="button" value="1">sound</button>
		</form>
    
         <div id="game">
	    	 <div id="loading">loading!</div>
	
	        <!--[if lt IE 8]>
	            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	        <![endif]-->
	
	        <!-- Add your site or application content here -->
			<div id="container">
				<div class="leftBox clearfix2">
					<span id="timer"></span>
					<span id="gameMessage">STAND BY</span>
					<input type=text id="inputArea" class="underlinedText clearfix2"></input>
					<!-- span id = "underline">jack</span-->
					<div id="inputFields" class="clearfix2">
						<span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span>
						<a class="button" id="pass">pass</a>
					</div>
					<canvas class="clearfix" id="canvas" width="342" height="212"> </canvas> 
				</div>
				<div class="rightBox" id="imageContainer">
					<center><img src="" /></center>
				</div>
			</div>
        </div>
		
		
		<div id="score">

			<div id="container">
				<div class="leftBox clearfix">
					<span id="gameMessage">YOU TAUGHT STUPID ROBOT 6 WORDS<br>STUPID ROBOT IS SOMEWHAT SMARTER!</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><span class="underlinedText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<br><a class="button" id="reboot">REBOOT</a>
				</div>
				<div class="rightBox" id="imageContainer">
					<canvas class="clearfix" id="canvas" width="1000" height="1000"> </canvas> 
				</div>
			</div>
	    </div>
	    
	    </div>
			
       
    </body>
         <input type="hidden" id="game_assets_uri" value="<?php echo GamesModule::getAssetsUrl() . '/stupidRobot/'; ?>" />
    	 <input type="hidden" id="loopsound" value="<?php echo GamesModule::getAssetsUrl() . '/pyramid/'; ?>" />

    <script id="template-turn" type="text/x-jquery-tmpl">
        <div style="text-align:center">
            <img src="${url}" alt="game image" id="image_to_tag" style="width: auto !important; height: auto !important; "/>
        </div>
    </script>
    
    <script id="template-more-info" type="text/x-jquery-tmpl">
        <a href="${url}">Click here to learn more about ${name}</a>
    </script>
</html>	
