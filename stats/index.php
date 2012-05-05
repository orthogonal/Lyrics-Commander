<?php
	//Joe Adams
	//Statistics.php
	require_once "../db_login.php";
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
		header( 'Location: http://www.lyricscommander.com' ) ;	//If they arent logged in then go to the home page
	}
	$query = "SELECT * FROM User WHERE UserID = $userid";
	$result = mysql_query($query) or DIE(mysql_error());
	$row = mysql_fetch_row($result);
	$username = $row[1];
	//all static queries are in static_queries.php
	include("static_queries.php");
	//all dynamic queries are in dynamic_queries.php
	include("dynamic_queries.php");
 ?>
<html>
	<head>
		<title><?php echo $username; ?>'s Statistics</title>
			<link rel="stylesheet" type="text/css" href="stats_style.css" />
				<script src="../_js/jquery-1.7.js"></script>
				<script>
					$(document).ready(function(){
						//hide the emotions select
						hideEmotions();
						hideLoading();
					});
					//change color on home button
					$("#home_text").hover(function(){
							$("#home_text").css("color", "blue");
							$("#home_text").css("font-weight", 700);
						}, function(){
							$("#home_text").css("color", "white");
							$("#home_text").css("font-weight", 400);
						});
					//loading animation stuff
					function showLoading() {
						$("#loading").show();
					}
	
					function hideLoading() {
						$("#loading").hide();
					}
					
					//emotions stuff
					function showEmotions(){
						$("#emotions_div").show();
					}
					
					function hideEmotions(){
						$("#emotions_div").hide();
					}
					
					function selectChanged(){
						if($("#query_select").val() == "Top Songs by Emotion"){
							showEmotions();
						}
						else{
							hideEmotions();
						}
						
					}
					
					/*
					 *Handle the submit button:
					 *Calls the display_query.php with ajax
					 */
					$(function() {  
						$("#submit_button").click(function() {
							var query_type = $("#query_select").val();
							var emotion_type = $("#emotion_select").val();
							showLoading();
							$.post("display_query.php", {emotion : emotion_type, query : query_type, username : "<?= $username ?>"}, function(data){
								$("#display_div").html(data);
							});
							hideLoading();
						});  
					}); 
					

				</script>

 
	</head>
	<body>
		<div id="titlebar">
			<span id="titletext">Lyrics Commander</span>
			<a href='http://www.lyricscommander.com' id = "home_text">Home</a>
		</div>
	<div id="content" >
		<div id = "everything">
		<span id="ProfileName">
			<?php echo "<h1>" . $username . "'s Statistics</h1>"; ?>
		</span>
		<span id="stats">
		<?php
			/* 
			 *number of ratings and average ratings per song HEADER
			 */
			
			$num_ratings = getNumRatings($username);
			$avg_ratings_per_song = getAvgRatingsPerSong($username);
			$avg_ratings_per_stanza = getAvgRatingsPerStanza($username);
			echo "No. Ratings: <b>" . $num_ratings . "</b>";
			echo "</br>" ;
			echo "Avg. Ratings per Song: <b>" . $avg_ratings_per_song . "</b>";
			echo "</br>";
			echo "Avg. Ratings per Stanza: <b>" . $avg_ratings_per_stanza . "</b>";
			echo "</br></br>";
			//put the dynamic section here
			echo '
			<p1>Select Statistic To Display</br></p1>
			<select id = "query_select" class = "query_select" onchange = "selectChanged();">
				<option>Personal Tagging Data</option>
				<option>Global Tagging Data</option>
				<option>Artist Tagging Data</option>
				<option>Top Songs by Emotion</option>
				<option>Last 2 Songs</option>
				<option>Last 5 Songs</option>
				<option>Last 10 Songs</option>
				<option>Friends</option>
				<option>All Song Tags</option>
			</select>
			<div id = "emotions_div">
				<select id = "emotion_select">';
				$query = "SELECT * FROM Tag";
				$result = mysql_query($query) or die(mysql_error());
				$num_rows = mysql_num_rows($result);
				for($i = 0; $i< $num_rows; $i++){
					echo "<option>" . mysql_result($result, $i, 1) . "</option>";
				}	
				
			echo '
				</select>
			</div>
			<button type = "button" id = "submit_button">Submit</button>
			</form>
			</br>'
			;
		?>
		<div id = "display_div" bgcolor="#E6E6FA">
			<div id = "loading">
				<img src="loader.gif" />
			</div>
		</div>
		</span>
		<br />
		</div>
	</div>
		<br />
		
		
	</body>
</html>
 </html>