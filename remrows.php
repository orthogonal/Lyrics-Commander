<?php	//remrows
	require_once "globals.php";
	require_once "db_login.php";
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server);
	$userid = $_POST['userID'];
	$query = "SELECT COUNT(*) 
			  FROM Stanza S
			  WHERE S.StanzaID < $gl_stanzas
			  AND NOT EXISTS (SELECT * 
			  				  	FROM Rating R 
			  				  	WHERE UserID = $userid
			  				  	AND R.StanzaID = S.StanzaID)";
			  				  	
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($result);
			  				 	
	echo "$row[0]";
?>