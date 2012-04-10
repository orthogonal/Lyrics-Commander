<?php

	//gets the number of songs the user has rated
	function getNumSongsRated($username){
		$query = "SELECT COUNT('UserID') AS count
					FROM Rating
					WHERE UserID = (SELECT UserID
									FROM User
									WHERE Username ='" . $username . "')";
		$result = mysql_query($query) or die(mysql_error());
		
		
		while($row = mysql_fetch_array($result))
		{
			echo "No. Songs Rated: <b>" . $row['count'] . "</b>";
		}
	}
	
	//Gets the last n number of songs the user has rated
	function getLastSongs($username, $number){
		$query = 'SELECT Song.Name AS SongName, Artist.Name AS ArtistName'
				. ' FROM Artist, Song, ('
				. ' SELECT SongID'
				. ' FROM Stanza, ('
					. ' SELECT StanzaID'
					. ' FROM Rating'
					. ' WHERE UserID =(SELECT UserID
										FROM User
										WHERE Username = "' . $username . '")'
					. ' )stanzas'
				. ' WHERE Stanza.StanzaID = stanzas.StanzaID'
				. ' )songs'
			. ' WHERE Song.SongID = songs.SongID AND Song.ArtistID = Artist.ArtistID';
			
		$result = mysql_query($query) or die(mysql_error());
		$num_rows = mysql_num_rows($result);
		if($num_rows<$number){
			$number = $num_rows;
			echo "You have only rated " . $number . " songs.";
		}
		echo "<h1>Last " . $number . " Songs:</h1>";
		for($i = 0; $i<$number; $i++){
			echo ($i+1) . ". <b>" . mysql_result($result, $i, 0) . "</b> by ";
			echo "<b>" . mysql_result($result, $i, 1) . "</b></br></br>";
		}
	}
	//gets all the personal tagging data in terms of percentage
	function getPersonalTaggingData($username){
		 
		 //gets distinct words used, with wordID and how many times it is used
		 $query = 'SELECT DISTINCT Tag.Word, COUNT(Rating.WordID) 
					FROM Rating, Tag WHERE UserID =(SELECT UserID 
													FROM User
													WHERE Username = "' . $username . '")
					AND Tag.WordID = Rating.WordID GROUP BY Rating.WordID LIMIT 0, 30 ';
		 $result = mysql_query($query) or die(mysql_error());
		 $query = 'SELECT COUNT(UserID) FROM Rating WHERE UserID =(SELECT UserID
																	FROM User
																	WHERE Username = "' . $username . '")';
		 $count = mysql_query($query) or die(mysql_error());
		 $number_of_tags = mysql_result($count, 0);
		 $num_rows = mysql_num_rows($result);
		 
		 echo "<table border='1'>
		<tr>
		<th>Tag</th>
		<th>Times Used</th>
		<th>Percentage Used</th>
		</tr>";
		 for($i = 0; $i<$num_rows; $i++){
			echo "<tr>";
			echo "<td>" . mysql_result($result,$i,0) . "</td>";
			echo "<td>" . mysql_result($result,$i,1) . "</td> ";  
			echo "<td>" .(mysql_result($result,$i,1)/$number_of_tags)*100 . "%</td>";
		}	
		echo "</table>";
	}
?>