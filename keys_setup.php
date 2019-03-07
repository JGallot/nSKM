<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Key setup");

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

$mysql_link=$GLOBALS['mysql_link'];

if($step != '1')
{
    if (!empty($id))
    {
      // We modify an existing reminder
      $result = mysqli_query($mysql_link, "SELECT * FROM `keys` where `id`='$id'" );
      $row = mysqli_fetch_array( $result );
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
        $name = $_POST['description'];
        $key = $_POST['key'];

        if(empty($id)){
          // No error let's add the entry
          mysqli_query($mysql_link, "INSERT INTO `keys` (`name`, `key`) VALUES('$name','$key')" ) or die(mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
          header("Location:keys.php");
          echo ("Reminder Added, redirecting...");
          exit ();
        } else {
          // Update entries
          mysqli_query($link, "UPDATE `keys` SET `name` = '$name', `key` = '$key' WHERE `id` = '$id' " );
          // Let's go to the Reminder List page
          header("Location:keys.php");
          echo ("Reminder Modified, redirecting...");
          exit ();
        }
    }
    else
    {
      echo( $error_list );
    }
}
?>