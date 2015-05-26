<?php
require_once('inc/global.inc.php');

$q_hostname=$_GET['q'];
$myip=gethostbyname($q_hostname);

if ($myip==$q_hostname) {echo "";}
else { echo  str_replace(CHR(13).CHR(10),"","$myip");}
?>