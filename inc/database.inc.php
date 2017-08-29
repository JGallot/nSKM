<?php
// Todo add error control
$mysql_link = mysql_connect("$mysql_host:$mysql_port", $mysql_user, $mysql_pass);

mysql_select_db($mysql_db) or die("Could not select database : $mysql_db");


?>