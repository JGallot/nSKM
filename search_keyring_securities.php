<?php
require_once('inc/global.inc.php');

$smarty->assign('title','Keyring Security Search');

if (isset($_GET["keyring"])) $id_keyring = $_GET["keyring"]; else $id_keyring = "";
if (isset($_POST["keyring"])) $id_keyring = $_POST["keyring"]; else $id_keyring = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

if($step != '1')
{
$keyrings=get_all_keyrings();
$smarty->assign('keyrings',$keyrings);
$smarty->display('search_keyring_securities.tpl');
}
else
{
// We will seek all accounts of the servers that contain the keyring application ...

$keyring_name = get_keyring_name($id_keyring); 
$result = mysqli_query($mysql_link, "SELECT * FROM `hak` where `id_keyring` = '$id_keyring' ORDER BY `id_host`" )
                         or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");

 $smarty->assign('keyring_name',$keyring_name);
    while( $row = mysqli_fetch_array( $result ))
    {
        // Afecting values
        $id_host = $row["id_host"];
        $id_account = $row["id_account"];

        $hostname = get_host_name($id_host);
        $account_name = get_account_name($id_account);
	$hosts[$id_host]['accounts'][$id_account]=$account_name;
	$hosts[$id_host]['name']=$hostname;
    }
$smarty->assign('hosts',$hosts);
$smarty->display('search_keyring_securities.tpl');
}
?>
