<html>
	<head>
		<title>Lyrics Commander Friends Page</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
		<script src="_js/jquery-1.7.js"></script>
	<!--k-->	
		
		<div id="titlebar">
			<span id="titletext">Lyrics Commander Friends Page</span>
		</div>
		<div id="maindiv">
		<table id="centertable">
		<tr>
		
		<td id="leftbox" valign="top">
			<br/><br/><br/>
			<form action="" method="post">		
				<p id="addfriends">ADD FRIENDS</p>
				<p>Friend's Username: <input type="text" name="fUsername" id="fUsername"/></p>
				<p><input type="submit" name="mysubmit" id="mysubmit" value="Submit" /></p>
			</form>
		</td>
		
		<td id="rightBox" valign="top">
		<br/><br/><br/>
		<?php
		require_once("db_login.php");
		mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
			mysql_select_db($db_database) OR DIE (mysql_error());
		if(isset($_POST["fUsername"]))
		{
			$fUsername = $_POST["fUsername"];
			
			$cookieinfo = explode("%", $_COOKIE['main']);
			
			$User1ID = $cookieinfo[0];
			if($User1ID == "")	exit();
			

			
			$query2="SELECT UserID,Username 
							FROM User 
								WHERE username='$fUsername' LIMIT 1";
			$result2 = mysql_query($query2);
			if(isset($result2))
			{		
				$row2 = mysql_fetch_array($result2);
				
				$User2ID = $row2["UserID"];
				if($User2ID != "")
				{
					$query =  "INSERT INTO Buddies (User1ID, User2ID)
					VALUES ($User1ID, $User2ID)";
					
					$result = mysql_query($query);
					print "<p id=\"newfriend\">You have friended <b>" . $row2["Username"] . "</b>.</p>";
				}
			}
			
		
			
	
			
			
			
		}
			$cookieinfo = explode("%", $_COOKIE['main']);
			$User1ID = $cookieinfo[0];
			if($User1ID == "")	exit();
			
			$queryFriends = "SELECT User2ID
					FROM Buddies
					WHERE User1ID=$User1ID";
					
			$resultFriends = mysql_query($queryFriends) or die(mysql_error());
		print "<p id=\"friendslist\">FRIENDS LIST</p>";
		if(isset($resultFriends)) {
			
			while(($row = mysql_fetch_array($resultFriends)) != null){
			$User2ID = $row["User2ID"];
			
			
				$queryF="SELECT Username 
									FROM User 
										WHERE UserID=$User2ID LIMIT 1";
									
			$resultF = mysql_query($queryF);
			$rowF = mysql_fetch_array($resultF);

			print "<p>" . $rowF["Username"] . "</p>";
			
			}
		}
		
		
		?>
		
		</td>
		
		</tr></table>
		
		<!-- This form holds values generated in the JavaScript functions that are passed by AJAX-->
		<form method="post" action="" id="hidden">
			<input type="hidden" name="stanzaID" id="stanzaID" value="0" />
		</form>
		
	</body>
</html>