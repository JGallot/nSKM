<?php

require_once('inc/global.inc.php');

$nombreDeElementsParPage = $SKM_NB_RESULTS_PER_PAGES;

/* DEBUT recuperation du numéro de page courante */
if (isset($_GET['page']))
    { $page = (int) $_GET['page']; } 
else // La variable n'existe pas, c'est la première fois qu'on charge la page
    { $page = 1;} // On se met sur la page 1 (par défaut)
    
/* On calcule le numéro du premier élément qu'on prend pour le LIMIT de MySQL */
$premierElementAAfficher = ($page - 1) * $nombreDeElementsParPage;
    
   
if (isset($_GET["aix"])) $aix = $_GET["aix"]; else $aix = "";
if (isset($_GET["rhel"])) $rhel = $_GET["rhel"]; else $rhel = "";
if (isset($_GET["solaris"])) $solaris = $_GET["solaris"]; else $solaris = "";
if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";

$smarty->assign("title","All Hosts Overview");

$result = mysqli_query($GLOBALS['mysql_link'], "SELECT COUNT(*) AS total FROM `hosts`" )
    or die (mysqli_error()."<br>Couldn't execute query: $query");
$nr =$result->num_rows ;
if(!empty($nr)) 
{
    $row = mysqli_fetch_array( $result );
    $nb_pages  = ceil($row['total'] / $nombreDeElementsParPage);
}
else 
    $nb_pages = 0;

$mysql_link=$GLOBALS['mysql_link'];
$result = mysqli_query($mysql_link, "SELECT * FROM `hosts` ORDER BY `name` LIMIT $premierElementAAfficher, $nombreDeElementsParPage " )
    or die (mysqli_error($mysql_link)."<br>Couldn't execute query: $query");

$nr =  $result->num_rows ;
if(empty($nr)) 
{
	echo("No hosts found ...\n");
}
else 
{
      $odd=1;
      while( $row = mysqli_fetch_array( $result )) 
      {
        $id 			= $row["id"];
	$hosts[$id]['name']	= $row["name"];
	$hosts[$id]['ip']	= $row["ip"];
	$hosts[$id]['id_group']	= $row["id_group"];
	$hosts[$id]['ostype']	= $row["ostype"];
	$hosts[$id]['osvers']	= $row["osvers"];
	$hosts[$id]['monitor']	= $row["monitor"];
	$hosts[$id]['id_direction'] = $row["id_direction"];
	$hosts[$id]['serialno']	= $row["serialno"];
		  
        // displaying rows
        if ( $odd==1 )
                $odd=0;
        else
                $odd+=1;

        $hosts[$id]['odd'] = $odd;

        // getting the right icon
        switch($row['ostype'])
        {
                case "RHEL" : $icon="images/icon-redhat.gif"; break;
                case "AIX" : $icon="images/icon-aix.gif"; break;
                case "Solaris" : $icon="images/icon-solaris.gif"; break;
                case "Windows" : $icon="images/icon-windows.gif"; break;
                case "FreeBSD" : $icon="images/icon-freebsd.gif"; break;
                default : $icon="images/server.gif";
        }
        $hosts[$id]['icon'] = $icon;
    }
    mysqli_free_result( $result );
}
$smarty->assign("hosts",$hosts);
$smarty->assign("nb_pages",$nb_pages);
$smarty->assign("current_page",$page);

$smarty->display('show_all_hosts.tpl');
?>
