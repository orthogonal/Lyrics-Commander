<?php
for($count = 1; $count <= 100; $count++)
{
	$data = file_get_contents("http://www.last.fm/music?page=$count");

	$start = 0;	
	while(($start = strpos($data, "<strong class=\"name\">", $start)) !== false)
	{
		$start += strlen("<strong class=\"name\">");
		$end = strpos($data, "</strong>", $start);
		$artist = substr($data, $start, $end - $start);
		print $artist . "\n";
	}
}
?>