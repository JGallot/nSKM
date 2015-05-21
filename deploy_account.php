<?php

require_once('inc/global.inc.php');
include('Mail.php');
include('Mail/mime.php');

$smarty->assign("title","Deployment process");

$id = $_GET['id'];
$id_account = $_GET['id_account'];
$id_group = $_GET['id_hostgroup'];
$clean = $_GET['clean'];

if(!empty($id) and !empty($id_account))
{

$hostname = get_host_name($id);
$account_name = get_account_name($id_account); 

$smarty->assign("account_name",$account_name);
$smarty->assign("hostname",$hostname);
$smarty->assign("id",$id);
$smarty->assign("id_group",$id_group);

$output='';

// Clean Known-hosts if needed
  if ($clean)
  {
      $output.= "Cleaning SKM server Known_hosts File<br>";
      $output.= ssh_clean_known_hosts_file();
  }
list($res_conn,$mess_conn)= test_connection($hostname,$clean);

$output1.=$mess_conn;
// If connection works go on
if ($res_conn)
{
    $output1= prepare_authorizedkey_file($id,$id_account);
    $output2= deploy_authorizedkey_file($id,$id_account);
    $output.=$output1.$output2;
    
}
// Add results to display
$smarty->assign('output1',$output1);
$smarty->assign('output2',$output2);

if ($SKM_SEND_MAIL)
{
        $emailuser = $admin_email;

	$message = "Deploying <b>$account_name</b> to <b>$hostname</b>";
	$message = "$message<br><br>$output";

	$mime = new Mail_mime();

	$mime->setHTMLBody($message);

	if (strstr($message,"ok.gif")) $mime->addHTMLImage("images/ok.gif","image/gif");
	if (strstr($message,"warning.gif")) $mime->addHTMLImage("images/warning.gif","image/gif");
	if (strstr($message,"error.gif")) $mime->addHTMLImage("images/error.gif","image/gif");

	$hdrs = array(
              'From'    => "SKM <".$admin_email.">",
              'Subject' =>  "SKM: Deploying SSH-Key from $account_name to $hostname"
              );
	$body = $mime->get();
	$hdrs = $mime->headers($hdrs);
	$mail =& Mail::factory('mail');	

	$mail->send($emailuser, $hdrs, $body);
}

//We delete the private key file
$priv_key=$home_of_webserver_account."/.ssh/id_rsa";
if (file_exists($priv_key))
	unlink($priv_key);
// $smarty->assign("err_msg","ERROR : Private key file $priv_key can't be deleted");
} else {
	die("This page cannot be called without argument...");
}

$smarty->display('deploy_account.tpl');

?>
