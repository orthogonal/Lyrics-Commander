<?php
require_once "db_login.php";
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database, $db_server); 

?>