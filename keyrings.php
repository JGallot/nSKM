<?php
require_once('inc/global.inc.php');

$smarty->assign('title','Keyring list');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["id_key"])) $id_key = $_GET["id_key"]; else $id_key = "";
if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";

$smarty->assign('id',$id);

$mysql_link=$GLOBALS['mysql_link'];

if( empty($id) and empty($action) )
{
	//$keyrings=get_all_keyrings();
	//if (isset($keyrings)) $smarty->assign('keyrings','keyrings');

    $result = mysqli_query($mysql_link, "SELECT * FROM `keyrings` ORDER BY `name`" )
                         or die (mysqli_error()."<br>Couldn't execute query: $query");
    
    while( $row = mysqli_fetch_array( $result )) 
    {
        // Afecting values
        $id = $row["id"];

	$keyrings[$id]["name"]=$row["name"];
      
        if ($row['expand'] == "N") 
		$keyrings[$id]["expand"]="expand";
	else {
            $keyrings[$id]["expand"]="collapse";

            // looking for keys if expand is on
            $keys = mysqli_query($mysql_link, "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '$id'" )
                     or die (mysqli_error()."<br>Couldn't execute query: $query");
            while ( $keyrow = mysqli_fetch_array($keys))
            {
                    $id_key = $keyrow["id_key"];
                    $keyrings[$id]["keys"][$id_key]=get_key_name($id_key);
            }
            mysqli_free_result( $keys );
        } 
    }
    mysqli_free_result( $result );
    
    $smarty->assign("keyrings",$keyrings);
    $smarty->display('keyrings.tpl');
}
else
{
  if ( $_GET['action'] == "delete" )
  {
    mysqli_query( $mysql_link,"DELETE FROM `keyrings` WHERE `id`='$id'" )
		or die (mysqli_error()."<br>Couldn't execute query: $query");
    
    mysqli_query( $mysql_link,"DELETE FROM `keyrings-keys` WHERE `id_keyring`='$id'" )
		or die (mysqli_error()."<br>Couldn't execute query: $query");
  }

  if ( $_GET['action'] == "deleteJT" )
  {
    mysqli_query($mysql_link, "DELETE FROM `keyrings-keys` WHERE `id_keyring`='$id' and `id_key`='$id_key'" )
		or die (mysqli_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expand" )
  {
    $id = $_GET['id'];
    mysqli_query( $mysql_link, "UPDATE `keyrings` SET `expand` = 'Y' WHERE `id`='$id'" )
                or die (mysqli_error()."<br>Couldn't execute query: $query");
  }

  if ( $_GET['action'] == "expandall" )
  {
    mysqli_query($mysql_link, "UPDATE `keyrings` SET `expand` = 'Y'" )
                or die (mysqli_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapse" )
  {
    $id = $_GET['id'];
    mysqli_query($mysql_link, "UPDATE `keyrings` SET `expand` = 'N' WHERE `id`='$id'" )
                or die (mysqli_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapseall" )
  {
    mysqli_query( $mysql_link,"UPDATE `keyrings` SET `expand` = 'N'" )
                or die (mysqli_error()."<br>Couldn't execute query: $query");
  }

  // Let's go back to the Reminder List page
  header("Location:keyrings.php");
  echo ("keyrings Deleted, redirecting...");
  exit ();
}
?>