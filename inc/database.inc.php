<?php
// Todo add error control
$mysql_link = mysqli_connect("$mysql_host:$mysql_port", $mysql_user, $mysql_pass,$mysql_db);

if (!$mysql_link)
	die("Could not select database : $mysql_db");
$GLOBALS['mysql_link']=$mysql_link;

?>
