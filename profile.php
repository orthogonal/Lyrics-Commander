<?php
	require_once "db_login.php";
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server); 
	$loggedin = false;
	$userid = -1;
	$cookieinfo = explode("%", $_COOKIE['main']);
	if ($cookieinfo[0] != null){
		$loggedin = true;
		$userid = $cookieinfo[0];
	}
	else{
		header( 'Location: http://www.lyricscommander.com' ) ;
	}
	
?>
<html>
	<head>
		<title>Lyrics Commander</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
        <script src="_js/jquery-1.7.js"></script>
        <script src="_js/md5.js"></script>
        <script>
		/*================================================================================*/
		/*==				The JavaScript code for the update form.   	    	==*/
		/*==  			First, it checks if all the fields have valid lengths.  		==*/
		/*================================================================================*/
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
	
				
		$("#updateform").submit(function(evt){
			evt.preventDefault();
			var fullname = $('#fullname').val();
			var password1 = $('#password1').val();
			var password2 = $('#password2').val();
			var aboutme = $('#aboutme').val();
			var image = $('#image').val();
			var email = $('#email').val();
							
			if ((password1.length == 0 || password2.length == 0 || ((0 < password1.length <= 31) && (password1 == password2))) && (0 < email.length <= 127) && (0 <= fullname.length <= 30) && (0 <= aboutme.length <= 500) && (0 <= image.length <= 2083)){
				var query = "";
				if(password1.length > 0 && password2.length > 0)
					var query = "UPDATE User SET FullName='" + fullname + "', AboutMe='" + aboutme + "', ProfileImage='" + image + "', Email='" + email + "', Password='" + MD5(password1) + "'";
				else
					var query = "UPDATE User SET FullName='" + fullname + "', AboutMe='" + aboutme + "', ProfileImage='" + image + "', Email='" + email + "'";
				query = "query=" + query + "";
				$('#submit_update').attr("disabled", "disabled");
				$.post("updateUser.php", query, function(data){
					if (data == ""){

					}
					else{
						
					}
					location.href='profile.php';
				});
			}
			else{
				if (password1.length > 31) alert("Password is too long");
				if (email.length > 127) alert("E-mail Address is too long");
				if (password1 == "Password") alert("Please enter a password that isn't \"Password\"");
				if (email == "E-mail Address") alert("Please enter a real e-mail address");
				if (password1 != password2) alert("Passwords do not match");
				if (email.length == 0) alert("Please enter an e-mail address");
				evt.preventDefault();
			}
		});
});
		</script>
	</head>
    <body>
    	<div id="titlebar">
			<span id="titletext" style="cursor: pointer" onclick="window.location='http://www.lyricscommander.com'">Lyrics Commander</span>
			<?php
				if ($loggedin) echo "<a href='' id='logouttext'>Logout</a>";
			?>
		</div>
	<div id="all">
<?php	

	
	if(isset($_GET["f"]) == false)
	{
		$query = "SELECT * FROM User WHERE UserID = $userid";
		$result = mysql_query($query) or DIE(mysql_error());
		$row = mysql_fetch_row($result);
		$name = $row[4];
		$username = $row[1];
		$email = $row[3];
		$aboutMe = $row[5];
		$image = $row[6];
?>

        <div id="profile" style="width: 70%; float: left;">
        	<form id="updateform" action="profile.php" method="post">
        	<p>Username: <?php print $username; ?></p>
            <p>Full Name: <input type="text" id="fullname" value="<?php print $name; ?>"></p>
            <p>Update Password: <input type="password" id="password1"></p>
            <p>Confirm Password: <input type="password" id="password2"></p>
        	<p>Email: <input type="text" id="email" value="<?php print $email; ?>"></p>
            <p>About Me: <textarea rows="2" cols="60" id="aboutme"><?php print $aboutMe; ?></textarea></p>
            <p>Profile Image: <input type="text" id="image" value="<?php print $image; ?>"></p>
            <p><input id="submit_update" type="submit" value="Save Changes"></p>
            </form>
        </div>
        <div id="yourpicture" style="width: 30%; float: right;">
        	<img src="<?php print $image; ?>" />
        </div>
		
<?php
	}
    else
    {
		$query = "SELECT * FROM User WHERE UserID = " . $_GET["f"];
		$result = mysql_query($query) or DIE(mysql_error());
		if ($result == null) DIE("There is no such user!");
		$row = mysql_fetch_row($result);
		
		$name = $row[4];
		$username = $row[1];
		$email = $row[3];
		$aboutMe = $row[5];
		$image = $row[6];
    	?>
    	<div id="userinfo" style="width: 60%; float: left;">
        	<p>Username: <?php print $username; ?></p>
       	 	<p>Full Name: <?php print $name; ?></p>
        	<!--<p>Email: <?php //print $email; ?></p>-->
        	<p>About Me: <?php print $aboutMe; ?></p>
        </div>
        <div id="otherstuff" style="width: 40%; float: right;">
        	<p><img src="<?php print $image; ?>" /></p>
        	<?php
        		$query = 'SELECT DISTINCT Tag.Word, COUNT(Rating.WordID) 
							FROM Rating, Tag WHERE UserID =(SELECT UserID 
															FROM User
															WHERE Username = "' . $username . '")
											AND Tag.WordID = Rating.WordID GROUP BY Rating.WordID LIMIT 0, 30 ';
		 		$result = mysql_query($query) or die(mysql_error());
		 		//gets number of ratings 
		 		$query = 'SELECT COUNT(UserID) FROM Rating WHERE UserID =(SELECT UserID
																		FROM User
																		WHERE Username = "' . $username . '")';
			 	$count = mysql_query($query) or die(mysql_error());
		 		$number_of_tags = mysql_result($count, 0);
		 		$num_rows = mysql_num_rows($result);
				if($num_rows == 0){
					echo "This user has not rated any songs yet!";
				return;
			}	
		 
		 	echo "<table border='1'>
					<tr>
					<th>Tag</th>
					<th>Count</th>
					<th>Percentage</th>
					</tr>";
		 	for($i = 0; $i<$num_rows; $i++){
				echo "<tr>";
				echo "<td>" . mysql_result($result,$i,0) . "</td>";
				echo "<td>" . mysql_result($result,$i,1) . "</td> ";  
				echo "<td>" . round((mysql_result($result,$i,1)/$number_of_tags)*100,1) . "%</td> </tr>";
			}	
			echo "</table>";
        ?>
        </div>
        
        
        <?php
    }
?>
	</div>
	</body>
</html>