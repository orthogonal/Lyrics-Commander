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
				<td id="leftbox">
		<form action="" method="post"><table border="0">
		
		
		
		
		<br/><br/><br/><br/><br/><br/><br/>
		ADD FRIENDS
		<br />
		<tr><td>Friend's Username</td><td><input type="text" name="fUsername" id="fUsername"/></td></tr>
		
		<tr><td> <input type="submit" name="mysubmit" id="mysubmit" value="Submit" /></td></tr>
		</table>
		
		</form>
		
		
		
		
		</td>
		<td id="rightBox">
		<?php
		require_once("db_login.php");
		if(isset($_POST["fUsername"]))
		{
			$fUsername = $_POST["fUsername"];
			
			$cookieinfo = explode("%", $_COOKIE['main']);
			
			$User1ID = $cookieinfo[0];
			if($User1ID == "")	exit();
			mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
			mysql_select_db($db_database) OR DIE (mysql_error());

			
			$query2="SELECT UserID,Username 
							FROM User 
								WHERE username=='$fUsername' LIMIT 1";
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
					print "You have friended <b>" . $row2["Username"] . ".</b>";
				}
			}
			
			$queryFriends = "SELECT User2ID
					FROM Buddies
					WHERE username=='$fUsername'";
		$resultFriends = mysql_query($queryFriends) or die(mysql_error());
		
		
		while($row = mysql_fetch_array($queryFriends))
		{
		$User2ID = $row['UserID'];
		
		
		$queryF="SELECT Username 
							FROM User 
								WHERE UserID=='$User2ID' LIMIT 1";
			$resultF = mysql_query($queryF);
		$rowF = mysql_fetch_array($resultF);
		
		
		print "Friends List<b>" . $rowF["Username"];
		
		}
			
	
			
			
			
		}
		?>
		
		</td>
		
		</tr></table>
		<div id="bottombar">
			<li>
				<a href="#statistics">Statistics</a>
				<a href="#settings">Settings</a>
				<a href="#logout">Logout</a>
				<a href="#about">About</a>
			</li>
		</div>
		
		<!-- This form holds values generated in the JavaScript functions that are passed by AJAX-->
		<form method="post" action="" id="hidden">
			<input type="hidden" name="stanzaID" id="stanzaID" value="0" />
		</form>
		
	</body>
</html>