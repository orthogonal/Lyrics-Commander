<html>
	<head>
		<title>Lyrics Commander</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
		<script src="_js/jquery-1.7.js"></script>
		<script>
			$(document).ready(function(){
				newStanza();
				
				$('#nextinput').submit(function(evt){		//Get a new stanza with AJAX without reloading the page
					evt.preventDefault();					//Right now, this doesn't write ratings to the database
					newStanza();
				});
			});
			
			var count = 0;
			var lastArtist = "";
			var lastSong = "";
			var lastAlbum = "";
			
			function newStanza(){
				var maxVal = 0;
				$.post("globals.php", function(data){
				maxVal = parseInt(data)												//AJAX call to globals page, this will need to be updated once there are multiple globals.
				var stanzaID = (Math.floor(Math.random() * maxVal) + 1)				//Get a number from 0 to (maxVal - 1) and add 1, so it's from 1 to maxVal (a random stanzaID)
				$('#stanzaID').attr('value', stanzaID);								//Store the stanzaID in a hidden form field
				var pageVals = $('#hidden').serialize();							//Serialize the form so that it can be passed via AJAX.
				$.post("getstanza.php", pageVals, function(data){
					var values = data.split("&");
					$('#lyrics').html(values[0]);
					if (count > 0){
						$('#artist').text(lastArtist);
						$('#song').text(lastSong);
						$('#album').text(lastAlbum);
						}
					lastArtist = values[4];
					lastSong = values[1];
					lastAlbum = values[2];
					count++;
				});
					
						/*	In conclusion:
		0:  Stanza text
		1:  Song name
		2:  Album
		3:  Album URL
		4:  Artist name
		5:  Artist URL
		6:  Artist biography
		Delimiter is "&"
		Output will have "&?" in it if there is an error, followed by the error, with nothing after that.
		*/
				});
				
			}
		</script>
	<head>
	<body>
		<div id="titlebar">
			<span id="titletext">Lyrics Commander</span>
		</div>
		
		<table id="maintable">
		<tr>
		<td id="lyricstd">
		<div id="lyricsdiv">
			<span id="lyrics">
				
			</span>
		<br />
		</div>
		</td>
		
		<td id="choicetd">
		<div id="choicediv">
			<span id="lastsong">
				Last Song:
			</span>
			<br />
			<span id="artist">
				
			</span>
			<br />
			<span id="song">
				
			</span>
			<br />
			<span id="album">
				
			</span>
		</div>
		</td>
		</tr>
		</table>
		
		<form method="post" action="main.php" id="nextinput">
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