<?php
require_once('inc/global.inc.php');
$keyrings = get_all_keyrings();

$smarty->assign("title","SKM - Display Host Details");

if (isset($_GET["id_keyring"])) $id_keyring = $_GET["id_keyring"]; else $id_keyring = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

if ( $step != "1")
{
// display
$smarty->assign("keyrings",$keyrings);
$smarty->display('deploy_keyring.tpl');

}
else
{
  $error_list = "";
  if( empty( $error_list ) )
  {
    $id_keyring = $_POST['keyring'];

    header("Location:decrypt_key.php?action=deploy_keyring&id_keyring=$id_keyring");
    exit ();
  }
  else
  {
    // Error occurred let's notify it
    echo( $error_list );
  }
}
?>

