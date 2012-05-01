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
		$userid = 1;				//CHANGE THIS LATER TO GO BACK TO HOME IF THE USER IS NOT LOGGED IN
	}
	$query = "SELECT * FROM User WHERE UserID = $userid";
	$result = mysql_query($query) or DIE(mysql_error());
	$row = mysql_fetch_row($result);
	$name = "";
	$username = $row[1];
	$email = $row[3];
	$aboutMe = "";
	$image = "";
?>

<html>
	<head>
		<title>Lyrics Commander</title>
		<link rel="stylesheet" type="text/css" href="homestyle.css" />
        
        <script>
		/*================================================================================*/
		/*==				The JavaScript code for the registration form.   	    	==*/
		/*==  			First, it checks if all the fields have valid lengths.  		==*/
		/*==   Then it does an AJAX call first to see if the username already exists.	==*/
		/*================================================================================*/
						
		$("#updateform").submit(function(evt){
			var fullname = $('#fullname').val();
			var password1 = $('#password1').val();
			var password2 = $('#password2').val();
			var aboutme = $('#aboutme').val();
			var image = $('#image').val();
			var email = $('#email').val();
							
			if ((password1.length == 0 || ((0 < password1.length <= 31) && (password1 == password2))) && (0 < email.length <= 127) && (0 <= fullname.length <= 30) && (0 <= aboutme.length <= 500) && (0 <= profileimage.length <= 2083)){
				var query = "UPDATE User SET FullName='$fullname', column2=value2";
				$('#submit_update').attr("disabled", "disabled");
				$.post("updateUser.php", query, function(data){
					if (data == ""){
						$('registerform').trigger('submit');
					}
					else{
						
					}
				});
			}
			else{
				if (password.length > 31) alert("Password is too long");
				if (email.length > 127) alert("E-mail Address is too long");
				if (password == "Password") alert("Please enter a password that isn't \"Password\"");
				if (email == "E-mail Address") alert("Please enter a real e-mail address");
				if (password.length == 0) alert("Please enter a password");
				if (email.length == 0) alert("Please enter an e-mail address");
				evt.preventDefault();
			}
		});
		
		</script>
	</head>
    <body>
    	<div id="titlebar">
			<span id="titletext">Lyrics Commander Profile Page</span>
			<?php
				if ($loggedin) echo "<a href='' id='logouttext'>Logout</a>";
			?>
		</div>
		
		<table id="maintable">
		<tr>
		<td>
        <div id="profile">
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
		</td>
		
		<td>
    	</td>
        </tr>
        </table>
	</body>
</html>