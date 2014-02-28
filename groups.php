<?php

require_once('inc/global.inc.php');

$smarty->assign("title","Group List");

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
$smarty->assign("id",$id);

if( empty($id) )
{
$smarty->assign('id',$id);
$smarty->assign("tab_groups",$hostgroups);

$smarty->display('groups.tpl');
}
else
{
  if ( $_GET['action'] == "delete" )
  {
    mysql_query( "DELETE FROM `groups` WHERE `id`='$id'" );
    // Let's go back to the Reminder List page
    header("Location:groups.php");
    exit ();
  }
}
?>

