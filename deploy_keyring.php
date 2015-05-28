<?php
require_once('inc/global.inc.php');

include('Mail.php');
include('Mail/mime.php');

$smarty->assign('title','nSKM - Keyring Deployment Process');

if (isset($_POST['id_keyring'])) $id_keyring = $_POST["id_keyring"];
    elseif (isset($_GET['id_keyring'])) $id_keyring=$_GET['id_keyring'];
    else $id_keyring = "";
if (isset($_POST['step'])) {$step = $_POST["step"];} else {$step = "";}
if (isset($_GET['step'])) {$step2 = $_GET["step"];} else {$step2 = "";}

if (isset($_GET['clean'])) {$clean = $_GET['clean'];} else {$clean = "";}
if (isset($_GET['create_user'])) $create_user=$_GET['create_user']; else $create_user='';

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

          $output='';
          while( $row = mysql_fetch_array( $result ))
          {
                // Affecting values
                $id_host = $row['id_host'];
                $id_account = $row['id_account'];
                $hostname = get_host_name($id_host);
                $account_name = get_account_name($id_account);

                $hosts[$id_host]['accounts'][$id_account]['name'] = $account_name;
                $hosts[$id_host]['name'] = get_host_name($id_host);
                $smarty->assign('keyring_name',$keyring_name);
                               
                // Clean Known-hosts if needed
                if ($clean==1)
                {
                    $output_clean= ssh_clean_known_hosts_file($hostname,get_host_ip($id_host));
                    $hosts[$id_host]['accounts'][$id_account]['result_clean']=$output_clean;
                }
                //
                list($res_conn,$mess_conn)= test_connection($hostname,$clean);
                
                // If connection works go on
                if ($res_conn)
                {
                    $output1=prepare_authorizedkey_file($id_host,$id_account);
                    $hosts[$id_host]['accounts'][$id_account]['result1']=$mess_conn.$output1;
                    
                    $output2= deploy_authorizedkey_file($id_host,$id_account,$create_user);
                    $hosts[$id_host]['accounts'][$id_account]['result2']=$output2;
                } else {
                    $hosts[$id_host]['accounts'][$id_account]['result1']=$mess_conn.$output1;
                    $hosts[$id_host]['accounts'][$id_account]['result2']=$output2;
                }
          }
          //We delete the private key file
          $priv_key=$home_of_webserver_account."/.ssh/id_rsa";
          if (file_exists($priv_key))
          unlink($priv_key);
          $smarty->assign('hosts',$hosts);
          $smarty->display('deploy_keyring_done.tpl');
          
          // Sending mail
        if ($SKM_SEND_MAIL)
        {            
            $message='';
            $emailuser = $admin_email;

            foreach ($hosts AS $host) {
                $message.= "<h4>Deploying Keyring <b><i>$keyring_name</i></b> on ".$host['name']."</h4>";
                foreach ($host['accounts'] AS $account) {
                if ($clean==1) {$message.= $output_clean;}
                $message.= $account['result1'];
                $message.= $account['result2'];
                $message.= "<br>";
                }
            }
            $mime = new Mail_mime();

            $mime->setHTMLBody($message);

            if (strstr($message,"ok.gif")) $mime->addHTMLImage("images/ok.gif","image/gif");
            if (strstr($message,"warning.gif")) $mime->addHTMLImage("images/warning.gif","image/gif");
            if (strstr($message,"error.gif")) $mime->addHTMLImage("images/error.gif","image/gif");

            $hdrs = array(
                  'From'    => "SKM <".$admin_email.">",
                  'Subject' =>  "SKM: Deploying Keyring $keyring_name"
                  );
            $body = $mime->get();
            $hdrs = $mime->headers($hdrs);
            $mail =& Mail::factory('mail');	

            $mail->send($emailuser, $hdrs, $body);
        }
    }
    else header("Location:decrypt_key.php?action=deploy_keyring&id_keyring=$id_keyring");
}
?>