<!DOCTYPE html>
<?php
$loggedin = false;
$cookieinfo = explode("%", $_COOKIE['main']);
if ($cookieinfo[0] != null)
	$loggedin = true;


echo <<<_HDOC
<html>
	<head>
		<title>Lyrics Commander</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
		<script src="_js/jquery-1.7.js"></script> 
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
					You are logged out!
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
				<a href="#logout">Logout</a>
				<a href="#about">About</a>
			</li>
		</div>
			
	</body>
</html>
_HDOC;
?>