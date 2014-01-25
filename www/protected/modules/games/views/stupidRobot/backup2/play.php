
    <body id="gameContent" class="gameContent">
         <div id="game">
	    	 <div id="loading">loading!</div>
	
	        <!--[if lt IE 8]>
	            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	        <![endif]-->
	
	        <!-- Add your site or application content here -->
			<div id="container">
				<div class="leftBox clearfix">
					<span id="timer"></span>
					<span id="gameMessage">STAND BY</span>
					<input type=text id="inputArea" class="underlinedText clearfix"></input>
					<div id="inputFields" class="clearfix">
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
	    	<!-- <div id="loading">loading!</div>-->
	
	        <!--[if lt IE 8]>
	            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	        <![endif]-->
	
	        <!-- Add your site or application content here -->
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
    </body>

    <script id="template-turn" type="text/x-jquery-tmpl">
        <div style="text-align:center">
            <img src="${url}" alt="game image" id="image_to_tag" style="width: auto !important; height: auto !important; "/>
        </div>
    </script>
    
    <script id="template-more-info" type="text/x-jquery-tmpl">
        <a href="${url}">Click here to learn more about ${name}</a>
    </script>