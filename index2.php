<?php
	require_once("db_login.php");
	mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
	mysql_select_db($db_database) or die(mysql_error());
	
	if(isset($_POST["username"]))
	{
		$username = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];

		if(strlen($password)<31 && strlen($email<127) && strlen(username)<31 
			/*&& preg_match('^"[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)?*(\.[a-z]{2,3})$"^', $email) == true */
			&& $username != "" && $email != "" && $password != ""){
			$password=md5($password);
			$query =  "INSERT INTO User (Username, Email, Password) VALUES ('$username', '$email', '$password')";
			$result = mysql_query($query) or die(mysql_error());
		}
		else
		{
			if (strlen($password)>=31)
				die("ERROR password is has too many characters");
			if (strlen($email>=127))
				die("ERROR email has too many characters");
			if (strlen($username)>=31)
				die("ERROR username has too many characters");
			//if (preg_match('^"[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)?*(\.[a-z]{2,3})$"^', $email) == false)
			//	die("ERROR please enter a valid email address");
			if ($username!="")
				die("ERROR You did not enter in a username");
			if ($password!="")
				die("ERROR You did not enter in a password");
			if ($email!="")
				die("ERROR You did not enter in an e-mail address");
		}
	}
?>
		
<!DOCTYPE html>
<html>
	<head>
		<title>Lyrics Commander</title>
			<link rel="stylesheet" type="text/css" href="indexstyle.css" />
				<script src="_js/jquery-1.7.js"></script>
				<script>
					$(document).ready(function(){
						$(".registerfield").focus(function(){
							if ($(this).val() == $(this).attr('title')){
								$(this).css('color', 'black');
								$(this).val("");
							}
						});
						$(".registerfield").blur(function(){
							if ($(this).val() == ""){
								$(this).css('color', '#E0E0E0');
								$(this).val($(this).attr('title'));
							}
						});
						$(".registerfield").blur();
						
						$("#registerform").submit(function(evt){
							var username = $('#username').val();
							var password = $('#password').val();
							var email = $('#email').val();
							
							if ((0 < username.length <= 31) && (0 < password.length <= 31) && (0 < email.length <= 127) 
							&& (password != "Password") && (username != "Username") && (email != "E-mail Address")){
								var query = 'SELECT * FROM User WHERE Username = "' + username + '"';
								query = "query='" + query + "'";
								$('#submit_register').attr("disabled", "disabled");
								$.post("checkUsers.php", query, function(data){
									if (data == ""){
										$('registerform').trigger('submit');
									}
									else{
										alert("Username already exists!");
										$('#submit_register').removeAttr("disabled");
										evt.preventDefault();
									}
								});
							}
							else{
								if (username.length > 31) alert("Username is too long");
								if (password.length > 31) alert("Password is too long");
								if (email.length > 127) alert("E-mail Address is too long");
								if (password == "Password") alert("Please enter a password that isn't \"Password\"");
								if (username == "Username") alert("Username already exists!");
								if (email == "E-mail Address") alert("Please enter a real e-mail address");
								if (username.length == 0) alert("Please enter a username");
								if (password.length == 0) alert("Please enter a password");
								if (email.length == 0) alert("Please enter an e-mail address");
								evt.preventDefault();
							}
						});
					});
				</script>
	</head>
	<body>
		<div id="titlebar">
			<span id="titletext">Lyrics Commander</span>
		</div>
		
		<div id="containerdiv">
			<div id="centerdiv">
				<table id="centertable">
					<tr>
						<td id="left">
							<span id="join">Join The Party!</span>
							<form id="registerform" method="post" action="index2.php">
								<input type="text" name="username" id="username" class="registerfield" maxlength="31" width="25" title="Username"/>
								<br /><input type="password" name="password" id="password" class="registerfield" maxlength="31" width="25" title="Password"/>
								<br /><input type="text" name="email" id="email" class="registerfield" maxlength="127" width="25" title="E-mail Address"/>
								<br /><input type="submit" name="submit_register" id="submit_register" value="Submit" />
							</form>
							
							<span id="alreadymember">Already have an account?  <button id="login_button">Login</button></span>
						</td>
						<td id="right">
							<span id="description">
								Lyrics Commander presents you with lyrics from a wide variety of songs and asks you to 
								categorize them based on your opinions of them.  <br />Over time, the engine will generate
								a rich collection of fascinating information about your musical tastes, which you can use
								to compare yourself to your friends and other users.  <br />Lyrics Commander is a fun way to 
								discover new bands, interact with music and learn about yourself.
							<span>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>