<html>
	<head>
		<title>Lyrics Commander</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
		<script src="_js/jquery-1.7.js"></script>
		<script>
			var selections = new Array(20);
			$(document).ready(function(){
				newStanza();
				for (i = 0; i < 20; i++)
					selections[i] = 0;
					
				
				$('#nextinput').submit(function(evt){		//Get a new stanza with AJAX without reloading the page
					evt.preventDefault();					//Right now, this doesn't write ratings to the database
					newStanza();
				});
				
				$('.choices').click(function(evt){
					evt.preventDefault();
					var clickedID = $(this).attr('id');
					clickedID = clickedID.substring(6, clickedID.length);
					clickedID = parseInt(clickedID);
					if (selections[clickedID - 1] == 0){
						$(this).css('background-color', '#B6F0E2');
						selections[clickedID - 1] = 1;
					}
					else{
						$(this).css('background-color', 'white');
						selections[clickedID - 1] = 0;
					}
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
					for (i = 0; i < 20; i++){
						selections[i] = 0;
					}
					$(".choices").css("background-color", "white");
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
		
		<button id="button1" class="choices">Amused</button>
		<button id="button2" class="choices">Angry</button>
		<button id="button3" class="choices">Concerned</button>
		<button id="button4" class="choices">Confident</button>
		<button id="button5" class="choices">Cynical</button>
		<button id="button6" class="choices">Depressed</button>
		<button id="button7" class="choices">Energetic</button>
		<button id="button8" class="choices">Frustrated</button>
		<button id="button9" class="choices">Happy</button>
		<button id="button10" class="choices">Inspired</button>
		<button id="button11" class="choices">Jealous</button>
		<button id="button12" class="choices">Lonely</button>
		<button id="button13" class="choices">Optimistic</button>
		<button id="button14" class="choices">Relaxed</button>
		<button id="button15" class="choices">Restless</button>
		<button id="button16" class="choices">Sad</button>
		<button id="button17" class="choices">Solemn</button>
		<button id="button18" class="choices">Superior</button>
		<button id="button19" class="choices">Thoughtful</button>
		<button id="button20" class="choices">Touched</button>
		<br />
		<br />
			<form method="post" action="main.php" id="nextinput">
					<input type="submit" value="Next" id="nextbutton"/>
			</form>
			<br />
			<br />
			<br />
			<br />
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