<?php

require_once('inc/global.inc.php');

if (isset($_GET["aix"])) $aix = $_GET["aix"]; else $aix = "";
if (isset($_GET["rhel"])) $rhel = $_GET["rhel"]; else $rhel = "";
if (isset($_GET["solaris"])) $solaris = $_GET["solaris"]; else $solaris = "";
if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";

$smarty->assign("title","All Hosts Overview");

$result = mysql_query( "SELECT * FROM `hosts` ORDER BY `name`" )
	 or die (mysql_error()."<br>Couldn't execute query: $query");

$nr = mysql_num_rows( $result );
if(empty($nr)) 
{
	echo("No hosts found ...\n");
}
else 
{
      $odd=1;
      while( $row = mysql_fetch_array( $result )) 
      {
        $id 			= $row["id"];
	$hosts[$id]['name']	= $row["name"];
	$hosts[$id]['ip']	= $row["ip"];
	$hosts[$id]['id_group']	= $row["id_group"];
	$hosts[$id]['ostype']	= $row["ostype"];
	$hosts[$id]['osvers']	= $row["osvers"];
	$hosts[$id]['monitor']	= $row["monitor"];
	$hosts[$id]['id_direction'] = $row["id_direction"];
	$hosts[$id]['serialno']	= $row["serialno"];
		  
		// displaying rows
		if ( $odd==1 )
			$odd=0;
		else
			$odd+=1;

		$hosts[$id]['odd'] = $odd;
		
		// getting the right icon
		switch($row['ostype'])
		{
			case "RHEL" : $icon="images/icon-redhat.gif"; break;
			case "AIX" : $icon="images/icon-aix.gif"; break;
			case "Solaris" : $icon="images/icon-solaris.gif"; break;
			case "Windows" : $icon="images/icon-windows.gif"; break;
			case "FreeBSD" : $icon="images/icon-freebsd.gif"; break;
			default : $icon="images/server.gif";
		}
		$hosts[$id]['icon'] = $icon;

    }
    mysql_free_result( $result );
}
$smarty->assign("hosts",$hosts);
$smarty->display('show_all_hosts.tpl');
?>
