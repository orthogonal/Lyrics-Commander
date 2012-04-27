<?php	//addtag.php
	require_once "db_login.php";
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server);
	
	$query = $_POST['query'];
	$result = mysql_query($query) or die("\n$query\n" . mysql_error());
	echo "success";
?>