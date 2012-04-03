<?php
require_once "db_login.php";
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database, $db_server); 
	
$loggedin = false;
$cookieinfo = explode("%", $_COOKIE['main']);
if ($cookieinfo[0] != null)
	$loggedin = true;
	
if ($_POST["login_name"] != null){
	$username = $_POST["login_name"];
	$password = $_POST["login_password"];
	$query = "SELECT * 
			  FROM User
			  WHERE `Username` = '$username'";
	$result = mysql_query($query);
	if ($result == null)
		; //No such username
	else{
		$row = mysql_fetch_row($result);
		if ($row[2] == md5($password)){
			$loggedin = true;
			setcookie("main", $row[0], time() + 3600, "/");
		}
		else
			;	//Incorrect password
	}
}


echo <<<_HDOC
<html>
	<head>
		<title>Lyrics Commander</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
				<script src="_js/jquery-1.7.js"></script>
		<script>
			$(document).ready(function(){
				
				
			});
			
			function logout(){
				document.cookie = "main" + '=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
				location.reload(true);
			}
		</script>
	<head>

	<body>
		<div id="titlebar">
			<span id="titletext">Lyrics Commander</span>
		</div>
		
		<div id="maindiv">
			<table id="centertable">
				<tr>
_HDOC;
if ($loggedin){
	echo <<<_HDOC
					<td id="leftbox">
						<button id="centerbutton" onclick = "window.location.href = 'main.php'">Get Started</button>
					</td>
					
					<td id="rightbox">
						<p>Lyrics Commander will command your lyrics and tell you which songs you like.</p>
					</td>
_HDOC;
}
else{	//If logged out
	echo <<<_HDOC
				<td id="leftbox">
					<div id="logindiv">
						<span id="loginspan">Login</span>
						<form id="registerform" method="post" action="index.php">
							Username:&nbsp&nbsp<input type="text" name="login_name" length="20" maxsize="32" />
							<span id="loginpassword">	<br />Password:&nbsp&nbsp<input type="password" name="login_password" length="20" maxsize="32" />	</span>
							<br /><input type="submit" value="Login" id="loginsubmit"/>
						</form>
					</div>
				</td>
				
				<td id="rightbox">
					Register?
				</td>
_HDOC;
}
echo <<<_HDOC
				</tr>
			</table>
		</div>
		
		<div id="bottombar">
			<li>
				<a href="#statistics">Statistics</a>
				<a href="#settings">Settings</a>
				<a href="javascript:logout()">Logout</a>
				<a href="#about"">About</a>
			</li>
		</div>
			
	</body>
</html>
_HDOC;
?>