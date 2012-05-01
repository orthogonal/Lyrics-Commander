<?php	//addtag.php
	require_once "db_login.php";
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server);
	
	
	
	$cookieinfo = explode("%", $_COOKIE['main']);
	$User1ID = $cookieinfo[0];
	
	
	$queryL="INSERT INTO Log (UserID, Time, ActionID)
				VALUES ($User1ID, CURRENT_TIMESTAMP, 1)";
	$resultQueryL = mysql_query($queryL) or die(mysql_error());
	
	$query = $_POST['query'];
	$result = mysql_query($query) or die("\n$query\n" . mysql_error());
	echo "success";
?>