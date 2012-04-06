<?php
	function getNumSongsRated($username){
		$query = "SELECT COUNT('UserID') AS count
					FROM Rating
					WHERE UserID = (SELECT UserID
									FROM User
									WHERE Username ='" . $username . "')";
		$result = mysql_query($query) or die(mysql_error());
		
		
		while($row = mysql_fetch_array($result))
		{
			echo "No. Songs Rated: " . $row['count'];
		}
		echo "</table>";
	}
?>