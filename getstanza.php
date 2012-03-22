<?php	//getstanza.php
	require_once "db_login.php";
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db($db_database, $db_server); 
	//Script is now connected to the MySQL database
	
	$stanzaID = $_POST['stanzaID'];
	
	$query = "SELECT * 
			  FROM `Stanza` 
			  WHERE `StanzaID` = $stanzaID";
	$result = mysql_query($query) or die("&?" . mysql_error() . "\nLine: " . __LINE__ . "\nQuery was: " . $query);		//If there is a MySQL error, the output will have a "&?" substring in it.
	$row = mysql_fetch_row($result);								//0:  StanzaID	1:  SongID	2:  Text
	
	echo "$row[2]" . "&";											//Output the stanza followed by the delimiter "&" (no stanza should have a "&" in it).
	
	$songID = $row[1];
	
	$query = "SELECT *
			  FROM `Song`
			  WHERE `SongID` = $songID";
	$result = mysql_query($query) or die("?" . mysql_error() . "\nLine: " . __LINE__ . "\nQuery was: " . $query);
	$row = mysql_fetch_row($result);								//0:  SongID  1:  AlbumID  2:  ArtistID  3:  Name
	
	echo "$row[3]" . "&";											//Output the name of the song the stanza is from
	
	$albumID = $row[1];
	$artistID = $row[2];
	
	$query = "SELECT *
			  FROM `Album`
			  WHERE `AlbumID` = $albumID";
	$result = mysql_query($query) or die("?" . mysql_error() . "\nLine: " . __LINE__ . "\nQuery was: " . $query);
	$row = mysql_fetch_row($result);								//0:  AlbumID  1:  Name  2:  CoverURL
	
	echo "$row[1]" . "&";											//Output the name of the album the song is from
	echo "$row[2]" . "&";											//Output the URL of the cover image of the album (note: this had better not have a "&" in it)
	
	$query = "SELECT *
			  FROM `Artist`
			  WHERE `ArtistID` = $artistID";
	$result = mysql_query($query) or die("?" . mysql_error() . "\nLine: " . __LINE__ . "\nQuery was: " . $query);
	$row = mysql_fetch_row($result);								//0:  ArtistID  1:  Name  2:  ImageURL  3:  Bio
	
	echo "$row[1]" . "&";											//Output the artist name (note:  no "&" is allowed, so i.e. "Simon & Garfunkel" should be "Simon and Garfunkel")
	echo "$row[2]" . "&";											//Output the URL of the artist image (again, no "&")
	echo "$row[3]";													//Output the biography of the artist
	
	/*	In conclusion:
		0:  Stanza text
		1:  Song name
		2:  Album
		3:  Album URL
		4:  Artist name
		5:  Artist URL
		6:  Artist biography
		Delimiter is "&"
		Output will have "&?" in it if there is an error, followed by the error, with nothing after that.
		*/
	
	mysql_close($db_server);
?>