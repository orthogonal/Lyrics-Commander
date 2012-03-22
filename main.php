<html>
	<head>
		<title>Lyrics Commander</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
		<script src="_js/jquery-1.7.js"></script>
		<script>
			$(document).ready(function(){
				newStanza();
			});
			
			function newStanza(){
				var maxVal = 0;
				$.post("globals.php", function(data) {maxVal = parseInt(data)});	//AJAX call to globals page, this will need to be updated once there are multiple globals.
				var stanzaID = (Math.floor(Math.random() * maxVal) + 1)				//Get a number from 0 to (maxVal - 1) and add 1, so it's from 1 to maxVal (a random stanzaID)
				$('#stanzaID').attr('value', stanzaID);								//Store the stanzaID in a hidden form field
				var pageVals = $('#hidden').serialize();							//Serialize the form so that it can be passed via AJAX.
				$.post("getstanza.php", pageVals, function(data){alert(data)});
			}
		</script>
	<head>
	<body>
		<div id="titlebar">
			<span id="titletext">Lyrics Commander</span>
		</div>
		
		<div id="lyricsdiv">
			<span id="lyrics">
				You think I'm eager to shut your eyes
				<br />Well, I'm sorry everybody knows you can't break me
				<br />With your gutter prose
				<br />
				<br />Voxtrot
				<br />The Start of Something
			</span>
			<br />
		</div>
		
		<form method="post" action="main.php">
			<div id="inputdiv">
				<input type="text" name="emotion" size="30" maxlength="20" id="inputbox"/>
				<input type="submit" value="Next" id="nextbutton"/>
			</div>
		</form>
		
		<div id="bottombar">
			<li>
				<a href="#statistics">Statistics</a>
				<a href="#settings">Settings</a>
				<a href="#logout">Logout</a>
				<a href="#about">About</a>
			</li>
		</div>
		
		<!-- This form holds values generated in the JavaScript functions that are passed by AJAX-->
		<form method="post" action="" id="hidden">
			<input type="hidden" name="stanzaID" id="stanzaID" value="0" />
		</form>
		
	</body>
</html>