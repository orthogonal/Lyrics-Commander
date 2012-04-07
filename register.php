<html>
	<head>
		<title>Lyrics Commander Register Page</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
		<script src="_js/jquery-1.7.js"></script>
	<!--jhkhgkgk-->	
		
		<div id="titlebar">
			<span id="titletext">Lyrics Commander</span>
		</div>
		<div id="maindiv">
			<table id="centertable">
				<tr>
				<td id="leftbox">
		<form action="" method="post"><table border="0">
		Please enter a valid username, and email address as well as a password with 4 or more characters.
		<tr><td>User Name</td><td><input type="text" name="username" id="username"/></td></tr>
		<tr><td>Email Address</td><td> <input type="text" name="email" id="email" /></td></tr>
		<tr><td>Confirm Email</td><td> <input type="text" name="email1" id="email1" /></td></tr>
		<tr><td>Password:</td><td> <input type="password" name="pwd" id="pwd" /></td></tr>
		<tr><td>Confirm Password:</td><td> <input type="password" name="pwd1" id="pwd1" /></td></tr>
		<tr><td> <input type="submit" name="mysubmit" id="mysubmit" value="Submit" /></td></tr>
		</table>
		
		</form>
		
		
		</td>
		<td id="rightBox">
		<?php
		require_once("db_login.php");
		if(isset($_POST["username"]))
		{
			$username = $_POST["username"];
			$email = $_POST["email"];
			$email1 = $_POST["email1"];
			$password = $_POST["pwd"];
			$password1 = $_POST["pwd1"];
			
			//strlen($password>3 && 

			if(strlen($password)<31 && strlen($email<127) && strlen(username)<31 && strlen($password)>3 && preg_match('^"[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)?*(\.[a-z]{2,3})$"^', $email) == true && $email == $email1 && $password == $password1 &&( $username!="" || $email!="" || $password!=""))
			{
			mysql_connect($db_hostname,$db_userna7me, $db_password) OR DIE (mysql_error());
			mysql_select_db($db_database) OR DIE (mysql_error());
			$password=md5($password);
			$query =  "INSERT INTO User (Username, Email, Password)
		VALUES ('$username', '$email', '$password')";
			$result = mysql_query($query) OR DIE (mysql_error());
			}
			else
			{
				if (strlen($password)>=31){
				print("ERROR password is has too many characters");
				}
				if (strlen($email>=127)){
				print("ERROR email has too many characters");
				}
				if (strlen($username)>=31){
				print("ERROR username has too many characters");
				}
				if (preg_match('^"[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)?*(\.[a-z]{2,3})$"^', $email) == false){
				print("ERROR please enter a valid email address");
				}
				if ($email == $email1){
				print("ERROR The emails do not match");
				}
				
				if ($password == $password1){
				print("ERROR the passwords do not mactch");
				}
				if ($username!=""){
				print("ERROR You did not enter in a username");
				}
				if ($password!=""){
				print("ERROR You did not enter in a username");
				}
				if ($email!=""){
				print("ERROR You did not enter in a username");
				}
			}
		}
		?>
		
		</td>
		
		</tr></table>
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