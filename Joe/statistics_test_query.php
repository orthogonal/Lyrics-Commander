<?php
//Joe Adams
//Statistics test query
//
?>
<html>
<title>Statistics Test</title>
<link rel="stylesheet" type="text/css" href="http://lyricscommander.com/homestyle.css" />

<?php
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
		
		<div id="lyricsdiv">
		<span id="everything">
			<span id="ProfileName">
				Profile Name goes here
			</span>
			<br />
			<br />
			<span id="stats">
			<?php
				$username = 'Joe';
				getNumSongsRated($username);
				echo "</br></br>";
				echo "Users: </br>";
				getUsers();
				echo "</br>";
				echo "Possible Tags: ";
				getTags();
			?>
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