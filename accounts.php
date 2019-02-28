<?php

require_once('inc/global.inc.php');
$smarty->assign('title','Accounts List');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";

if( empty($id) )
{
   	$accounts=get_all_accounts();
	$smarty->assign('accounts',$accounts);
	$smarty->display('accounts.tpl');
}
else
{
  // deletion of root account (id 1) is not allowed
  if (($_GET['action'] == "delete") && ($id > 1))
  {
    mysqli_query($mysql_link, "DELETE FROM `accounts` WHERE `id`='$id'" );
    mysqli_query($mysql_link, "DELETE FROM `hosts-accounts` WHERE `id_account`='$id'" );
    mysqli_query($mysql_link, "DELETE FROM `hak` WHERE `id_account`='$id'" );
    // Let's go back to the Reminder List page
    header("Location:accounts.php");
    echo ("account deleted, redirecting...");
    exit ();
  }
}
?>
