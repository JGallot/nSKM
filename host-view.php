<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Display Host Details");

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";
if (isset($_GET["id_hostgroup"])) $id_hostgroup = $_GET["id_hostgroup"]; else $id_hostgroup = "";

$smarty->assign("id_hostgroup",$id_hostgroup);
$smarty->assign("id",$id);

if (empty($action))
{ 
      $result = mysqli_query($GLOBALS['mysql_link'], "SELECT * FROM `hosts` where `id_group` = '$id_hostgroup' AND `id`='$id'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
      $nr = $result->num_rows;
      $row = mysqli_fetch_array( $result ); 
      // Afecting values
      $name = $row["name"];
      $id = $row["id"];
      
      // getting the right icon
	$icon="images/server.gif";
	switch($row['ostype'])
	{
		case 'RHEL' : $icon="images/icon-redhat.gif";
		case 'AIX' : $icon="images/icon-aix.gif"; 
		case 'Solaris' : $icon="images/icon-solaris.gif";
		case 'Windows' : $icon="images/icon-windows.gif";
		case 'FreeBSD' : $icon="images/icon-freebsd.gif";
		default : $icon="images/server.gif";
	}

  $ostype=$row['ostype'];
  $osvers=$row['osvers'];
  $model=$row['model'];
  $po=$row['provider'];
  $serialno=$row['serialno'];
  $groupname=get_group_name($id_hostgroup);

  $smarty->assign("name",$name);
  $smarty->assign("ostype",$row['ostype']);
  $smarty->assign("osvers",$row['osvers']);
  $smarty->assign("model",$row['model']);
  $smarty->assign("po",$row['provider']);
  $smarty->assign("serialno",$row['serialno']);
  $smarty->assign("icon",$icon);
  $smarty->assign("groupname",get_group_name($id_hostgroup));

        // looking for accounts
	// --------------------
        $accounts = mysql_query( "SELECT * FROM `hosts-accounts` WHERE `id_host` = '$id'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
	{
	  while ( $keyrow = mysql_fetch_array($accounts))
	  {
	        // Afecting values
	        //$name = $keyrow["name"];
	    	$id_account = $keyrow["id_account"];
		$tab_accounts[$id_account]["id_account"]	= $keyrow["id_account"];
		$tab_accounts[$id_account]["name_account"]	= get_account_name($id_account);
		$tab_accounts[$id_account]["expand"]	= $keyrow["expand"];
            	$name_account = get_account_name($id_account);
                $display_account = $keyrow["expand"];

                if ( $display_account == "N" )
                {	
			$tab_accounts[$id_account]["expand_account"]="expandaccount";
			$tab_accounts[$id_account]["exp_gif"]="expand.gif";
			
                } else {
			$tab_accounts[$id_account]["expand_account"]="collapseaccount";
			$tab_accounts[$id_account]["exp_gif"]="collapse.gif";

			// looking for keyrings and keys
			//------------------------------
        		$keyrings = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account' and `id_keyring` != '0' " ) or die (mysql_error()."<br>Couldn't execute query: $query");
        		$nr_keyrings = mysql_num_rows( $keyrings );
        		$keys = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account' and `id_key` != '0' " ) or die (mysql_error()."<br>Couldn't execute query: $query");
        		$nr_keys = mysql_num_rows( $keys );

			// if keyring found
        		if(!empty($nr_keyrings)) {
				$nb_keyring=0;
	  			while ( $keyringrow = mysql_fetch_array($keyrings))
	  			{
					$name_keyring = get_keyring_name($keyringrow["id_keyring"]);
					$tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['indent']='detail4';
					$tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['name_keyring']=get_keyring_name($keyringrow["id_keyring"]);

					if ($keyringrow['expand']=='Y')
					{
						$tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['expand_action']='collapsekeyring';
						$tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['expand_gif']='collapse.gif';
					}
					else
					{
						$tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['expand_action']='expandkeyring';
                                	        $tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['expand_gif']='expand.gif';
					}

					// faut trouver les clefs associées au keyring

					if ($keyringrow['expand']=="Y")
					{
  						$keys2 = mysql_query( "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '".$keyringrow["id_keyring"]."'" )
                       				or die (mysql_error()."<br>Couldn't execute query: $query");
                				$nr_keys2 = mysql_num_rows( $keys2 );
                        			while ( $keyrow = mysql_fetch_array($keys2))
                        			{
                        		        // Afecting values
	                	                $id_key2 = $keyrow["id_key"];
						$tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['keys'][$id_key2]['indent']='detail4';
						$tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['keys'][$id_key2]['name_key']=get_key_name($id_key2);
                        			} // end while
                        			mysql_free_result( $keys2 );
					}
					
				} //while ( $keyringrow = mysql_fetch_array($keyrings))
				mysql_free_result ( $keyrings );
			} //if(!empty($nr_keyrings))

			// if key found
        		if(!empty($nr_keys)) {
	  			while ( $keyrow = mysql_fetch_array($keys))
	  			{
					$tab_accounts[$id_account]["keys"][$keyrow["id_key"]]['indent']='detail3';
					$tab_accounts[$id_account]["keys"][$keyrow["id_key"]]['name_key']=get_key_name($keyrow["id_key"]);
	
				} //while ( $keyrow = mysql_fetch_array($keys))
				mysql_free_result ( $keys );
			} //if(!empty($nr_keys)) 
		} //if ( $display_account == "N" )
	  } //while( $keyrow = mysql_fetch_array($accounts))
	  mysql_free_result( $accounts );
	} //if(empty($nr_accounts))

$smarty->assign("accounts",$tab_accounts);

  
$smarty->display('host-view.tpl');


}
else //( empty($action))
{
  if ( $_GET['action'] == "delete" )
  {
    $id = $_GET['id'];
    mysql_query( "DELETE FROM `hosts` WHERE `id`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    mysql_query( "DELETE FROM `hosts-accounts` WHERE `id_host`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    header("Location:hosts-view.php?id_hostgroup=$id_hostgroup");
    exit ();
  }
  if ( $_GET['action'] == "deleteAccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    mysql_query( "DELETE FROM `hosts-accounts` WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }

  if ( $_GET['action'] == "deleteKeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    $id_keyring = $_GET['id_keyring'];
    mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "deleteKey" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    $id_key = $_GET['id_key'];
    mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account' and `id_key`='$id_key'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expand" )
  {
    $id = $_GET['id'];
    mysql_query( "UPDATE `hosts` SET `expand` = 'Y' WHERE `id`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expandkeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    $id_keyring = $_GET['keyring_id'];
    mysql_query( "UPDATE `hak` SET `expand` = 'Y' WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapsekeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    $id_keyring = $_GET['keyring_id'];
    mysql_query( "UPDATE `hak` SET `expand` = 'N' WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expandaccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'Y' WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapseaccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'N' WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expandall" )
  {
    mysql_query( "UPDATE `hosts` SET `expand` = 'Y' WHERE `id_group` = '$id_hostgroup'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    # Ajout le 02-02-2006 : Pour expand all on veut egalement etendre les comptes
    mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'Y'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    # Ajout le 02-02-2006 : Pour expand all on veut egalement etendre les keyrings....
    mysql_query( "UPDATE `hak` SET `expand` = 'Y'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapse" )
  {
    $id = $_GET['id'];
    mysql_query( "UPDATE `hosts` SET `expand` = 'N' WHERE `id`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapseall" )
  {
    mysql_query( "UPDATE `hosts` SET `expand` = 'N' WHERE `id_group` = '$id_hostgroup'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    # Ajout le 02-02-2006 : Pour expand all on veut egalement etendre les comptes
    mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'N'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    # Ajout le 02-02-2006 : Pour expand all on veut egalement etendre les keyrings....
    mysql_query( "UPDATE `hak` SET `expand` = 'N'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }

  header("Location:host-view.php?id_hostgroup=$id_hostgroup&id=$id");
  exit ();
}
?>
