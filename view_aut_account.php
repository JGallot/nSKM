<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Deployment process");


$id = $_GET['id'];
$id_account = $_GET['id_account'];
$id_hostgroup = $_GET['id_hostgroup'];


if(!empty($id) and !empty($id_account))
{
$smarty->assign('id',$id);
$smarty->assign('id_hostgroup',$id_hostgroup);

$hostname = get_host_name($id);
$account_name = get_account_name($id_account); 

$smarty->assign('hostname',$hostname);
$smarty->assign('account_name',$account_name);

$output = prepare_authorizedkey_file($id,$id_account); 
$smarty->assign('output1',$output);

$output = view_authorizedkey_file($id,$id_account); 
$smarty->assign('output2',$output);

$smarty->display('view_aut_account.tpl');
}

?>
