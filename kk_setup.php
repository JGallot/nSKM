<?php

require_once('inc/global.inc.php');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["keyring_name"])) $keyring_name = $_GET["keyring_name"]; else $keyring_name = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

$smarty->assign("keyring_id",$id);
$smarty->assign("keyring_name",$keyring_name);

$smarty->assign("title","Keyrings and keys Association");

if($step != '1')
{
	$all_keys=get_available_keys();
	$smarty->assign("allkeys",$all_keys);
	$smarty->display('kk-setup.tpl');
}
else
{
  $error_list = "";
  if( empty( $error_list ) )
  {
    $keyring_id = $_POST['id'];
    $key_id = $_POST['key'];

    mysqli_query($GLOBALS['mysql_link'], "INSERT INTO `keyrings-keys` (`id_keyring`, `id_key`) VALUES('$keyring_id','$key_id')" )
               or die(mysqli_error()."<br>Couldn't execute query: $query");
    header("Location:keyrings.php");
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
