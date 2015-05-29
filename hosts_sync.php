<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Synchronize hosts list");

if ($_POST['step']!=1)
{
    // Get list of servers on repository server
    // Wich kind of repo ??? 1 = foreman
    // Get hosts
    $context = stream_context_create(array (
        'http' => array (
            'header' => 'Authorization: Basic ' . base64_encode("$SKM_REPO_USER:$SKM_REPO_PASS")
        )
    ));
    // Use FOREMAN API V2 with 1 000 results per page
    $json=file_get_contents($SKM_REPO_URL.'/api/hosts?per_page=1000',false, $context);
    $hosts = json_decode($json,true);

    foreach ($hosts AS $idex => $host)
    {
        // Get Foreman information of host
        $json_hosts_details=file_get_contents($SKM_REPO_URL.'/api/hosts/'.$host['host']['id'].'?format=json',false, $context);
        $hosts_details = json_decode($json_hosts_details,true);  

        $repo_hosts[$idex]['name']=$hosts_details['host']['certname'];
        $repo_hosts[$idex]['ip']=$hosts_details['host']['ip'];
        $repo_hosts[$idex]['icon']="images/server.gif";
    }
    // Get existing hosts in nSKM
    $actual_hosts=get_all_hosts();

    // Determine if hosts are new
    foreach($repo_hosts AS $idx => $myhost){
       $check_name=$myhost['name'];
        if (recursive_array_search($check_name,$actual_hosts)==false) {
            $hosts_2_add[]=$myhost;
        }
    }
    // Determine if hosts are too old
    foreach($actual_hosts AS $idx => $myhost){
        $check_name=$myhost['name'];
        if (recursive_array_search($check_name,$repo_hosts)==false) {
            $hosts_2_delete[$idx]=$myhost;
        }
    }
    $smarty->assign("hosts_2_add",$hosts_2_add);
    $smarty->assign("hosts_2_delete",$hosts_2_delete);
     
    // Let's display information !
    $smarty->display('hosts_sync.tpl');
}
else
{   // step is specify so delete/add hosts
    $hosts_2_add=$_POST['addhosts'];
    $hosts_2_delete=$_POST['deletehosts'];

    // Add new hosts
    foreach($hosts_2_add AS $idx => $hostname) {
        $ip=gethostbyname($hostname);
        $res_add=add_host($hostname,$ip);
        
        if (!isset($res_add)) {
            $result[$hostname]['message'] = 'Added';
            $result[$hostname]['statut']='ok';
        }
        else {
            $result[$hostname]['message']= 'Not Added :'.$res_add;
            $result[$hostname]['statut']='error';
        }
    }
    
    // Delete old hosts    
    foreach($hosts_2_delete AS $idx => $host_id) {
        $hostname=get_host_name($host_id);
        $res_del=delete_host($host_id);
        if (!isset($res_del)) {
            $result[$hostname]['message'] = 'Deleted';
            $result[$hostname]['statut']='ok';
        }
        else {
            $result[$hostname]['message']= 'Not deleted :'.$res_del;
            $result[$hostname]['statut']='error';
        }
    }    
    $smarty->assign("result",$result);
    
    // Let's display information !
    $smarty->display('hosts_sync_done.tpl');
}

?>