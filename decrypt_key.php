<?php

require_once('inc/global.inc.php');

$smarty->assign("title","Decrypting Key");

if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";
if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["id_account"])) $id_account = $_GET["id_account"]; else $id_account = "";
if (isset($_GET["id_keyring"])) $id_keyring = $_GET["id_keyring"]; else $id_keyring = "";
if (isset($_GET["id_key"])) $id_key = $_GET["id_key"]; else $id_key = "";
if (isset($_GET["id_hostgroup"])) $id_hostgroup = $_GET["id_hostgroup"]; else $id_hostgroup = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";
if (isset($_POST["createUser"])) $create_user = $_POST["createUser"]; else $create_user = "";

if ( empty( $step ) )
{
$smarty->assign("id",$id);
$smarty->assign("id_account",$id_account);
$smarty->assign("id_keyring",$id_keyring);
$smarty->assign("id_key",$id_key);
$smarty->assign("id_hostgroup",$id_hostgroup);
$smarty->assign("action",$action);
$smarty->display("decrypt_key.tpl");

} else {
	// Decrypting key
	$passwd = $_POST['psPassword'];
	$id = $_POST['id'];
	$id_account = $_POST['id_account'];
	$id_hostgroup = $_POST['id_hostgroup'];
	$id_keyring = $_POST['id_keyring'];
	$id_key = $_POST['id_key'];
	$action = $_POST['action'];
        $clean = $_POST['cleanKnownHosts'];

	// Validating password
	$sResult = mysqli_query( $GLOBALS['mysql_link'],"Select id from `security` where `password` = MD5('$passwd')" ) 
		or die (mysqli_error()."<br>Couldn't execute query: $query");
	$sNumRow = $sResult->num_rows;

    	if (empty($sNumRow)) {
      		header("location:incorrect_key.php");
		
    	} else {
		// gpg --gen-key, then we enter Apache as user. The homedir is defined in config.inc.php
		// we encrypt the file with gpg --encrypt $home_of_webserver_account/.ssh/id_rsa and we select user Apache

		// We decrypt the key
		$output = shell_exec("echo \"$passwd\" | ".$gpg_bin." -v --batch --homedir ".
                        $home_of_webserver_account."/.gnupg -u $gpg_user -o ".$home_of_webserver_account."/.ssh/id_rsa "
                        . "--passphrase-fd 0 --decrypt --pinentry-mode loopback ".$home_of_webserver_account."/.ssh/id_rsa.gpg 2>&1");
                // we change permission on the file
		$output .= shell_exec("chmod 600 ".$home_of_webserver_account."/.ssh/id_rsa");
                
                // Check if private key exists
                if (file_exists($home_of_webserver_account."/.ssh/id_rsa")) {
                	$output .= "Decryption successfull";
        	} else {
			header("location:decrypt_key.php?action=deploy_account&id=$id&id_account=$id_account&id_hostgroup=$id_hostgroup");
        	}
                
		switch($action){

		case "deploy_account" :
			header("location:$action.php?id=$id&id_account=$id_account&id_hostgroup=$id_hostgroup&clean=$clean&create_user=$create_user");
			break;
		case "deploy_keyring" :
			header("location:$action.php?id_keyring=$id_keyring&id_hostgroup=$id_hostgroup&clean=$clean&step=2&create_user=$create_user");
			break;
		case "deploy_key" :
			header("location:$action.php?id_key=$id_key&id_hostgroup=$id_hostgroup&clean=$clean&create_user=$create_user");
			break;
		case "host_getinfo" :
			header("location:$action.php?id=$id&id_hostgroup=$id_hostgroup&clean=$clean");
			break;
		}
	}
}
