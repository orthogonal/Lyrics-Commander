<?php
$query_type = $_GET["query"];
if($query_type == "Personal Tagging Data"){
	getPersonalTaggingData($username);
}
else if($query_type == "Last 2 Songs"){
	getLastSongs($username,2);
}
else if($query_type == "Last 5 Songs"){
	getLastSongs($username,5);
}
else if($query_type == "Last 10 Songs"){
	getLastSongs($username,10);
}
else if($query_type == "All Song Tags"){
	getTags();
}
else {
	echo $query_type;
}
?>