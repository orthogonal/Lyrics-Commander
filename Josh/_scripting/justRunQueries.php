<?php
require_once "../../db_login.php";
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database, $db_server); 

$data = file_get_contents("queries.html");
$queries = split("<hr>",$data);
foreach($queries as $q)
{
	if($q == "")	continue;
	mysql_query($q) OR die(mysql_error());
}
?>