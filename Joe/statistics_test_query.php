
<html>
<title>Statistics Test</title>
<link rel="stylesheet" type="text/css" href="http://lyricscommander.com/homestyle.css" />

<?php
//include("http://www.lyricscommander.com/db_login.php");
$db_server = mysql_connect('lyricscommander.db.8271005.hostedresource.com', lyricscommander, Meral341);
mysql_select_db(lyricscommander, $db_server); 

/*$query = "SELECT * 
			FROM Tag";
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result))
  {
  echo $row['Word'];
  echo "<br />";
  }*/
   function getNumberOfSongsRated(){
	$username = "TestUser";
	$query = "SELECT *
			  FROM Tags";
	$result = mysql_query($query) or die(mysql_error());

	while($row = mysql_fetch_array($result))
	{
	echo $row['Username'];
	echo "<br />";
	}
}

getNumberOfSongsRated();

 ?>
 
 <head>
	<body>
		<div id="titlebar">
			<span id="titletext">Lyrics Commander Statistics</span>
		</div>
		
		<div id="lyricsdiv">
		<span id="everything">
			<span id="ProfileName">
				Profile Name goes here
			</span>
			<br />
			<br />
			<span id="stats">

			</span>
			<br />
		</span>
			<br />
		</div>
		
		
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