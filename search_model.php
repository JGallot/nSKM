<?php
require_once('inc/global.inc.php');

$smarty->assign('title','Searching for a host model number');

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

if($step == '1')
{
    $model = $_POST["model"];

    $smarty->assign('model',$model);
    $smarty->assign('step',1);
    $modelsearch = "%"."$model"."%";

    $result = mysqli_query($mysql_link, "SELECT * FROM `hosts` where `model` LIKE '$modelsearch' ORDER BY `name`" )
        or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");

    $nr = $result->num_rows;
    $even=0;
    while( $row = mysqli_fetch_array( $result ))
      {
              $id=$row['id'];
              $hosts[$id]['id_group']=$row['id_group'];
              $hosts[$id]['hostname']=$row['name'];
              $hosts[$id]['serialno']=$row['serialno'];
              $hosts[$id]['osversion']=$row['osversion'];
              $hosts[$id]['procno']=$row['procno'];
              $hosts[$id]['provider']=$row['provider'];
              $hosts[$id]['model']=$row['model'];

              if ( $even == 0) $myclass='even'; else $myclass='';
              $hosts[$id]['class']=$myclass ;
      }
      if (isset($hosts)) $smarty->assign("hosts",$hosts);
    }
    $smarty->display('search_model.tpl');
?>
