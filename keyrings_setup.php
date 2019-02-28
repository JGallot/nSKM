<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Keyring Setup");

if (isset($_GET["id"])) $id = $_GET["id"]; else 
	if  (isset($_POST["id"])) $id = $_POST["id"]; else $id = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";
if (isset($_POST["name"])) $name = $_POST["name"]; else $name = "";

$mysql_link=$GLOBALS['mysql_link'];

if($step != '1')
{

  if (!empty($id))
  {
    // We modify an existing reminder
    $result = mysqli_query( $mysql_link, "SELECT * FROM `keyrings` where `id`='$id'" )
			or die (mysqli_error()."<br>Couldn't execute query: $query");
    $row = mysqli_fetch_array( $result );
    $name = $row["name"];
  }
  else
	$name = "";
        $smarty->assign("id",$id);
        $smarty->assign("name",$name);
        $smarty->display('keyrings_setup.tpl');
}
else
{
    if(empty($id)){
    // this is a new keyring
      // No error let's add the entry
      mysqli_query($mysql_link,  "INSERT INTO `keyrings` (`name` ) VALUES('$name')" ) or die(mysql_error()."<br>Couldn't execute query: $query");
      header("Location:keyrings.php");
      echo ("keyring Added, redirecting...");
      exit ();
    } else {
      // setting the variable for the update
      mysqli_query( $mysql_link, "UPDATE `keyrings` SET `name` = '$name' WHERE `id` = '$id' " );
      // Let's go to the Reminder List page
      header("Location:keyrings.php");
      echo ("keyring Modified, redirecting...");
      exit ();
    }
}
?>