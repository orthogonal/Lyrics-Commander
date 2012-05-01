<?php	//updateUser.php
	require_once "db_login.php";
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server);
	$cookieinfo = explode("%", $_COOKIE['main']);
	if ($cookieinfo[0] != "")
	{
		$query = stripslashes($_POST['query']) . " WHERE UserID='" . $cookieinfo[0] . "'";
		print $query;
		$result = mysql_query($query) or die("\n$query\n" . mysql_error());
		echo "success";
	}
?>