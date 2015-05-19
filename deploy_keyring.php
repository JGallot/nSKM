<?php
require_once('inc/global.inc.php');

$smarty->assign('title','nSKM - Keyring Deployment Process');

if (isset($_POST['id_keyring'])) $id_keyring = $_POST["id_keyring"]; else $id_keyring = "";
if (isset($_POST['step'])) $step = $_POST["step"]; else $step = "";

if (empty($id_keyring))
{
    // By default, display keyrings' list
    $keyrings = get_all_keyrings();
    $smarty->assign("keyrings",$keyrings);
    $smarty->display('deploy_keyring.tpl');
}
else
{
    $keyring_name = get_keyring_name($id_keyring);
    
  $error_list = "";
  if( empty( $error_list ) )
  {
    // On va cherche l'ensemble des comptes des serveurs qui contiennent le keyring demande...

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
  else
  {
    // Error occurred let's notify it
    echo( $error_list );
  }
}
?>

