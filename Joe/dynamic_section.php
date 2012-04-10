<html>
<body>
<p1>Select Statistic To Display</p1>
<form action = "Statistics.php" method = "get">
	<select name = "query">
		<option>Personal Tagging Data</option>
		<option>Last 2 Songs</option>
		<option>Last 5 Songs</option>
		<option>Last 10 Songs</option>
		<option>All Song Tags</option>
	</select>
	<input type = "submit" value = "Select"/>
</form>
</br>
<?php
if($_GET['query']<> ""){
	include("display_query.php");
}
else{
}
?>
</body>
</html>