<?php
	include("../db_login.php");
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server); 

	function getTags(){
		$query = "SELECT * 
					FROM Tag";
		$result = mysql_query($query) or die(mysql_error());
		echo "<b>";
		while($row = mysql_fetch_array($result))
		{
		echo $row['Word'];
		echo "</br>";
		}
		echo "</b>";
	}
	
	function getUsers(){
		$query = "SELECT * 
					FROM User";
		$result = mysql_query($query) or die(mysql_error());
		echo "<table border='0' font-size: 2em;>
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
	
	//gets the global tagging data: total # of ratings, break down by how many times a rating has been used
	function getGlobalTaggingData(){
		//total number of ratings
		$num_ratings_total_query =  'SELECT COUNT(UserID)'
									. ' FROM Rating'
									. ' ';
		$num_ratings_total_result = mysql_query($num_ratings_total_query);
		//average number of ratings per stanza
		$avg_ratings_per_stanza_query = 'SELECT AVG(count)'
										. ' FROM (SELECT COUNT(UserID) AS count'
										. ' FROM Rating'
										. ' GROUP BY StanzaID)Counts';
		$avg_ratings_per_stanza_result = mysql_query($avg_ratings_per_stanza_query);
		//average number of ratings per song
		$avg_ratings_per_song_query = 'SELECT AVG(songCounts.songCount)'
										. ' FROM (SELECT Song.Name, SUM(stanzaCounts.stanzaCount)AS songCount'
										. ' FROM Song, Stanza,(SELECT StanzaID, COUNT(UserID) AS stanzaCount'
										. ' FROM Rating'
										. ' GROUP BY StanzaID)stanzaCounts'
										. ' WHERE Stanza.StanzaID = stanzaCounts.StanzaID AND Stanza.SongID = Song.SongID'
										. ' GROUP BY Song.Name)songCounts';
		$avg_ratings_per_song_result = mysql_query($avg_ratings_per_song_query);
		
		//gets the number of ratings per tag 
		$query = 'SELECT Word, count '
        . ' FROM Tag, (
				SELECT WordID, COUNT(UserID) AS count 
				FROM Rating GROUP BY WordID)ratings'
        . ' WHERE Tag.WordID = ratings.WordID LIMIT 0, 30 ';
		$result1 = mysql_query($query) or die(mysql_error());
		
		//echo all total number of ratings, avg number of ratings per stanza, and avg number of ratings per tag
		echo "Total No. Ratings: <b>" . round(mysql_result($num_ratings_total_result, 0), 2) . "</b></br>";
		echo "Avg. Ratings per Song: <b>" . round(mysql_result($avg_ratings_per_song_result, 0),2) . "</b></br>";
		echo "Avg. Ratings per Stanza: <b>" . round(mysql_result($avg_ratings_per_stanza_result, 0),2) . "</b></br>";
		
		$query =  'SELECT COUNT(UserID) FROM Rating ';
		$result = mysql_query($query) or die(mysql_error());
		$total = mysql_result($result,0,0);
		echo "<table border='1' font-size: 2em;>
		<tr>
		<th>Word</th>
		<th>Count</th>
		<th>Percent</th>
		</tr>";
		
		while($row = mysql_fetch_array($result1))
		{
			echo "<tr>";
			echo "<td>" . $row['Word'] . "</td>";
			echo "<td>" . $row['count'] . "</td>";
			echo "<td>" . round(($row['count']/$total)*100, 1) . "%</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	
 ?>