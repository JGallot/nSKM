<?php

require_once('inc/global.inc.php');

$smarty->assign("title","Key setup");

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";
if($step != '1')
{

  if (!empty($id))
  {
    // We modify an existing reminder
    $result = mysql_query( "SELECT * FROM `keys` where `id`='$id'" );
    $row = mysql_fetch_array( $result );
    $name = $row["name"];
    $key = $row["key"];
  }
  else 
  {
	$name = "";
	$key = "";
  }

	$smarty->assign('name',$name);
	$smarty->assign('id',$id);
	$smarty->assign('key',$key);
	$smarty->display('keys_setup.tpl');

}
else
{
  $error_list = "";
  if( empty( $error_list ) )
  {
    $id = $_POST['id'];
    if(empty($id)){
      $name = $_POST['name'];
      $key = $_POST['key'];
      // No error let's add the entry
      mysql_query( "INSERT INTO `keys` (`name`, `key`) VALUES('$name','$key')" ) or die(mysql_error()."<br>Couldn't execute query: $query");
      header("Location:keys.php");
      echo ("Reminder Added, redirecting...");
      exit ();
    } else {
      // We modify an existing reminder
      // setting the variable for the update
      $name = $_POST['name'];
      $key = $_POST['key'];
      mysql_query( "UPDATE `keys` SET `name` = '$name', `key` = '$key' WHERE `id` = '$id' " );
      // Let's go to the Reminder List page
      header("Location:keys.php");
      echo ("Reminder Modified, redirecting...");
      exit ();
    }

  }
  else
  {
    // Error occurred let's notify it
    echo( $error_list );
  }
}
?>
