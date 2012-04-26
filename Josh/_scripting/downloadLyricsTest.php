<?php
$artist = "Bob Dylan";
$song = "Like A Rolling Stone";
var_dump(getLyrics($artist,$song));

function urlOfLyrics($artist, $song)
{
	$charactersToCut = array(" ","'",",","(",")",".");
	
	$artist = strtolower($artist);
	foreach($charactersToCut as $c)
		$artist = str_replace($c,"",$artist);
	$song = strtolower($song);	
	foreach($charactersToCut as $c)
		$song = str_replace($c,"",$song);
	
	return "http://www.azlyrics.com/lyrics/$artist/$song.html";
}
function getLyrics($artist,$song)
{
	$data = file_get_contents(urlOfLyrics($artist, $song));
	$startOfLyrics = strpos($data, "<!-- start of lyrics -->");
	if($startOfLyrics === false)	return null;
	$startOfLyrics += strlen("<!-- start of lyrics -->") + 2;
	$endOfLyrics = strpos($data, "<!-- end of lyrics -->");
	$stanzas = explode("<br>\r\n<br>\r\n", substr($data, $startOfLyrics, $endOfLyrics - $startOfLyrics));
	return $stanzas;
}
?>