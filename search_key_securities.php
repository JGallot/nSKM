<?php
require_once('inc/global.inc.php');

$smarty->assign("title","SKM - Key Security Search");

if (isset($_GET["key"])) $id_key = $_GET["key"]; else $id_key = "";
if (isset($_POST["key"])) $id_key = $_POST["key"]; else $id_key = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

$smarty->assign("id_key",$id_key);
$smarty->assign("step",$step);


if($step != '1')
{
	// Afichage simple de la lis des clefs
        $all_keys=get_available_keys();
        $smarty->assign("allkeys",$all_keys);
	$smarty->display('search_key_securities_first.tpl');
}
else
{
	// We will seek all accounts of the servers...
	$result = mysql_query( "SELECT * FROM `hak` where `id_key`=$id_key ORDER BY `id_host`"  )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
    $id_lasthost="";
    $id_lastaccount="";

    $key_name = get_key_name($id_key); 
    $smarty->assign('key_name',$key_name);

    while( $row = mysql_fetch_array( $result ))
    {
	$line=""; 
	// We start by seeing if the key exists
        $id_currentkey = $row["id_key"];
	if ( $id_currentkey == $id_key )
        {

	  // HOST DISPLAY
	  $id_currenthost = $row["id_host"];
	  if ( $id_currenthost != $id_lasthost )
          {
		$hostname = get_host_name($id_currenthost);
	  	$list[$id_currentkey][$id_currenthost]['hostname']= $hostname;
		$id_lastaccount = "";
          }
	$id_lasthost = $id_currenthost;
                
	  // ACCOUNT DISPLAY 
	  $id_currentaccount = $row["id_account"];
	  if ( $id_currentaccount != $id_lastaccount )
          {
		$accountname = get_account_name($id_currentaccount);
	  	$list[$id_currentkey][$id_currenthost]['accounts'][]= $accountname;
	  }
		$id_lastaccount = $id_currentaccount;
        } 
    }
	if (isset($list)) $smarty->assign('list',$list);

// We will seek all accounts of the Servers that contain the key application...
// ---------------------------------------------------------------------------------------

$resultkeyring = mysql_query( "SELECT * FROM `keyrings-keys` where `id_key` = '$id_key' ORDER BY `id_keyring`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");

while ( $rowkeyring = mysql_fetch_array( $resultkeyring ))
{
	$id_keyring = $rowkeyring["id_keyring"];

	$result = mysql_query( "SELECT * FROM `hak` where `id_keyring` = '$id_keyring' ORDER BY `id_host`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");

	$keyring_name = get_keyring_name($id_keyring); 
	$keyrings[$id_keyring]["keyring_name"]=get_keyring_name($id_keyring); 
	$nr = mysql_num_rows( $result );
    		$lasthostname="";

    		while( $row = mysql_fetch_array( $result ))
    		{
        		// Afecting values
			$id_host=$row["id_host"];
			$id_account=$row["id_account"];

			$keyrings[$id_keyring]["id_account"]=$row["id_account"];

        		$hostname = get_host_name($id_host);
			if ( $hostname != $lasthostname )
        		{
				$keyrings[$id_keyring]['hosts'][$id_host]['hostname']=$hostname;
				$lasthostname = $hostname;
			}
			$account_name=get_account_name($id_account);
			$keyrings[$id_keyring]['hosts'][$id_host]['accounts'][]=$account_name;
    		}
}
if (isset($list2)) $smarty->assign('list2',$keyrings);
$smarty->display('search_key_securities_list.tpl');
}
?>
