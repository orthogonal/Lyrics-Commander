<?php
$artist = "KATIE MELUA";
$song = "piece by piece";
var_dump(getLyrics($artist,$song));

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