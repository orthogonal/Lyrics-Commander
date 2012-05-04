<?php
	require_once("db_login.php");
	mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
	mysql_select_db($db_database) or die(mysql_error());
	
	$query = stripslashes($_POST['query']);
	$query = substr($query, 1, (strlen($query) - 2));
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($result);
	
	if ($row != null) echo "FAILURE";				//If there's a return, then a user exists with that name.
													//The JavaScript code interprets any echo as a failure.
?>