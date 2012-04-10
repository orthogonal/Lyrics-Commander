<?php
//Joe Adams
//Statistics test query
//
?>
<html>
<title>Statistics Test</title>
<link rel="stylesheet" type="text/css" href="http://lyricscommander.com/homestyle.css" />

<?php
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
		$userid = 1;				//CHANGE THIS LATER TO GO BACK TO HOME IF THE USER IS NOT LOGGED IN
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
 
 <head>
	<body>
		<div id="titlebar">
			<span id="titletext">Lyrics Commander Statistics</span>
		</div>
	<span id="everything">
		<span id="ProfileName">
			<?php echo "<h1>Profile: " . $username . "</h1>"; ?>
		</span>
		<span id="stats">
		<?php
			getNumSongsRated($username);
			echo "</br> </br> </br>";
			//put the dynamic section here
			include("dynamic_section.php");
		?>
		</span>
		<br />
	</span>
		<br />
		
		
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
 </html>