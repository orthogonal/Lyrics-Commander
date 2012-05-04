<?php
include("dynamic_queries.php");
include("static_queries.php");
$username = stripslashes($_POST['username']);
$query_type = stripslashes($_POST['query']);
$emotion = stripslashes($_POST['emotion']);
if($query_type == "Top Songs by Emotion"){
	getTopSongs($emotion);
	}
else if($query_type == "Personal Tagging Data"){
	getPersonalTaggingData($username);
}
else if($query_type == "Global Tagging Data"){
	getGlobalTaggingData();
}
else if($query_type == "Artist Tagging Data"){
	getArtistTaggingData($username);
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
else if($query_type == "Friends"){
	getFriendsData($username);
}
else if($query_type == "All Song Tags"){
	getTags();
}
else {
	
}
?>