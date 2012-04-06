<?php
$db_hostname = 'lyricscommander.db.8271005.hostedresource.com';
$db_database = 'lyricscommander';
$db_username = 'lyricscommander';
$db_password = 'Meral341';

mysql_connect($db_hostname,$db_username, $db_password) OR DIE (mysql_error());
mysql_select_db($db_database) OR DIE (mysql_error());

$key = "b25b959554ed76058ac220b7b2e0a026";
$artists = array("Bob Dylan","LMFAO", "Adele");

foreach($artists as $artist)
{
	print "$artist<br>";
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
	print "<hr>$query<hr>";
	$result = mysql_query($query) OR DIE (mysql_error());
	
	$xml1 = new SimpleXMLElement(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=" . str_replace(" ", "%20", $artist) . "&api_key=$key"));
	foreach($xml1->toptracks->track as $track)
	{
		$trackName = $track->name;
		print $trackName;
		$xml2 = new SimpleXMLElement(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=track.getinfo&api_key=$key&artist=" . str_replace(" ", "%20", $artist) . "&track=" . str_replace(" ", "%20", $trackName)));
		$count = 0;
		foreach($xml2->track->album as $album)
		{
			$count++;
			$albumTitle = $album->title;
			print " - $albumTitle<br>";
			
			//WRITE QUERIES TO INSERT NEW ALBUMS, SONGS, AND LYRICS
		}
		if($count == 0)
		{
			print " - NO ALBUM<br>";
		}
	}
	print "----------------------------------------<br>";
}
?>