<?php
//Joe Adams
//Statistics test query
//
?>
<html>
<title>Statistics Test</title>
<link rel="stylesheet" type="text/css" href="http://lyricscommander.com/homestyle.css" />

<?php
	$username = 'Joe';
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
			$num = 4;
			$username = 'Joe';
			getNumSongsRated($username);
			echo "</br> </br> </br>";
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