<?php
$db_hostname = 'lyricscommander.db.8271005.hostedresource.com';
$db_database = 'lyricscommander';
$db_username = 'lyricscommander';
$db_password = 'Meral341';

mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
mysql_select_db($db_database) OR DIE (mysql_error());

$key = "b25b959554ed76058ac220b7b2e0a026";
$artists = array("Bob Dylan");//,"LMFAO", "Adele");

foreach($artists as $artist)
{
	$artist = str_replace("'", "&#039;", $artist);
	print "$artist<hr>";
	$query = "SELECT ArtistID FROM Artist WHERE Name='$artist' LIMIT 1";
	$result = mysql_query($query) OR DIE (mysql_error());
	$artistID = null;
	if(($row = mysql_fetch_array($result)) == false)//insert artist if not inserted
	{
		$xml0 = new SimpleXMLElement(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=" . str_replace(" ", "%20", $artist) . "&api_key=$key"));
		$image = "";
		$bio = "";
		foreach($xml0->artist as $artistTemp)
		{
			foreach($artistTemp->image as $i)
			{
				$image = $i;
			}//want to assign last $i to $image... can't just access it like an array
			$bio = htmlspecialchars($artistTemp->bio->content);
		}
		
		$bio = str_replace("'", "&#039;", $bio);
		$query =  	"INSERT INTO Artist (Name, ImageURL, Bio)
					VALUES ('$artist', '$image', '$bio')";
		print "$query<hr>";
		$result = mysql_query($query) OR DIE (mysql_error());
		
		$query = "SELECT ArtistID FROM Artist WHERE Name='$artist' LIMIT 1";
		$result = mysql_query($query) OR DIE (mysql_error());
		$row = mysql_fetch_array($result);
		$artistID = $row["ArtistID"];
	}
	else
	{
		$artistID = $row["ArtistID"];
	}
	
	$xml1 = new SimpleXMLElement(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=" . str_replace(" ", "%20", $artist) . "&api_key=$key"));
	$countOfTracks = 0;
	foreach($xml1->toptracks->track as $track)
	{
		if($countOfTracks >= 5)//hardcoded limit for testing
			break;
		$countOfTracks++;
		$trackName = str_replace("'", "&#039;", $track->name);
		print $trackName;
		$xml2 = new SimpleXMLElement(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=track.getinfo&api_key=$key&artist=" . str_replace(" ", "%20", $artist) . "&track=" . str_replace(" ", "%20", $trackName)));

		$albumTitle = null;
		foreach($xml2->track->album as $album)
		{
			$albumTitle = str_replace("'", "&#039;", $album->title);
			break;
		}
		if($albumTitle == null)
		{
			$albumTitle = "Unknown Album";
		}
		print " - $albumTitle<hr>";
		
		$query = "SELECT AlbumID FROM Album WHERE Name='$albumTitle' LIMIT 1";
		$result = mysql_query($query) OR DIE (mysql_error());
		$albumID = null;
		if(($row = mysql_fetch_array($result)) == false)//insert album if not inserted
		{
			$coverURL = "";
			$xml3 = new SimpleXMLElement(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=album.search&api_key=$key&album=" . str_replace(" ", "%20", $albumTitle)));
			foreach($xml3->results->albummatches->album as $albumExtra)
			{
				if($albumExtra->name == $albumTitle && $albumExtra->artist == $artist)
				{
					foreach($albumExtra->image as $i)
					{
						$coverURL = $i;
					}//want to assign last $i to $image... can't just access it like an array
					break;
				}
			}
			
			$query =  	"INSERT INTO Album (Name, CoverURL)
						VALUES ('$albumTitle', '$coverURL')";
			print "$query<hr>";
			$result = mysql_query($query) OR DIE (mysql_error());
						
			$query = "SELECT AlbumID FROM Album WHERE Name='$albumTitle' LIMIT 1";
			$result = mysql_query($query) OR DIE (mysql_error());
			$row = mysql_fetch_array($result);
			$albumID = $row["AlbumID"];
		}
		else
		{
			$albumID = $row["AlbumID"];
		}
		
		$query = "SELECT SongID FROM Song WHERE Name='$trackName' LIMIT 1";
		$result = mysql_query($query) OR DIE (mysql_error());
		if(($row = mysql_fetch_array($result)) == false)//insert song if not inserted
		{
			$query =  	"INSERT INTO Song (AlbumID, ArtistID, Name)
						VALUES ($albumID, $artistID, '$trackName')";
			print "$query<hr>";
			$result = mysql_query($query) OR DIE (mysql_error());
			
			//TODO: fetch lyrics and insert into DB
		}
	}
}
?>