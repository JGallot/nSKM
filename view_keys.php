<?php

require_once('inc/global.inc.php');

$smarty->assign('title','Keys list');

    $result = mysql_query( "SELECT * FROM `keys` ORDER BY `name`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
    
      // To display a different color on each row
      $counter = 1;
      while( $row = mysql_fetch_array( $result )) 
      {
        // Afecting values
        $name = $row["name"];
        $id = $row["id"];
	$key_value = $row["key"];

	$keys[$id]["name"]=$name;
	$keys[$id]["value"]=$key_value;
      
        // displaying rows
	if ( $counter == 2 ) { $style = "detail1"; $counter = 1; } else { $style = "title"; $counter++; }
	$keys[$id]["style"]=$style;
      }
      mysql_free_result( $result );
        $smarty->assign("keys",$keys);
        $smarty->display('view_keys.tpl');
?>
