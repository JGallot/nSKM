<?php

require_once('inc/global.inc.php');
include('Mail.php');
include('Mail/mime.php');

$smarty->assign("title","Deployment process");

$id = $_GET['id'];
$id_account = $_GET['id_account'];
$id_group = $_GET['id_hostgroup'];
$clean = $_GET['clean'];
$create_user = $_GET['create_user'];
$output1 = '';
$output2 = '';

if(!empty($id) and !empty($id_account))
{
    $hostname = get_host_name($id);
    $account_name = get_account_name($id_account); 
    $ssh_port = get_host_ssh_port($id);

    $smarty->assign("account_name",$account_name);
    $smarty->assign("hostname",$hostname);
    $smarty->assign("id",$id);
    $smarty->assign("id_group",$id_group);

    $output='';

    // Clean Known-hosts if needed
      if ($clean==1)
      {
          $output_clean.= ssh_clean_known_hosts_file($hostname,get_host_ip($id));
          $output.=$output_clean;
          $smarty->assign('output_clean',$output_clean);
      }
    list($res_conn,$mess_conn)= test_connection($hostname,$clean,$ssh_port);

    // If connection works go on
    if ($res_conn)
    {
        $id_run=rand();    
        $output1= prepare_authorizedkey_file($id,$id_account,$id_run);
        $output2= deploy_authorizedkey_file($id,$id_account,$id_run,$create_user);
        $output.=$output1.$output2;

    }
    // Add results to display
    $smarty->assign('output1',$mess_conn.$output1);
    $smarty->assign('output2',$output2);

    if ($SKM_SEND_MAIL)
    {
            $emailuser = $email_to;

            $message = "Deploying <b>$account_name</b> to <b>$hostname</b>";
            $message = "$message<br><br>$output";

            $mime = new Mail_mime();

            $mime->setHTMLBody($message);

            preg_match_all('@(.*)images/(.*).gif(.*)@i',$message,$matches);
            
            $img=array_unique($matches[2]);
            foreach ($img as $key=>$value) {
                $mime->addHTMLImage("images/$value.gif","image/gif");
            }
            $hdrs = array(
                  'From'    => "SKM <".$email_from.">",
                  'Subject' =>  "SKM: Deploying SSH-Key from $account_name to $hostname"
                  );
            $body = $mime->get();
            $hdrs = $mime->headers($hdrs);
            $mail =& Mail::factory('mail',"-f $email_from");	

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
