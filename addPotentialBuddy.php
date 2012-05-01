<?php	//addPotentialBuddy.php
	require_once "db_login.php";
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server);
	
	$cookieinfo = explode("%", $_COOKIE['main']);
	$User1ID = $cookieinfo[0];	
	$postData = explode("%", $_POST["data"]);
	$wordID = $postData[0];
	$stanzaID = $postData[1];
	
	
	
	$queryPotBuddies="SELECT UserID
							FROM Rating
								WHERE WordID=$wordID AND StanzaID=$stanzaID";
								
	$resultPotBuddies = mysql_query($queryPotBuddies) or die(mysql_error());
	while(($row = mysql_fetch_array($resultPotBuddies)) != null){
	$User2ID = $row["UserID"];
	if ($User1ID==$User2ID)
	continue;
	
	$queryp =  "INSERT INTO PotentialBuddies (User1ID, User2ID)
					VALUES ($User1ID, $User2ID)";
					
					
					
	$resultp = mysql_query($queryp);	
	}
	
	echo "success";
?>






