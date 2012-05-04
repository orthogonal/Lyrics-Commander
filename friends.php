<html>
	<head>
		<title>Lyrics Commander Friends Page</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
		<script src="_js/jquery-1.7.js"></script>
        <script>
		$(document).ready(function(){
		/*=======================================================*/
		/*==	  The Logout Button and its functionality	   ==*/
		/*=======================================================*/
						
						$("#logouttext").click(function(evt){
							evt.preventDefault();
							$.post("logout.php", function(data){
								location.href="index.php";
							});
						});
						
						$("#logouttext").hover(function(){
							$("#logouttext").css("color", "blue");
							$("#logouttext").css("font-weight", 700);
						}, function(){
							$("#logouttext").css("color", "white");
							$("#logouttext").css("font-weight", 400);
						});
		});
		</script>
	<!--k-->	
		
		<div id="titlebar">
			<span id="titletext">Lyrics Commander Friends Page</span>
            <?php
				$loggedin = false;
				$userid = -1;
				$cookieinfo = explode("%", $_COOKIE['main']);
				if ($cookieinfo[0] != null){
					$loggedin = true;
					$userid = $cookieinfo[0];
				}
				else{
					print '<script> location.href="index.php"; </script>';
					exit();
				}
			
				if ($loggedin) echo "<a href='' id='logouttext'>Logout</a>";
			?>
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
					
					$queryL="INSERT INTO Log (UserID, Time, ActionID)
									VALUES ($User1ID, CURRENT_TIMESTAMP, 2)";
					$resultQueryL = mysql_query($queryL) or die(mysql_error());
					
					
					
					
					
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
				$queryF="SELECT Username, UserID
									FROM User 
										WHERE UserID=$User2ID LIMIT 1";
									
			$resultF = mysql_query($queryF);
			$rowF = mysql_fetch_array($resultF);
			$f = $rowF["UserID"];
			print "<p><a style=\"color:white;\" href=\"profile.php?f=$f\" target=\"_blank\">" . $rowF["Username"] . "</a></p>";
			
			}
			}
			print "<p id=\"newfriend\">POTENTIAL FRIENDS</p>";
			$queryTable="SELECT Username, UserID
									FROM PotentialBuddies, User
										WHERE User.UserID=PotentialBuddies.User1ID AND User1ID=$User1ID AND NOT EXISTS (SELECT Username
																																FROM Buddies, User
																																	WHERE User.UserID=Buddies.User1ID AND User1ID=$User1ID)";
																																	
			$resultT=mysql_query($queryTable);
			if(isset($resultT)) {
				while(($rowT = mysql_fetch_array($resultT)) != null){
					$f = $rowT["UserID"];
					print "<p><a style=\"color:white;\" href=\"profile.php?f=$f\" target=\"_blank\">" . $rowT["Username"] . "</a></p>";
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