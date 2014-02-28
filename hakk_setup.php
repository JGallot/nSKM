<?php

require_once('inc/global.inc.php');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["host_name"])) $host_name = $_GET["host_name"]; else $host_name = "";
if (isset($_GET["id_account"])) $id_account = $_GET["id_account"]; else $id_account = "";
if (isset($_GET["account_name"])) $account_name = $_GET["account_name"]; else $account_name = "";
if (isset($_GET["id_hostgroup"])) $id_hostgroup = $_GET["id_hostgroup"]; else $id_hostgroup = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

if($step != '1')
{

$smarty->assign('title',"Hosts - accounts - Key Association");

$smarty->assign('host_name',$host_name);
$smarty->assign('id_account',$id_account);
$smarty->assign('account_name',$account_name);
$smarty->assign('id_hostgroup',$id_hostgroup);
$smarty->assign('id',$id);

        // Display
        $all_keys=get_available_keys();
        $smarty->assign("allkeys",$all_keys);
        $smarty->display('hakk_setup.tpl');
}
else
{
  $error_list = "";
  if( empty( $error_list ) )
  {
    if (isset($_POST["id"])) $host_id = $_POST["id"]; else $host_id = "";
	if (isset($_POST["id_account"])) $account_id = $_POST["id_account"]; else $account_id = "";
	if (isset($_POST["key"])) $key_id = $_POST["key"]; else $key_id = "";
	if (isset($_POST["id_hostgroup"])) $id_hostgroup = $_POST["id_hostgroup"]; else $id_hostgroup = "";

    //echo ("account_name = $account_name, account_id = $account_id, host_id = $host_id");
    //echo ("Keyring id = $keyring_id, key id = $key_id");
    //die ("We stop here");

    mysql_query( "INSERT INTO `hak` (`id_host`, `id_account`, `id_key`,`expand`) VALUES('$host_id','$account_id','$key_id','Y')" ) or die(mysql_error()."<br>Couldn't execute query: insert host_id=$host_id, account_id=$account_id, key_id=$key_id [$query]");
    header("Location:host-view.php?id_hostgroup=$id_hostgroup&id=$host_id");
    echo ("key Added, redirecting...");
    exit ();
  }
  else
  {
    // Error occurred let's notify it
    echo( $error_list );
  }
}
?>
