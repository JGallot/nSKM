<?php
require_once('inc/global.inc.php');

$smarty->assign('title','nSKM - Keyring Deployment Process');

if (isset($_POST['id_keyring'])) $id_keyring = $_POST["id_keyring"];
    elseif (isset($_GET['id_keyring'])) $id_keyring=$_GET['id_keyring'];
    else $id_keyring = "";
if (isset($_POST['step'])) $step = $_POST["step"]; else $step = "";
if (isset($_GET['step'])) $step2 = $_GET["step"]; else $step2 = "";

if (empty($id_keyring))
{
    // If no keyring specify, display keyrings' list
    $keyrings = get_all_keyrings();
    $smarty->assign("keyrings",$keyrings);
    $smarty->display('deploy_keyring.tpl');
}
else
{
    if ($step2==2)
    {
        $keyring_name = get_keyring_name($id_keyring);

          $result = mysql_query( "SELECT * FROM `hak` where `id_keyring` = '$id_keyring' ORDER BY `id_host`" )
                               or die (mysql_error()."<br>Couldn't execute query: $query");
          $nr = mysql_num_rows( $result );

          while( $row = mysql_fetch_array( $result ))
          {
              $smarty->assign('keyring_name',$keyring_name);

              // Afecting values
              $id_host = $row['id_host'];
              $id_account = $row['id_account'];
              $hostname = get_host_name($id_host);
              $account_name = get_account_name($id_account);

              $hosts[$id_host]['accounts'][$id_account]['name'] = $account_name;
              $hosts[$id_host]['name'] = get_host_name($id_host);

              $output = prepare_authorizedkey_file($id_host,$id_account);
              $hosts[$id_host]['accounts'][$id_account]['result1']=$output;

              $output2 = deploy_authorizedkey_file($id_host,$id_account);
              $hosts[$id_host]['accounts'][$id_account]['result2']=$output2;
          }
          $smarty->assign('hosts',$hosts);
          $smarty->display('deploy_keyring_done.tpl');
    }
    else header("Location:decrypt_key.php?action=deploy_keyring&id_keyring=$id_keyring");
}
?>

