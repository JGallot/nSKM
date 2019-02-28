<?php 
require_once('inc/global.inc.php');

$smarty->assign("title","Group Setup");

if (isset($_POST["id"])) $id = $_POST["id"];
else if (isset($_GET["id"])) $id = $_GET["id"]; else $id="";

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

$smarty->assign("id",$id);

if($step != '1')
{
  if (!empty($id))
  {  $name = get_group_name($id);}
  else 	$name = "";

  $smarty->assign("name",$name);
  $smarty->display('groups_setup.tpl');
}
else
{
  $error_list = "";
  if( empty( $error_list ) )
  {
    if(empty($id)){
    // this is a new reminder
      $name = $_POST['name'];
      // No error let's add the entry
      mysqli_query( $GLOBALS['mysql_link'], "INSERT INTO `groups` (`name`) VALUES('$name')" ) or die(mysqli_error()."<br>Couldn't execute query: $query");
      // Let's go to the Reminder List page
      //if (empty($_POST['called']))
      //  header("Location:reminder_list.php");
      //else
      header("Location:groups.php");
      exit ();
    } else {
      // We modify an existing reminder
      // setting the variable for the update
      $name = $_POST['name'];
      mysqli_query($GLOBALS['mysql_link'], "UPDATE `groups` SET `name` = '$name' WHERE `id` = '$id' " );
      // Let's go to the Reminder List page
      header("Location:groups.php");
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

