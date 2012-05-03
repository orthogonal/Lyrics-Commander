<?php
$key = "b25b959554ed76058ac220b7b2e0a026";

$artists = split("\n", file_get_contents("artists.txt"));
//$artists = array_reverse($artists);
$artistCounter = 1;
$albumCounter = 1;
$trackCounter = 1;
$stanzaCounter = 1;

$testLimit = 1000;//artist limit
$testTrackLimit = 5;//track limit
$testStanzaLimit = 1;//stanza limit

$counter = 0;
foreach($artists as $artist)
{
	if($artist == "")	continue;
	//if($counter == 500)
		//$testTrackLimit = 1; //reduce track limit for more popular artists
	
	$artistCopy = str_replace("'", "\\'", $artist);
	$query = "SELECT ArtistID FROM Artist WHERE Name='$artistCopy' LIMIT 1";
	$artistID = $artistCounter;
	
	$xml0 = new SimpleXMLElement(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=" . str_replace(" ", "%20", $artistCopy) . "&api_key=$key"));
	$image = "";
	//$bio = "";
	foreach($xml0->artist as $artistTemp)
	{
		foreach($artistTemp->image as $i)
		{
			$image = $i;
		}//want to assign last $i to $image... can't just access it like an array
		//$bio = $artistTemp->bio->content;
		//$bio = htmlspecialchars($artistTemp->bio->content);
	}
	
	//$bio = str_replace("'", "\\'", $bio);
	$query =  	"INSERT INTO Artist (Name, ImageURL)
				VALUES ('$artistCopy', '$image')";
	print "$query<hr>";
	$artistCounter++;
	
	$xml1 = new SimpleXMLElement(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=" . str_replace(" ", "%20", $artist) . "&api_key=$key"));
	$countOfTracks = 0;
	foreach($xml1->toptracks->track as $track)
	{
		$trackName = str_replace("'", "\\'", $track->name);
		$xml2 = new SimpleXMLElement(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=track.getinfo&api_key=$key&artist=" . str_replace(" ", "%20", $artistCopy) . "&track=" . str_replace(" ", "%20", $trackName)));

		$albumTitle = null;
		foreach($xml2->track->album as $album)
		{
			$albumTitle = str_replace("'", "\\'", $album->title);
			break;
		}
		if($albumTitle == null)
		{
			$albumTitle = "Unknown Album";
		}
		$albumID = $albumCounter;

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
		$albumCounter++;
		
		//now get trackID
		$trackID = $trackCounter;
		
		$query =  	"INSERT INTO Song (AlbumID, ArtistID, Name)
					VALUES ($albumID, $artistID, '$trackName')";
		print "$query<hr>";
		$trackCounter++;		
			

		
		sleep(30);	//space out crawling of azlyrics
		$stanzas = getLyrics($artist, $trackName);
		if(count($stanzas) == 0)
		{
			break; //skip rest of top tracks if cannot find lyrics for one track	
		}
		
		$stanzaCounter = 0;
		foreach($stanzas as $s)
		{
			//$s = htmlspecialchars($s);
			$s = str_replace("'", "\\'", $s);
			$query =  	"INSERT INTO Stanza (SongID, Text)
					VALUES ($trackID, '$s')";
			print "$query<hr>";
			$stanzaCounter++;
			if($stanzaCounter >= $testStanzaLimit)
				break;
		}

		$countOfTracks++;		
		if($countOfTracks >= $testTrackLimit)//hardcoded limit for testing
			break;
	}
	$counter++;
	if($testLimit != -1 && $counter >= $testLimit)
		break;
		
	//file_put_contents("trackProgressCounter.txt", $counter);
}


function urlOfLyrics($artist, $song)
{
	$charactersToCut = array(" ","'",",","(",")",".","+");
	
	$artist = strtolower($artist);
	foreach($charactersToCut as $c)
		$artist = str_replace($c,"",$artist);
	$song = strtolower($song);	
	foreach($charactersToCut as $c)
		$song = str_replace($c,"",$song);
	
	if(strpos($song, "the") === 0)	$song = substr($song, 3);
	return "http://www.azlyrics.com/lyrics/$artist/$song.html";
}
function getLyrics($artist,$song)
{
	$data = file_get_contents(urlOfLyrics($artist, $song));
	$startOfLyrics = strpos($data, "<!-- start of lyrics -->");
	if($startOfLyrics === false)	return null;
	$startOfLyrics += strlen("<!-- start of lyrics -->") + 2;
	$endOfLyrics = strpos($data, "<!-- end of lyrics -->");
	$stanzas = explode("<br>\n<br>\n", substr($data, $startOfLyrics, $endOfLyrics - $startOfLyrics));
	if(count($stanzas) == 1) $stanzas = explode("<br>\r\n<br>\r\n", substr($data, $startOfLyrics, $endOfLyrics - $startOfLyrics));
	return $stanzas;
}

?>