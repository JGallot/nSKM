<?php
require_once('inc/global.inc.php');

$smarty->assign('title','Keys list');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";

if( empty($id) )
{
    $result = mysql_query( "SELECT * FROM `keys` ORDER BY `name`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
    
      while( $row = mysql_fetch_array( $result )) 
      {
        // Afecting values
        $name = $row["name"];
        $id = $row["id"];
	$keys[$id]=$name;
      
      }
      mysql_free_result( $result );

$smarty->assign('keys',$keys);  
$smarty->display('keys.tpl');

}
else
{
  if ( $_GET['action'] == "delete" )
  {


    mysql_query( "DELETE FROM `keys` WHERE `id`='$id'" );
	mysql_query( "DELETE FROM `keyrings-keys` WHERE `id_key`='$id'" );
	mysql_query( "DELETE FROM `hak` WHERE `id_key`='$id'" );
    // Let's go back to where we came from
    header("Location:keys.php");
    exit ();
  }
}
?>
