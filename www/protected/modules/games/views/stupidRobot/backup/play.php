
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

			<!-- Images from the database appear here -->

					<div id="imageContainer">
						<center><img src="" /></center>
					</div>

			<canvas id="canvas" width="342" height="212"> </canvas> 


			
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