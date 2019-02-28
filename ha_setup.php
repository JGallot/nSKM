<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Hosts - Accounts Association");

if (isset($_GET["id"])) $id_host = $_GET["id"]; else $id_host = "";
if (isset($_GET["host_name"])) $host_name = $_GET["host_name"]; else $host_name = "";
if (isset($_GET["id_hostgroup"])) $id_hostgroup = $_GET["id_hostgroup"]; else $id_hostgroup = "";
if (isset($_POST["account"])) $id_account = $_POST["account"]; else $id_account = "";

$smarty->assign("id_host",$id_host);
$smarty->assign("host_name",$host_name);
$smarty->assign("id_hostgroup",$id_hostgroup);
$smarty->assign("account",$id_account);

$mysql_link=$GLOBALS['mysql_link'];

// We get the list of accounts
$result = mysqli_query( $mysql_link,"SELECT * FROM `accounts`" );

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";
if($step != '1')
{
	$accounts=get_all_accounts();
	$smarty->assign("accounts",$accounts);
	$smarty->display('ha_setup.tpl');
}
else
{
  $error_list = "";
  if( empty( $error_list ) )
  {
	$id_host = $_POST['id'];
	$id_hostgroup = $_POST['id_hostgroup'];

	mysqli_query($mysql_link, "INSERT INTO `hosts-accounts` (`id_host`, `id_account`, `expand`) VALUES('$id_host','$id_account','Y')" ) 
		or die(mysqli_error($mysql_link)."<br>Couldn't execute query");
    header("Location:host-view.php?id_hostgroup=$id_hostgroup&id=$id_host");
    echo ("account Added, redirecting...");
    exit ();
  }
  else
  {
    echo( $error_list );
  }
}
?>
