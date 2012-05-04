<?php

	//gets the number of songs the user has rated
	function getNumRatings($username){
		$query = "SELECT COUNT('UserID') AS count
					FROM Rating
					WHERE UserID = (SELECT UserID
									FROM User
									WHERE Username ='" . $username . "')";
		$result = mysql_query($query) or die(mysql_error());
		if(mysql_result($result,0) == 0){
			return 0;
		}
		return mysql_result($result, 0);
	}
	
	//gets the average number of ratings per song for the user
	function getAvgRatingsPerSong($username){
		//query that gets the average number of ratings per song
		$query = 'SELECT AVG(songCount) AS ave
					FROM (
						SELECT Song.Name, SUM(stanzaCount) AS songCount
						FROM Song, Stanza, (
							SELECT StanzaID, COUNT(UserID) AS stanzaCount
							FROM Rating 
							WHERE UserID = (
								SELECT UserID 
								FROM User
								WHERE Username = "' . $username . '")
							GROUP BY StanzaID)stanzaCounts
						WHERE stanzaCounts.StanzaID = Stanza.StanzaID AND Stanza.SongID = Song.SongID 
						GROUP BY Song.Name)songCounts';
		$result = mysql_query($query) or die(mysql_error());
		return round(mysql_result($result,0),2);
	}
	
	//gets the average number of ratings per stanza for the user
	function getAvgRatingsPerStanza($username){
		//gets the average number of ratings per stanza fro the user
		$query = 'SELECT AVG(stanzaCount) AS Ave'
				. ' FROM ('
					. ' SELECT StanzaID, COUNT(UserID) AS stanzaCount'
					. ' FROM Rating '
					. ' WHERE UserID = ('
						. ' SELECT UserID '
						. ' FROM User'
						. ' WHERE Username = "' . $username . '")'
					. ' GROUP BY StanzaID)stanzaCounts';
		$result = mysql_query($query) or die(mysql_error());
		return round(mysql_result($result, 0),2);
	}
	//Gets the last n number of songs the user has rated
	function getLastSongs($username, $number){
		//gets all the songs the user has rated, ordered by the time they were entered
		$query = 'SELECT Song.Name AS SongName, Artist.Name AS ArtistName'
				. ' FROM Artist, Song, ('
				. ' SELECT DISTINCT SongID'
				. ' FROM Stanza, ('
					. ' SELECT StanzaID'
					. ' FROM Rating'
					. ' WHERE UserID =(SELECT UserID
										FROM User
										WHERE Username = "' . $username . '")'
					. ' ORDER BY time )stanzas'
				. ' WHERE Stanza.StanzaID = stanzas.StanzaID'
				. ' )songs'
			. ' WHERE Song.SongID = songs.SongID AND Song.ArtistID = Artist.ArtistID';
			
		$result = mysql_query($query) or die(mysql_error());
		$num_rows = mysql_num_rows($result);
		if($num_rows == 0){
			echo "No Ratings :(";
			return;
		}
		if($num_rows<$number){
			$number = $num_rows;
			echo "You have only rated " . $number . " songs.";
		}
		echo "<h1>Last " . $number . " Songs:</h1>";
		for($i = $num_rows-1; $i>$num_rows-$number-1; $i--){
			echo ($num_rows-$i) . ". <b>" . mysql_result($result, $i, 0) . "</b> by ";
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
		 //gets number of ratings 
		 $query = 'SELECT COUNT(UserID) FROM Rating WHERE UserID =(SELECT UserID
																	FROM User
																	WHERE Username = "' . $username . '")';
		 $count = mysql_query($query) or die(mysql_error());
		 $number_of_tags = mysql_result($count, 0);
		 $num_rows = mysql_num_rows($result);
		if($num_rows == 0){
			echo "No Ratings :(";
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
	}
	
	function getFriendsData($username){
		
		//gets all the friends if the userID is User1ID1
		$friends_query1 = 'SELECT Username, UserID 
							FROM Buddies, User 
							WHERE User2ID = UserID AND User1ID = (SELECT UserID FROM User WHERE Username = "' . $username . '")';
		$friends_result1 = mysql_query($friends_query1) or die(mysql_error());
		$num_rows = mysql_num_rows($friends_result1);
		if($num_rows == 0){
			echo "No Friends :(";
			return;
		}	
		echo "<table border='1'>
		<tr>
		<th>Friend</th>
		<th>No. Ratings</th>
		<th>Avg. Ratings/Song</th>
		<th>Avg. Ratings/Stanza</th>
		</tr>";
		for($i = 0; $i<$num_rows; $i++){
			echo "<tr>";
			echo "<td>" . mysql_result($friends_result1, $i, 0) . "</td>";
			echo "<td>" . getNumRatings(mysql_result($friends_result1, $i, 0)) . "</td>"; 
			echo "<td>" . getAvgRatingsPerSong(mysql_result($friends_result1, $i, 0)) . "</td>";
			echo "<td>" . getAvgRatingsPerStanza(mysql_result($friends_result1, $i, 0)) . "</td";
			echo "</tr>";
		}
		//gets all the friends if UserID is User2ID
		$friends_query2 = 'SELECT Username, UserID 
							FROM Buddies, User 
							WHERE User1ID = UserID AND User2ID = (SELECT UserID FROM User WHERE Username = "' . $username . '")';
		$friends_result2 = mysql_query($friends_query2) or die(mysql_error());
		$num_rows = mysql_num_rows($friends_result2);
		for($i = 0; $i<$num_rows; $i++){
			echo "<tr>";
			echo "<td>" . mysql_result($friends_result2, $i, 0) . "</td>";
			echo "<td>" . getNumRatings(mysql_result($friends_result2, $i, 0)) . "</td>"; 
			echo "<td>" . getAvgRatingsPerSong(mysql_result($friends_result2, $i, 0)) . "</td>";
			echo "<td>" . getAvgRatingsPerStanza(mysql_result($friends_result2, $i, 0)) . "</td";
			echo "</tr>";
		}
		echo "</table>";
	}
	
	//gets all the tagging data for artists that the user has rated
	function getArtistTaggingData($username){
		
		//gets all the artists that the user has rated
		$user_artists_query = 'SELECT DISTINCT Artist.Name, Artist.ArtistID'
							. ' FROM Rating, Artist, Song, Stanza '
							. ' WHERE Rating.StanzaID = Stanza.StanzaID AND Stanza.SongID = Song.SongID AND Song.ArtistID = Artist.ArtistID LIMIT 0, 30 ';
		$user_artists_result = mysql_query($user_artists_query) or die(mysql_error());
		//gets numer of rows of the table
		$num_artists = mysql_num_rows($user_artists_result);
		
		//get all of the tags for the header of the table
		$tags_query = "SELECT Word 
					FROM Tag";
		$tags_result = mysql_query($tags_query) or die(mysql_error());
		$num_tags = mysql_num_rows($tags_result);
		//start table
		echo "<table border='1'>
		<tr>
		<th>Artist</th>
		<th>No. Ratings</th>";
		for($i = 0; $i<$num_tags; $i++){
			echo "<th>" . mysql_result($tags_result, $i) . "</th>";
		}
		echo "</tr>";
		for($i = 0; $i<$num_artists; $i++){
		
			//get number of ratings for the given artistID
			$num_ratings_query = 'SELECT COUNT(Rating.WordID) '
								. ' FROM Rating'
								. ' WHERE Rating.StanzaID IN ('
									. ' SELECT Stanza.StanzaID'
									. ' FROM Stanza, Artist, Song'
									. ' WHERE Stanza.SongID = Song.SongID AND Song.ArtistID = ' . mysql_result($user_artists_result, $i, 1) . ')' ; 
			$num_ratings_result = mysql_query($num_ratings_query) or die(mysql_error());
			
			echo "<tr>";
			echo "<td>" . mysql_result($user_artists_result, $i, 0) . "</td>";
			echo "<td>" . mysql_result($num_ratings_result, 0) . "</td>";
			
			/*
			 *Go through all the tags, get the number of times that the artist has been rated that tag, then put it in the table
			 */
			for($j = 1; $j<=$num_tags; $j++){
				//This query finds the number of times that an artist is rated with a specific tagID. Since the tagID's start from 1 we can just use $j for this
				$num_tag_ratings_query = 'SELECT COUNT(UserID)'
										. ' FROM Rating'
										. ' WHERE Rating.WordID = ' . $j . ' AND Rating.StanzaID IN ('
											. ' SELECT Stanza.StanzaID'
											. ' FROM Stanza, Artist, Song'
											. ' WHERE Stanza.SongID = Song.SongID AND Song.ArtistID = Artist.ArtistID and Artist.ArtistID = '. mysql_result($user_artists_result, $i, 1) . ')';
				$num_tag_ratings_result = mysql_query($num_tag_ratings_query);
				echo "<td>" . mysql_result($num_tag_ratings_result, 0) . "</td>";
			}
			echo "</tr>";
		}
	}
	
?>