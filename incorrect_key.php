<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Decrypting key failed");
$smarty->assign("error_title","Password is incorrect");
$smarty->assign("error_detail","Please use the back button of your navigator and try again");

$smarty->display('error.tpl');
?>
