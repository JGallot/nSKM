<?php
require_once('inc/global.inc.php');

$q_hostgroup=$_GET['q'];
$res=exists_hostgroup($q_hostgroup);

if ($res!=0) {echo "<font color='red'>Hostgroup<b>$q_groupname</b> already exists !</font><input name='dontSave' type='hidden' value=1>";}
else {echo "";}
?>