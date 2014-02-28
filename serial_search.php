<?php 

require_once('inc/global.inc.php');

$smarty->assign("title","Searching for a host serial number");

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";
$smarty->assign("step",$step);
if($step != '')
{
  $serial = $_POST["serial"];
  $smarty->assign("serial",$serial);
  $serialsearch = "%"."$serial"."%";

  $result = mysql_query( "SELECT * FROM `hosts` where `serialno` LIKE '$serialsearch' ORDER BY `name`" )
	or die (mysql_error()."<br>Couldn't execute query: $query");

	$even = 0;
	$nr = mysql_num_rows( $result );
	while( $row = mysql_fetch_array( $result ))
      	{
		$id=$row['id'];
		$hosts[$id]['id_group']	=$row['id_group'];
		$hosts[$id]['name']	=$row['name'];
		$hosts[$id]['serialno']	=$row['serialno'];
		$hosts[$id]['os']=$row['osversion'];
		$hosts[$id]['procno']	=$row['procno'];
		$hosts[$id]['provider']	=$row['provider'];

	        if ( $even == 0) { $even++; } else { $even=0; }
		$hosts[$id]['even']=$even;
	}
	$smarty->assign("hosts",$hosts);
}

$smarty->display('serial_search.tpl');
?>
