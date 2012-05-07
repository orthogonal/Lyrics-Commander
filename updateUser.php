<?php	//updateUser.php
	require_once "db_login.php";
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server);
	$cookieinfo = explode("%", $_COOKIE['main']);
	if ($cookieinfo[0] != "")
	{
		$fullname = mysql_real_escape_string(stripslashes($_POST['fullname']));
		$password = mysql_real_escape_string(stripslashes($_POST['password1']));
		$aboutme = mysql_real_escape_string(stripslashes($_POST['aboutme']));
		$imageurl = mysql_real_escape_string(stripslashes($_POST['image']));
		$email = mysql_real_escape_string(stripslashes($_POST['email']));	
		
		if (strlen($password) > 0)
			$query = "UPDATE User SET FullName='" . $fullname . "', AboutMe='" . $aboutme . "', ProfileImage='" . $imageurl . "', Email='" . $email . "', Password='" . MD5($password1) . "'" . " WHERE UserID='" . $cookieinfo[0] . "'";
		else
			$query = "UPDATE User SET FullName='" . $fullname . "', AboutMe='" . $aboutme . "', ProfileImage='" . $imageurl . "', Email='" . $email . "'" . " WHERE UserID='" . $cookieinfo[0] . "'";
		$result = mysql_query($query) or die("\n$query\n" . mysql_error());
		echo "success";
	}
?>