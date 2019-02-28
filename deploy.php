<?php

require_once('inc/global.inc.php');

$smarty->assign("title","Deployment list");

$id = $_GET['id'];

if( empty($id) )
{
    $result = mysqli_query($mysql_link, "SELECT * FROM `hosts` ORDER BY `name`" )
                         or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    
      while( $row = mysqli_fetch_array( $result )) 
      {
        // Afecting values
        $name = $row["name"];
        $id = $row["id"];
	//$host['$id']=$row["id"] ;
      
        // displaying rows
	echo("<tr>\n");

	// display expand button if expand=N
	if ($row['expand'] == "N") {
        	echo("  <td class='title'><img src='images/server.gif' border='0'>$name <a href=\"deploy.php?id=$id&action=expand\">[expand]</a></td>\n");
	} else {
        	echo("  <td class='title'><img src='images/server.gif' border='0'>$name <a href=\"deploy.php?id=$id&action=collapse\">[collapse]</a></td>\n");
	}
	echo("</tr>\n");


	// DISPLAY DETAILS ONLY IF EXPAND=Y
	if ($row['expand'] == "Y" )
        {

        // looking for accounts
	// --------------------
        $accounts = mysqli_query($mysql_link, "SELECT * FROM `hosts-accounts` WHERE `id_host` = '$id'" )
                         or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
        $nr_accounts = $accounts->num_rows;
        if(empty($nr_accounts)) {
          echo ("<tr><td class='detail2'>No account to deploy</td><td class='detail2'></td></tr>\n");
	} else {
	  while ( $keyrow = mysqli_fetch_array($accounts))
	  {
	        // Afecting values
	    	$id_account = $keyrow["id_account"];
            	$name_account = get_account_name($id_account);

	    	// Displaying rows
            	echo("<tr>\n");
		echo("  <td class='detail2'><img src='images/mister.gif' border=0>$name_account <a href=\"decrypt_key.php?action=deploy_account&id=$id&id_account=$id_account\">[Deploy]</a></td>\n");
		echo("</tr>\n");

		// looking for keyrings
		//---------------------
        	$keyrings = mysqli_query( $mysql_link, "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account'" )
                         or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
        	$nr_keyrings = $keyrings->num_rows;
        	if(empty($nr_keyrings)) {
          		echo ("<tr><td class='detail3'>No keyrings associated</td><td class='detail2'></td></tr>>\n");
		} else {
	  		while ( $keyringrow = mysqli_fetch_array($keyrings))
	  		{
                            // Afecting values
                            $id_keyring = $keyringrow["id_keyring"];
                            $name_keyring = get_keyring_name($id_keyring);

                            // Displaying rows
                            echo("<tr>\n");
                            echo("  <td class='detail3'><img src='images/keyring_little.gif' border='0'>$name_keyring</td>\n");
                            echo("</tr>\n");
			}
			mysqli_free_result ( $keyrings );
		}

	  }
	  mysqli_free_result( $accounts );
	} 
      } // END EXPAND
      mysqli_free_result( $result );
    }
}
else
{
  if ( $_GET['action'] == "delete" )
  {
    $id = $_GET['id'];
    mysqli_query( $mysql_link,"DELETE FROM `hosts` WHERE `id`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    mysqli_query( $mysql_link,"DELETE FROM `hosts-accounts` WHERE `id_host`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    mysqli_query( $mysql_link,"DELETE FROM `hak` WHERE `id_host`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "deleteAccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    mysqli_query( $mysql_link,"DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    mysqli_query($mysql_link, "DELETE FROM `hosts-accounts` WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }

  if ( $_GET['action'] == "deleteKeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    $id_keyring = $_GET['id_keyring'];
    mysqli_query( $mysql_link,"DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expand" )
  {
    $id = $_GET['id'];
    mysqli_query($mysql_link, "UPDATE `hosts` SET `expand` = 'Y' WHERE `id`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapse" )
  {
    $id = $_GET['id'];
    mysqli_query($mysql_link, "UPDATE `hosts` SET `expand` = 'N' WHERE `id`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }

  header("Location:deploy.php");
  echo ("hosts Deleted, redirecting...");
  exit ();
}
?>
