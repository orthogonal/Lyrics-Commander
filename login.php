<?php
	require_once("db_login.php");
	mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
	mysql_select_db($db_database) or die(mysql_error());
	if ($_POST["username"] != null){
		$username = stripslashes($_POST["username"]);
		$username = substr($username, 1, $username.length - 1);
		$password = stripslashes($_POST["password"]);
		$password = substr($password, 1, $password.length - 1);
		$query = "SELECT * 
				  FROM User
				  WHERE `Username` = '$username'";
		$result = mysql_query($query);
		if ($result == null)
			echo "username";
		else{
			$row = mysql_fetch_row($result);
			if ($row[2] == md5($password)){
				setcookie("main", $row[0], time() + 3600, "/");
				echo "success";
			}
			else
				echo "password";
		}
	}
	else echo "Nothing received";
?>