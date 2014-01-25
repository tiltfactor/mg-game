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
    <body id="gameContent">
    	 <div id="loading">loading!</div>

        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
		<div id="container">
			
			<div class="leftBox clearfix">
				<div id="timer"></div>
				<span id="gameMessage">STAND BY</span>
				<input type=text id="inputArea" class="clearfix"></input>
				<div id="inputFields" class="clearfix">
				<span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span>
				<a class="button">pass</a>
				</div>
			</div>

			<div id="imageContainer">
				<center></center><img src="images_TEMP/image.jpg" /></center>
			</div>
		<canvas id="canvas" width="342" height="212"> </canvas> 

			
			
		</div>
		<script src="http://code.createjs.com/easeljs-0.5.0.min.js"></script>
		<script src="http://code.createjs.com/tweenjs-0.3.0.min.js"></script>
		<script src="http://code.createjs.com/movieclip-0.5.0.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
		<script src="js/animation_gameplay.js"></script>
        <script src="js/game.js"></script>
    </body>
</html>
