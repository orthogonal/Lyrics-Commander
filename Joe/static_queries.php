<?php
	include("../db_login.php");
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server); 

	function getTags(){
		$query = "SELECT * 
					FROM Tag";
		$result = mysql_query($query) or die(mysql_error());

		while($row = mysql_fetch_array($result))
		{
		echo $row['Word'];
		echo ", ";
		}
	}
	
	function getUsers(){
		$query = "SELECT * 
					FROM User";
		$result = mysql_query($query) or die(mysql_error());
		echo "<table border='1' font-size: 2em;>
		<tr>
		<th>Username</th>
		<th>UserID</th>
		<th>Email</th>
		</tr>";
		
		while($row = mysql_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['Username'] . "</td>";
			echo "<td>" . $row['UserID'] . "</td>";
			echo "<td>" . $row['Email'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	
	
 ?>