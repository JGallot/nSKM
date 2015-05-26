<?php

require_once('inc/global.inc.php');

$smarty->assign("title","Host Setup");

$name = "";
$ip = "";
$id_hostgroup = "";
// Setting all variables 
$serialno = "";
$memory = "";
$osversion = "";
$cabinet = "";
$uloc = "";
$cageno = "";
$model = "";
$procno = "";
$provider = "";
$install_dt = "";
$po = "";
$cost = "";
$maint_cost = "";
$maint_po = "";
$maint_provider = "";
$maint_end_dt = "";
$life_end_dt = "";
$ostype = "";
$osvers = "";
$intf1 = "";
$intf2 = "";
$defaultgw = "";
$monitor = "";
$selinux = "";
$datechgroot = "";

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

if(isset($_POST["ns_lookup"]))
{
        $name=$_POST["name"];

        if(preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", gethostbyname($_POST["name"])) == 0)
        {
                $ip="Non-existent domain";
        }
        else $ip=gethostbyname($_POST["name"]);

        if (isset($_GET['id'])) $id = $_GET['id'];
        if (isset($_POST['id'])) $id = $_POST['id'];

	// Why get again values, what about what has been written by the user ?

        if (!empty($id))
        {
                $result = mysql_query( "SELECT * FROM `hosts` where `id`='$id'" )
                                or die (mysql_error()."<br>Couldn't execute query: $query");
                $row = mysql_fetch_array( $result );
                $name = $row["name"];
                $ip = $row["ip"];
                $id_hostgroup = $row["id_group"];
                // Setting all variables 
                $serialno = $row["serialno"];
                $memory = $row["memory"];
                $osversion = $row["osversion"];
                $cabinet = $row["cabinet"];
                $uloc = $row["uloc"];
                $cageno = $row["cageno"];
                $model = $row["model"];
                $procno = $row["procno"];
                $provider = $row["provider"];
                $install_dt = $row["install_dt"];
                $po = $row["po"];
                $cost = $row["cost"];
                $maint_cost = $row["maint_cost"];
                $maint_po = $row["maint_po"];
                $maint_provider = $row["maint_provider"];
                $maint_end_dt = $row["maint_end_dt"];
                $life_end_dt = $row["life_end_dt"];
                $ostype = $row["ostype"];
                $osvers = $row["osvers"];
                $intf1 = $row["intf1"];
                $intf2 = $row["intf2"];
                $defaultgw = $row["defaultgw"];
                $monitor = $row["monitor"];
                $selinux = $row["selinux"];
                $datechgroot = $row["datechgroot"];
        }

$smarty->assign('name',$name);
$smarty->assign('ip',$ip);
$smarty->assign('id',$id);
$smarty->assign('SKM_GLPI',$SKM_GLPI);

$smarty->display('hosts_setup.tpl');

}
elseif($step != '1' && !isset($_POST["ns_lookup"]))
{
        if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
        if (!empty($id))
        {
                // We modify an existing reminder
                $result = mysql_query( "SELECT * FROM `hosts` where `id`='$id'" )
                                or die (mysql_error()."<br>Couldn't execute query: $query");
                $row = mysql_fetch_array( $result );
                $name = $row["name"];
                $ip = $row["ip"];
                $id_hostgroup = $row["id_group"];
                // Setting all variables 
                $serialno = $row["serialno"];
                $memory = $row["memory"];
                $osversion = $row["osversion"];
                $cabinet = $row["cabinet"];
                $uloc = $row["uloc"];
                $cageno = $row["cageno"];
                $model = $row["model"];
                $procno = $row["procno"];
                $provider = $row["provider"];
                $install_dt = $row["install_dt"];
                $po = $row["po"];
                $cost = $row["cost"];
                $maint_cost = $row["maint_cost"];
                $maint_po = $row["maint_po"];
                $maint_provider = $row["maint_provider"];
                $maint_end_dt = $row["maint_end_dt"];
                $life_end_dt = $row["life_end_dt"];
                $ostype = $row["ostype"];
                $osvers = $row["osvers"];
                $intf1 = $row["intf1"];
                $intf2 = $row["intf2"];
                $defaultgw = $row["defaultgw"];
                $monitor = $row["monitor"];
                $selinux = $row["selinux"];
                $datechgroot = $row["datechgroot"];
        }

$smarty->assign('name',$name);
$smarty->assign('ip',$ip);
$smarty->assign('id',$id);
$smarty->assign('SKM_GLPI',$SKM_GLPI);

$smarty->display('hosts_setup.tpl');
}
else
{
    $id = $_POST['id'];
    // this is a new host
    $name = $_POST['name'];
    $ip = $_POST['ip'];
    $group = $_POST['group'];
    $serialno = $_POST["serialno"];
    $memory = $_POST["memory"];
    $osversion = $_POST["osversion"];
    $cabinet = $_POST["cabinet"];
    $uloc = $_POST["uloc"];
    $cageno = $_POST["cageno"];
    $model = $_POST["model"];
    $procno = $_POST["procno"];
    $provider = $_POST["provider"];
    $install_dt = $_POST["install_dt"];
    $po = $_POST["po"];
    $cost = $_POST["cost"];
    $maint_cost = $_POST["maint_cost"];
    $maint_po = $_POST["maint_po"];
    $maint_provider = $_POST["maint_provider"];
    $maint_end_dt = $_POST["maint_end_dt"];
    $life_end_dt = $_POST["life_end_dt"];
    $ostype = $_POST["ostype"];
    $osvers = $_POST["osvers"];
    $intf1 = $_POST["intf1"];
    $intf2 = $_POST["intf2"];
    $defaultgw = $_POST["defaultgw"];
    $monitor = $_POST["monitor"];
    $selinux = $_POST["selinux"];
    $datechgroot = $_POST["datechgroot"];

    if (empty($ip)||($ip=="")){
	// Do not save this guy !
	header("Location:hosts-setup");
      	echo ("NO ip !, redirecting...");
     }

    if(empty($id)){
   // this is a new host
      // No error let's add the entry
      $query = mysql_query( "INSERT INTO `hosts` (`name`,`ip`,`id_group`,`serialno`,`memory`,`osversion`,`cabinet`,`uloc`,`cageno`,`model`,`procno`,`provider`,`install_dt`,`po`,`cost`,`maint_cost`,`maint_po`,`maint_provider`,`maint_end_dt`,`life_end_dt`,`ostype`,`osvers`,`intf1`,`intf2`,`defaultgw`,`monitor`,`selinux`,`datechgroot`) VALUES('$name','$ip','$group','$serialno','$memory','$osversion','$cabinet','$uloc','$cageno','$model','$procno','$provider','$install_dt','$po','$cost','$maint_cost','$maint_po','$maint_provider','$maint_end_dt','$life_end_dt','$ostype','$osvers','$intf1','$intf2','$defaultgw','$monitor','$selinux','$datechgroot')" ) or die(mysql_error()."<br>Couldn't execute query: $query");
          $id = mysql_insert_id();
      // add account root (id 1) to created host
      mysql_query("INSERT INTO `hosts-accounts` (`id_host`,`id_account`) VALUES ('$id','1')");
      // add SKM Public Key (id 1) for user root on created host
      mysql_query("INSERT INTO `hak` (`id_host`,`id_account`,`id_key`) VALUES ('$id','1','1')");
      header("Location:hosts-view.php?id_hostgroup=$group");
      echo ("host Added, redirecting...");
      exit ();
    } else {
      // We modify an existing reminder
      // setting the variable for the update
      $name = $_POST['name'];
      mysql_query( "UPDATE `hosts` SET `name` = '$name',`ip`='$ip',`id_group`='$group',`serialno`='$serialno',`memory`='$memory',`osversion`='$osversion',`cabinet`='$cabinet',`uloc`='$uloc',`cageno`='$cageno',`model`='$model',`procno`='$procno',`provider`='$provider',`install_dt`='$install_dt',`po`='$po',`cost`='$cost',`maint_cost`='$maint_cost',`maint_po`='$maint_po',`maint_provider`='$maint_provider',`maint_end_dt`='$maint_end_dt',`life_end_dt`='$life_end_dt',`ostype`='$ostype',`osvers`='$osvers',`intf1`='$intf1',`intf2`='$intf2',`defaultgw`='$defaultgw',`monitor`='$monitor',`selinux`='$selinux',`datechgroot`='$datechgroot' WHERE `id` = '$id' " ) or die(mysql_error()."<br>Couldn't execute query: $query");
      // Let's go to the Reminder List page
      header("Location:host-view.php?id_hostgroup=$group&id=$id");
      echo ("host Modified, redirecting...");
      exit ();
    }
}
?>