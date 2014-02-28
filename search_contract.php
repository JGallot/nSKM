<?php

require_once('inc/global.inc.php');

$smarty->assign("title","Searching for a contract number");

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

if($step != '1')
{
		$result = mysql_query( "SELECT * FROM `hosts` where `id`=''" )
				or die (mysql_error()."<br>Couldn't execute query: $query");
		$row = mysql_fetch_array( $result );
		$id_hostgroup = $row["id_group"];

    <center>
    <form name="serial_search" action="contract_search.php" method="post">
    <fieldset><legend>Looking for Group Maintenance Contracts</legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type">Host group available : </td>
        <td class="Content" width="60%">
        <?php display_available_groups("$id_hostgroup"); ?>
        </td>
      </tr>
    </table>
    </fieldset>

    <center>
      <input name="step" type="hidden" value="1">
      <input name="submit" type="submit" value="Search">
    </center>
    </form>
    </center>

}
else
{
  $serial = $_POST["group"];
  $serialsearch = "%"."$serial"."%";



  print("<center><fieldset><legend>Searching for Group Number $serial</legend>");

  $result = mysql_query( "SELECT * FROM `hosts` where `id_group` LIKE '$serialsearch' ORDER BY `name`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");

  $nr = mysql_num_rows( $result );
  if(empty($nr)) {
      echo("No host found with that serial number...\n");
  }
  else {
      print("<table class='listegenerale'><tr><td>Server</td><td># Serial</td><td>Supplier</td><td>$ Annual</td></tr>");
      $even = 0;
      while( $row = mysql_fetch_array( $result ))
      	{
		$id=$row['id'];
		$id_hostgroup=$row['id_group'];
		$hostname=$row['name'];
		$serialno=$row['serialno'];
		$provider=$row['provider'];
                $maintcost=$row['maint_cost'];
	        if ( $even == 0) { echo("<tr class='even'>\n"); $even++; } else { echo("<tr>\n"); $even=0; }
		print("<td><a href='hosts_setup.php?id=$id&id_hostgroup=$id_hostgroup'>$hostname</td></a><td><a href='hosts_setup.php?id=$id&id_hostgroup=$id_hostgroup'>$serialno</a></td><td>$provider</td><td>$maintcost</td></tr>\n");
	}
      print("</table>");
  }
}
