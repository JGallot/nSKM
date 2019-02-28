<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Display Host Details");

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";
if (isset($_GET["id_hostgroup"])) $id_hostgroup = $_GET["id_hostgroup"]; else $id_hostgroup = "";

$smarty->assign("id_hostgroup",$id_hostgroup);
$smarty->assign("id",$id);

$mysql_link=$GLOBALS['mysql_link'];

if (empty($action))
{ 
    $result = mysqli_query($mysql_link, "SELECT * FROM `hosts` where `id_group` = '$id_hostgroup' AND `id`='$id'" )
                       or die (mysql_error($mysql_link)."<br>Couldn't execute query: $query");
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
        $accounts = mysqli_query($mysql_link, "SELECT * FROM `hosts-accounts` WHERE `id_host` = '$id'" )
                         or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
	{
	  while ( $keyrow = mysqli_fetch_array($accounts))
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
        		$keyrings = mysqli_query($mysql_link, "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account' and `id_keyring` != '0' " ) or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
        		$nr_keyrings = $keyrings->num_rows;
        		$keys = mysqli_query($mysql_link, "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account' and `id_key` != '0' " ) or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
        		$nr_keys = $keys->num_rows;

			// if keyring found
        		if(!empty($nr_keyrings)) {
				$nb_keyring=0;
	  			while ( $keyringrow = mysqli_fetch_array($keyrings))
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
  						$keys2 = mysqli_query($mysql_link, "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '".$keyringrow["id_keyring"]."'" )
                       				or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
                				$nr_keys2 = $keys2->num_rows;
                        			while ( $keyrow = mysqli_fetch_array($keys2))
                        			{
                        		        // Afecting values
	                	                $id_key2 = $keyrow["id_key"];
						$tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['keys'][$id_key2]['indent']='detail4';
						$tab_accounts[$id_account]["keyrings"][$keyringrow["id_keyring"]]['keys'][$id_key2]['name_key']=get_key_name($id_key2);
                        			} // end while
                        			mysqli_free_result( $keys2 );
					}
					
				} //while ( $keyringrow = mysqli_fetch_array($keyrings))
				mysqli_free_result ( $keyrings );
			} //if(!empty($nr_keyrings))

			// if key found
        		if(!empty($nr_keys)) {
                            while ( $keyrow = mysqli_fetch_array($keys))
                            {
                                    $tab_accounts[$id_account]["keys"][$keyrow["id_key"]]['indent']='detail3';
                                    $tab_accounts[$id_account]["keys"][$keyrow["id_key"]]['name_key']=get_key_name($keyrow["id_key"]);

                            } //while ( $keyrow = mysqli_fetch_array($keys))
                            mysqli_free_result ( $keys );
			} //if(!empty($nr_keys)) 
		} //if ( $display_account == "N" )
	  } //while( $keyrow = mysqli_fetch_array($accounts))
	  mysqli_free_result( $accounts );
	} //if(empty($nr_accounts))

$smarty->assign("accounts",$tab_accounts);

$smarty->display('host-view.tpl');
}
else //( empty($action))
{
  if ( $_GET['action'] == "delete" )
  {
    $id = $_GET['id'];
    mysqli_query($mysql_link, "DELETE FROM `hosts` WHERE `id`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    mysqli_query($mysql_link, "DELETE FROM `hosts-accounts` WHERE `id_host`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    mysqli_query($mysql_link, "DELETE FROM `hak` WHERE `id_host`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    header("Location:hosts-view.php?id_hostgroup=$id_hostgroup");
    exit ();
  }
  if ( $_GET['action'] == "deleteAccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    mysqli_query($mysql_link, "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    mysqli_query($mysql_link, "DELETE FROM `hosts-accounts` WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }

  if ( $_GET['action'] == "deleteKeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    $id_keyring = $_GET['id_keyring'];
    mysqli_query($mysql_link, "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "deleteKey" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    $id_key = $_GET['id_key'];
    mysqli_query($mysql_link, "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account' and `id_key`='$id_key'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expand" )
  {
    $id = $_GET['id'];
    mysqli_query( $mysql_link,"UPDATE `hosts` SET `expand` = 'Y' WHERE `id`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expandkeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    $id_keyring = $_GET['keyring_id'];
    mysqli_query($mysql_link, "UPDATE `hak` SET `expand` = 'Y' WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapsekeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    $id_keyring = $_GET['keyring_id'];
    mysqli_query($mysql_link, "UPDATE `hak` SET `expand` = 'N' WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expandaccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    mysqli_query($mysql_link,"UPDATE `hosts-accounts` SET `expand` = 'Y' WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapseaccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    mysqli_query( $mysql_link,"UPDATE `hosts-accounts` SET `expand` = 'N' WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expandall" )
  {
    mysqli_query($mysql_link, "UPDATE `hosts` SET `expand` = 'Y' WHERE `id_group` = '$id_hostgroup'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    # Ajout le 02-02-2006 : Pour expand all on veut egalement etendre les comptes
    mysqli_query( $mysql_link, "UPDATE `hosts-accounts` SET `expand` = 'Y'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    # Ajout le 02-02-2006 : Pour expand all on veut egalement etendre les keyrings....
    mysqli_query($mysql_link, "UPDATE `hak` SET `expand` = 'Y'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapse" )
  {
    $id = $_GET['id'];
    mysqli_query($mysql_link, "UPDATE `hosts` SET `expand` = 'N' WHERE `id`='$id'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapseall" )
  {
    mysqli_query($mysql_link, "UPDATE `hosts` SET `expand` = 'N' WHERE `id_group` = '$id_hostgroup'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    # Ajout le 02-02-2006 : Pour expand all on veut egalement etendre les comptes
    mysqli_query($mysql_link, "UPDATE `hosts-accounts` SET `expand` = 'N'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
    # Ajout le 02-02-2006 : Pour expand all on veut egalement etendre les keyrings....
    mysqli_query($mysql_link, "UPDATE `hak` SET `expand` = 'N'" )
		or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");
  }

  header("Location:host-view.php?id_hostgroup=$id_hostgroup&id=$id");
  exit ();
}
?>
