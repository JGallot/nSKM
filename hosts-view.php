<?php
require_once('inc/global.inc.php');

$smarty->assign("title","Display Host list");

	@$aix = $_GET['aix'];
	@$rhel = $_GET['rhel'];
	@$solaris = $_GET['solaris'];
	@$id = $_GET['id'];
	@$action = $_GET['action'];
	@$id_hostgroup = $_GET['id_hostgroup'];

if(isset($_GET["id_hostgroup"]))
{
    $smarty->assign("group_name",get_group_name($id_hostgroup));
    $smarty->assign("id_hostgroup",$id_hostgroup);

    $SQLQUERY="SELECT * FROM `hosts` where `id_group` = '$id_hostgroup' ORDER BY `ostype` DESC, `name` ASC";
    if ( $aix == "Y" ) $SQLQUERY = "$SQLQUERY AND `ostype` = 'AIX'";
    if ( $rhel == "Y" ) $SQLQUERY = "$SQLQUERY AND `ostype` = 'RHEL'";
    if ( $solaris == "Y" ) $SQLQUERY = "$SQLQUERY AND `ostype` = 'solaris'";
    $result = mysql_query( $SQLQUERY )
      or die (mysql_error()."<br>Couldn't execute query: $SQLQUERY");
    
    $nr = mysql_num_rows( $result );
    if(!empty($nr)) {

	$odd=1;
      while( $row = mysql_fetch_array( $result )) 
      {
        $id = $row["id"];
	$hostgroup[$id]["ip"]=$row["ip"];
	$hostgroup[$id]["name"]=$row["name"];
	$hostgroup[$id]["ostype"]=$row["ostype"];
	$hostgroup[$id]["osvers"]=$row["osvers"];
	$hostgroup[$id]["monitor"]= $row["monitor"];
	$hostgroup[$id]["id_direction"]=$row["id_direction"];
	$hostgroup[$id]["serialno"]=$row["serialno"];
      
        // displaying rows
	if ( $odd==1 )
	  $odd=0;
	else
	  $odd++;

		// getting the right icon
	$hostgroup[$id]["odd"]=$odd;

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
	$hostgroup[$id]["icon"]=$icon;

      }

      mysql_free_result( $result );
    }
	if (!isset($hostgroup)) $hostgroup=0;
	$smarty->assign("hostgroup",$hostgroup);
	$smarty->display('hosts-view.tpl');

  }
  else
  {
	echo "<script type=\"text/javascript\">window.location.href = 'show_all_hosts.php'</script>";
  }
  ?>
