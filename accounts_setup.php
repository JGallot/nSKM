<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Account setup");
$mysql_link=$GLOBALS['mysql_link'];

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";
$name = "";
if($step != '1')
{
  if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
  if (!empty($id))
  {
    // We modify an existing reminder
    $result = mysqli_query($mysql_link, "SELECT * FROM `accounts` where `id`='$id'" )
			or die (mysqli_error()."<br>Couldn't execute query: $query");
    $row = mysqli_fetch_array( $result );
    $name = $row["name"];
  }
$smarty->assign('name',$name);
$smarty->assign('id',$id);
$smarty->display('accounts_setup.tpl');

}
else
{
  $error_list = "";
  if( empty( $error_list ) )
  {
    $id = $_POST['id'];
    if(empty($id)){
    // this is a new account
      $name = $_POST['name'];
      // No error let's add the entry
      mysqli_query($mysql_link, "INSERT INTO `accounts` (`name`,`creation`,`expired`) VALUES('$name',now(),now())" ) or die(mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
      header("Location:accounts.php");
      echo ("Account Added, redirecting...");
      exit ();
    } elseif ($id > 1) {
      // We modify an existing reminder
      // setting the variable for the update
      $name = $_POST['name'];
      mysqli_query( $mysql_link, "UPDATE `accounts` SET `name` = '$name' WHERE `id` = '$id' " );
      // Let's go to the Reminder List page
      header("Location:accounts.php");
      echo ("Account Modified, redirecting...");
      exit ();
    } else {
     die('You are really not allowed to edit the root user');
    }

  }
  else
  {
    // Error occurred let's notify it
    echo( $error_list );
  }
}
?>