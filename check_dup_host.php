<?php
require_once('inc/global.inc.php');

$q_hostname=$_GET['q'];
$res=exists_hostname($q_hostname);

if ($res!=0) {echo "<font color='red'>Hostname <b>$q_hostname</b> already exists !</font><input name='dontSave' type='hidden' value=1>";}
else {echo "";}
?>