<?php
require_once('inc/global.inc.php');

$smarty->assign('title','Keys list');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";

if( empty($id) )
{
    $result = mysqli_query($mysql_link,"SELECT * FROM `keys` ORDER BY `name`" )
                         or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    
      while( $row = mysqli_fetch_array( $result )) 
      {
        // Afecting values
        $name = $row["name"];
        $id = $row["id"];
	$keys[$id]=$name;
      
      }
      mysqli_free_result( $result );

$smarty->assign('keys',$keys);  
$smarty->display('keys.tpl');

}
else
{
  if ( $_GET['action'] == "delete" )
  {
        mysqli_query($mysql_link, "DELETE FROM `keys` WHERE `id`='$id'" );
	mysqli_query($mysql_link, "DELETE FROM `keyrings-keys` WHERE `id_key`='$id'" );
	mysqli_query($mysql_link, "DELETE FROM `hak` WHERE `id_key`='$id'" );
    // Let's go back to where we came from
    header("Location:keys.php");
    exit ();
  }
}
?>
