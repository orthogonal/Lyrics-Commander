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
		<title>Statistics Test</title>
			<link rel="stylesheet" type="text/css" href="http://lyricscommander.com/indexstyle.css" />
				<script src="../_js/jquery-1.7.js"></script>
				<script>
					$(document).ready(function(){
						hideLoading();
					});
					//loading animation stuff
					function showLoading() {
						$("#loading").show();
					}
	
					function hideLoading() {
						$("#loading").hide();
					}
					/*
					 *Handle the submit button:
					 *Calls the display_query.php with ajax
					 */
					$(function() {  
						$("#submit_button").click(function() {
							var query_type = $(".query_select").val();
							showLoading();
							$.post("display_query.php", {query : query_type, username : "<?= $username ?>"}, function(data){
								$("#display_div").html(data);
							});
							hideLoading();
						});  
					}); 
				</script>

 
	</head>
	<body>
		<div id="titlebar">
			<span id="titletext">Lyrics Commander Statistics</span>
		</div>
	<span id="everything">
		<span id="ProfileName">
			<?php echo "</br></br><h1>Profile: " . $username . "</h1>"; ?>
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
			<select name = "query_select" class = "query_select">
				<option>Personal Tagging Data</option>
				<option>Global Tagging Data</option>
				<option>Artist Tagging Data</option>
				<option>Last 2 Songs</option>
				<option>Last 5 Songs</option>
				<option>Last 10 Songs</option>
				<option>Friends</option>
				<option>All Song Tags</option>
			</select>
			<button type = "button" id = "submit_button">Submit</button>
			</form>
			</br>'
			;
		?>
		<div id = "display_div">
			<div id = "loading">
				<img src="loader.gif" />
			</div>
		</div>
		</span>
		<br />
	</span>
		<br />
		
		
	</body>
</html>
 </html>