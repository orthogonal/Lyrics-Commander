<?php
if(isset($_POST["username"]))
{
	$username = $_POST["username"];
	$email = $_POST["email"];
	$email1 = $_POST["email1"];
	$password = $_POST["pwd"];
	$password1 = $_POST["pwd1"];
	if($email == $email1 && $password == $password1)
	{
	$db_hostname = 'lyricscommander.db.8271005.hostedresource.com';
	$db_database = 'lyricscommander';
	$db_username = 'lyricscommander';
	$db_password = 'Meral341';

	mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
	mysql_select_db($db_database) OR DIE (mysql_error());
	$password=md5($password);
	$query =  "INSERT INTO User (Username, Email, Password)
VALUES ('$username', '$email', '$password')";
	$result = mysql_query($query) OR DIE (mysql_error());
	
	}
}

?>

<html>
	<head>
		<title>Lyrics Commander Register Page</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
		<script src="_js/jquery-1.7.js"></script>
		
		
		<div id="titlebar">
			<span id="titletext">Lyrics Commander</span>
		</div>
		<div id="maindiv">
			<table id="centertable">
				<tr>
				<td id="leftbox">
		<form action="" method="post"><table border="0">
		<tr><td>User Name</td><td><input type="text" name="username" id="username"/></td></tr>
		<tr><td>Email Address</td><td> <input type="text" name="email" id="email" /></td></tr>
		<tr><td>Confirm Email</td><td> <input type="text" name="email1" id="email1" /></td></tr>
		<tr><td>Password:</td><td> <input type="password" name="pwd" id="pwd" /></td></tr>
		<tr><td>Confirm Password:</td><td> <input type="password" name="pwd1" id="pwd1" /></td></tr>
		<tr><td> <input type="submit" name="mysubmit" id="mysubmit" value="Submit" /></td></tr>
		</table>
		
		</form>
		
		
		</td></tr></table>
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