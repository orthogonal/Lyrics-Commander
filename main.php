<?php
	require_once "db_login.php";
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server); 
	$loggedin = false;
	$userid = -1;
	$cookieinfo = explode("%", $_COOKIE['main']);
	if ($cookieinfo[0] != null){
		$loggedin = true;
		$userid = $cookieinfo[0];
	}
	else{
		$userid = 1;				//CHANGE THIS LATER TO GO BACK TO HOME IF THE USER IS NOT LOGGED IN
	}
	$query = "SELECT * FROM User WHERE UserID = $userid";
	$result = mysql_query($query) or DIE(mysql_error());
	$row = mysql_fetch_row($result);
	$username = "'" . $row[1] . "'";
	$email = "'" . $row[3] . "'";
?>

<html>
	<head>
		<title>Lyrics Commander</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
		<script src="_js/jquery-1.7.js"></script>
		<script>
			var selections 	= new Array(20);
			var userID		= <?php echo $userid; ?>;
			var username 	= <?php echo $username; ?>;
			var email		= <?php echo $email; ?>;
			var stanzaID 	= -1
			var buttonsDown	= 0
			
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
						buttonsDown++;
					}
					else{
						$(this).css('background-color', 'white');
						selections[clickedID - 1] = 0;
						buttonsDown--;
					}
					if (buttonsDown == 0){
						$("#nextbutton").attr("disabled", "disabled");
						$("#nextbutton").css("color", "#A3A3A3");
					}
					else if (buttonsDown == 1){
						$("#nextbutton").removeAttr("disabled");
						$("#nextbutton").css("color", "#000000");
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
					maxVal = parseInt(data);										//AJAX call to globals page, this will need to be updated once there are multiple globals.
					tempstanzaID = stanzaID;
					stanzaID = (Math.floor(Math.random() * maxVal) + 1);			//Get a number from 0 to (maxVal - 1) and add 1, so it's from 1 to maxVal (a random stanzaID)
					$('#stanzaID').attr('value', stanzaID);							//Store the stanzaID in a hidden form field
					var pageVals = $('#hidden').serialize();						//Serialize the form so that it can be passed via AJAX.
					$.post("getstanza.php", pageVals, function(data){
						var values = data.split("&");
						$('#lyrics').html(values[0]);
						if (count > 0){
							$('#artist').text(lastArtist);
							$('#song').text(lastSong);
							$('#album').text(lastAlbum);
							$(".choices").css("background-color", "white");
							$("#nextbutton").attr("disabled", "disabled");
							$(".choices").attr("disabled", "disabled");
							$("#nextbutton").css("color", "#A3A3A3");
							
							var tuples = 0;
							var query = "INSERT INTO Rating(StanzaID, WordID, UserID) VALUES";
							for (i = 0; i < 20; i++){
								if (selections[i] == 1){
									var wordID = i + 1
									tuples++;	
									if (tuples == 1)
										query += "(" + tempstanzaID + ", " + wordID + ", " + userID + ")"
									else
										query += ", (" + tempstanzaID + ", " + wordID + ", " + userID + ")"
								}	
							}
							if (tuples != 0){
								$('#query').attr('value', query);
										query = $('#hiddentag').serialize();
										$.post("addtag.php", query, function(data){
											if (data != "success") 
												alert("There has been an error, please e-mail admin@lyricscommander.com\n" + data);
											$(".choices").removeAttr("disabled");
											buttonsDown = 0;
								});
							}
							else alert("None selected");
						}
						lastArtist = values[4];
						lastSong = values[1];
						lastAlbum = values[2];
						count++;
						for (i = 0; i < 20; i++){
							selections[i] = 0;
						}
					});				
				});
			}	
		
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
					<input type="submit" value="Next" disabled="disabled" id="nextbutton"/>
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
		
		<form method="post" action="" id="hiddentag">
			<input type="hidden" name="query" id="query" value="" />
		</form>
		
	</body>
</html>