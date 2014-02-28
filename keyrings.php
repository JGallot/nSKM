<?php
require_once('inc/global.inc.php');

$smarty->assign('title','Keyring list');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["id_key"])) $id_key = $_GET["id_key"]; else $id_key = "";
if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";

$smarty->assign('id',$id);

if( empty($id) and empty($action) )
{
	//$keyrings=get_all_keyrings();
	//if (isset($keyrings)) $smarty->assign('keyrings','keyrings');

    $result = mysql_query( "SELECT * FROM `keyrings` ORDER BY `name`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
    
      while( $row = mysql_fetch_array( $result )) 
      {
        // Afecting values
        $id = $row["id"];

	$keyrings[$id]["name"]=$row["name"];
      
        if ($row['expand'] == "N") 
		$keyrings[$id]["expand"]="expand";
	else {
		$keyrings[$id]["expand"]="collapse";

        	// looking for keys if expand is on
        	$keys = mysql_query( "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '$id'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
	  	while ( $keyrow = mysql_fetch_array($keys))
	  	{
	    		$id_key = $keyrow["id_key"];
			$keyrings[$id]["keys"][$id_key]=get_key_name($id_key);
	  	}
	  	mysql_free_result( $keys );
      	} 
      }
      mysql_free_result( $result );
	$smarty->assign("keyrings",$keyrings);
	$smarty->display('keyrings.tpl');
}
else
{
  if ( $_GET['action'] == "delete" )
  {
    mysql_query( "DELETE FROM `keyrings` WHERE `id`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    
    mysql_query( "DELETE FROM `keyrings-keys` WHERE `id_keyring`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }

  if ( $_GET['action'] == "deleteJT" )
  {
    mysql_query( "DELETE FROM `keyrings-keys` WHERE `id_keyring`='$id' and `id_key`='$id_key'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expand" )
  {
    $id = $_GET['id'];
    mysql_query( "UPDATE `keyrings` SET `expand` = 'Y' WHERE `id`='$id'" )
                or die (mysql_error()."<br>Couldn't execute query: $query");
  }

  if ( $_GET['action'] == "expandall" )
  {
    mysql_query( "UPDATE `keyrings` SET `expand` = 'Y'" )
                or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapse" )
  {
    $id = $_GET['id'];
    mysql_query( "UPDATE `keyrings` SET `expand` = 'N' WHERE `id`='$id'" )
                or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapseall" )
  {
    mysql_query( "UPDATE `keyrings` SET `expand` = 'N'" )
                or die (mysql_error()."<br>Couldn't execute query: $query");
  }

  // Let's go back to the Reminder List page
  header("Location:keyrings.php");
  echo ("keyrings Deleted, redirecting...");
  exit ();
}
?>
