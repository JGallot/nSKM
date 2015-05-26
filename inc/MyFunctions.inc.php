<?php


include_once('config.inc.php'); // Our global configuration file
include_once('database.inc.php'); // Our database connectivity file

// ****************************** DISPLAY GROUP AVAILABLE ****************************************
function display_available_hosts(){
    //Display the selection box for the groups
    $result = mysql_query( "SELECT * FROM `hosts` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No host found...';
    }
    else {
      echo '<select class="list" name="host">';
      echo '<option selected value="0">Please select a host</option>';
      while( $row = mysql_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
		$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysql_free_result( $result );
    }
}


// ****************************** DISPLAY GROUP AVAILABLE ****************************************
function display_available_groups($id_hostgroup){

    //Display the selection box for the groups
    $result = mysql_query( "SELECT * FROM `groups` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No group found...';
    }
    else {
      echo '<select class="list" name="group">';
      echo '<option selected value="1">Please select a group</option>';
      while( $row = mysql_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
	$id = $row["id"];
	if ( $id == $id_hostgroup ) 
	{
        	echo '<option selected value='.$id.'>'.$name.'</option>';
	} else {
        	echo '<option value='.$id.'>'.$name.'</option>';
	}
      }
      echo '</select>';
      mysql_free_result( $result );
    }
}

function get_all_hostgroups()
{
$hostgroup=mysql_query( "SELECT * FROM `groups` ORDER BY `name`" )
                        or die (mysql_error()."<br>Couldn't execute query: $query");

$hostgroup_nr = mysql_num_rows( $hostgroup );
if (!empty($hostgroup_nr)) {
              while( $hostgroup_row = mysql_fetch_array( $hostgroup ))
              {
                        // Afecting values
                        $name = $hostgroup_row["name"];
                        $id_hostgroup = $hostgroup_row["id"];

                        $hostgroup_ar[$id_hostgroup]=$name;
                }
                mysql_free_result( $hostgroup );
        }
	return ($hostgroup_ar);

}
function get_group_name($id_hostgroup){

    //Display the selection box for the groups
    $result = mysql_query( "SELECT name FROM `groups` WHERE `id`='$id_hostgroup' " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");
    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      return ('No group assigned');
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }

}

function get_direction_name($id){

    //Display the selection box for the groups
    $result = mysql_query( "SELECT name FROM `direction` WHERE `id`='$id' " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");
    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No direction found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }

}

// ****************************** DISPLAY KEY AVAILABLE ****************************************
function get_available_keys(){

    $res=array();
    //Display the selection box for the keys
    $result = mysql_query( "SELECT * FROM `keys` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(!empty($nr)) {
      while( $row = mysql_fetch_array( $result ))
      {
	$id=$row['id'];
	$name=$row['name'];
        // Afecting values
	$res[$id]['name']=$name;
      }
      mysql_free_result( $result );
    }
    return ($res);
}

// ****************************** DISPLAY ACCOUNT AVAILABLE ****************************************
function display_availables_accounts(){
    $result = mysql_query( "SELECT * FROM `accounts` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No account found...';
    }
    else {
      echo '<select class="list" name="account">';
      while( $row = mysql_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
		$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysql_free_result( $result );
    }
}

// ****************************** DISPLAY keyring AVAILABLE ****************************************
function display_availables_keyrings(){
    $result = mysql_query( "SELECT * FROM `keyrings` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(!empty($nr)) {
      echo '<select class="list" name="keyring">';
      echo '<option selected value="0">Please select a keyring</option>';
      while( $row = mysql_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
	$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysql_free_result( $result );
    }
}


// ****************************** GET KEY ID ****************************************
function get_key_id($name){
    $result = mysql_query( "SELECT * FROM `keys` WHERE `name` = '$name' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No key found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['id'];
    }
}

// ****************************** GET KEY NAME ****************************************
function get_key_name($id){
    $result = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      return('Zombie Key');
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_account_name($id){
    $result = mysql_query( "SELECT * FROM `accounts` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      return('Zombie account');
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}
function get_all_keyrings($id_host='',$id_account='')
{

if (($id_host!='')&&($id_account!=''))
	$req="SELECT * FROM keyrings where id not in (SELECT id_keyring from hak where id_host=$id_host and id_account=$id_account)";
else
	$req="SELECT * FROM `keyrings` ORDER BY `name`";

$kr=mysql_query($req)
                        or die (mysql_error()."<br>Couldn't execute query: $req");

$kr_nr = mysql_num_rows( $kr );
if (!empty($kr_nr)) {
              while( $row = mysql_fetch_array( $kr ))
              {
                        // Afecting values
                        $name = $row["name"];
                        $id = $row["id"];

                        $keyrings[$id]=$name;
                }
                mysql_free_result( $kr );
        }
        return ($keyrings);
}

function get_all_accounts()
{
$kr=mysql_query( "SELECT * FROM `accounts` ORDER BY `name`" )
                        or die (mysql_error()."<br>Couldn't execute query: $query");

$kr_nr = mysql_num_rows( $kr );
if (!empty($kr_nr)) {
              while( $row = mysql_fetch_array( $kr ))
              {
                        // Afecting values
                        $name = $row["name"];
                        $id = $row["id"];
                        $keyrings[$id]=$name;
                }
                mysql_free_result( $kr );
        }
        return ($keyrings);
}




// ****************************** GET Keyring NAME ****************************************
function get_keyring_name($id){
    $result = mysql_query( "SELECT * FROM `keyrings` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(!empty($nr)) {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_host_name($id){
    $result = mysql_query( "SELECT * FROM `hosts` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      return('Zombie dead Host');
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ****************************** GET HOST IP ****************************************
function get_host_ip($id){
    $result = mysql_query( "SELECT `ip` FROM `hosts` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No host found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['ip'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_gfile_name($id){
    $result = mysql_query( "SELECT * FROM `globalfiles` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No host found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ********************************* DISPLAY MENY *****************************************

function prepare_authorizedkey_file($id,$id_account){
    
	global $SKM_AUTH_MSG;
        // Initialising variables
        $hostname = get_host_name($id);
        $account_name = get_account_name($id_account);
        $now = date("Ymd-His");

	$message="";

	// Add default message;
	$authorized_keys="$SKM_AUTH_MSG\n";

		// -----------------------------------------------
	        // We get all keys associated with current keyring
		// -----------------------------------------------
                $keyrings = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account'
                                          and `id_keyring` != '0'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
                $nr_keyrings = mysql_num_rows( $keyrings );
                if(!empty($nr_keyrings)) {
                        while ( $keyringrow = mysql_fetch_array($keyrings))
                        {
                                $id_keyring = $keyringrow['id_keyring'];
                                $name_keyring = get_keyring_name($id_keyring);
                                //$message.="Deploying keyring $name_keyring with id $id_keyring<br>\n";

                                // Getting the keys associated to current keyring
                                //echo("Select from keyrings-keys id_keyring=$id_keyring\n");
                                $keys = mysql_query( "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '$id_keyring'" )
                                        or die (mysql_error()."<br>Couldn't execute query: $query");
                                $nr_keys = mysql_num_rows( $keys );
                                if (!empty($nr_keys)) {
                                        while ( $keyrow = mysql_fetch_array($keys))
                                        {
                                                $key_id = $keyrow['id_key'];
                                                $key_name = get_key_name($key_id);
                                                $message.="  <img src='images/ok.gif'>adding key $key_name (id $key_id)<br>\n";


                                                // Getting key value of current key
                                                $keyvalue = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$key_id'" )
                                                        or die (mysql_error()."<br>Couldn't execute query: $query");
                                                $nr_keyvalue = mysql_num_rows( $keyvalue );
                                                if (!empty($nr_keyvalue)) {
                                                        while ($keyvaluerow  = mysql_fetch_array($keyvalue))
                                                        {
                                                                $singlekey = trim($keyvaluerow['key']);
                                                                $authorized_keys.= "$singlekey\n";
                                                        }
                                                } // end if
                                        } // end while keyrow
                                        mysql_free_result($keys);
                                } //end if
                        } // end while keyringrow
                        mysql_free_result($keyrings);
                } // end if

		// -----------------------------------------------
	        // We get all keys associated with current account/host
		// -----------------------------------------------
                $keys = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account'
                                          and `id_key` != '0'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
                $nr_keys = mysql_num_rows( $keys );
                if(!empty($nr_keys)) {
                        while ( $keyrow = mysql_fetch_array($keys))
                        {
                           $key_id = $keyrow['id_key'];
                           $key_name = get_key_name($key_id);
                           $message.="  <img src='images/ok.gif'>adding key $key_name (id $key_id)<br>\n";

                           // Getting key value of current key
                           $keyvalue = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$key_id'" )
                                       or die (mysql_error()."<br>Couldn't execute query: $query");
                           $nr_keyvalue = mysql_num_rows( $keyvalue );
                           if (!empty($nr_keyvalue)) {
                              while ($keyvaluerow  = mysql_fetch_array($keyvalue))
                              {
                                $singlekey = $keyvaluerow['key'];
                                $authorized_keys.= "$singlekey\n";
                              }
                            } // end if
                          } // end while keyrow
                          mysql_free_result($keys);
                  } //end if

        $handle = fopen("/tmp/authorized_keys","w");
        fputs($handle,$authorized_keys);
        fclose($handle);

	return $message;
}

Function view_authorizedkey_file($id,$id_account){
        // Initialising variables
        $hostname = get_host_name($id);
        $account_name = get_account_name($id_account);
        $now = date("Ymd-His");

	$message="";
	$authorized_keys="";

		// -----------------------------------------------
	        // We get all keys associated with current keyring
		// -----------------------------------------------
                $keyrings = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account'
                                          and `id_keyring` != '0'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
                $nr_keyrings = mysql_num_rows( $keyrings );
                if(!empty($nr_keyrings)) {
                        while ( $keyringrow = mysql_fetch_array($keyrings))
                        {
                                $id_keyring = $keyringrow['id_keyring'];
                                $name_keyring = get_keyring_name($id_keyring);
                                //$message.="Deploying keyring $name_keyring with id $id_keyring<br>\n";

                                // Getting the keys associated to current keyring
                                //echo("Select from keyrings-keys id_keyring=$id_keyring\n");
                                $keys = mysql_query( "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '$id_keyring'" )
                                        or die (mysql_error()."<br>Couldn't execute query: $query");
                                $nr_keys = mysql_num_rows( $keys );
                                if (!empty($nr_keys)) {
                                        while ( $keyrow = mysql_fetch_array($keys))
                                        {
                                                $key_id = $keyrow['id_key'];
                                                $key_name = get_key_name($key_id);
                                                $message.="  <img src='images/ok.gif'>adding key $key_name (id $key_id)<br>\n";


                                                // Getting key value of current key
                                                $keyvalue = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$key_id'" )
                                                        or die (mysql_error()."<br>Couldn't execute query: $query");
                                                $nr_keyvalue = mysql_num_rows( $keyvalue );
                                                if (!empty($nr_keyvalue)) {
                                                        while ($keyvaluerow  = mysql_fetch_array($keyvalue))
                                                        {
                                                                $singlekey = $keyvaluerow['key'];
                                                                $authorized_keys.= "$singlekey<br>\n";
                                                        }
                                                } // end if
                                        } // end while keyrow
                                        mysql_free_result($keys);
                                } //end if
                        } // end while keyringrow
                        mysql_free_result($keyrings);
                } // end if

		// -----------------------------------------------
	        // We get all keys associated with current account/host
		// -----------------------------------------------
                $keys = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account'
                                          and `id_key` != '0'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
                $nr_keys = mysql_num_rows( $keys );
                if(!empty($nr_keys)) {
                        while ( $keyrow = mysql_fetch_array($keys))
                        {
                           $key_id = $keyrow['id_key'];
                           $key_name = get_key_name($key_id);
                           $message.="  <img src='images/ok.gif'>adding key $key_name (id $key_id)<br>\n";

                           // Getting key value of current key
                           $keyvalue = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$key_id'" )
                                       or die (mysql_error()."<br>Couldn't execute query: $query");
                           $nr_keyvalue = mysql_num_rows( $keyvalue );
                           if (!empty($nr_keyvalue)) {
                              while ($keyvaluerow  = mysql_fetch_array($keyvalue))
                              {
                                $singlekey = $keyvaluerow['key'];
                                $authorized_keys.= "$singlekey\n";
                              }
                            } // end if
                          } // end while keyrow
                          mysql_free_result($keys);
                  } //end if

        $handle = fopen("/tmp/authorized_keys","w");
        fputs($handle,$authorized_keys);
        fclose($handle);

	return $authorized_keys;
}
	


function arr_diff( $f1 , $f2 , $show_equal = 0 )
{

        $c1         = 0 ;                   # current line of left
        $c2         = 0 ;                   # current line of right
        $max1       = count( $f1 ) ;        # maximal lines of left
        $max2       = count( $f2 ) ;        # maximal lines of right
        $outcount   = 0;                    # output counter
        $hit1       = "" ;                  # hit in left
        $hit2       = "" ;                  # hit in right

        while ( 
                $c1 < $max1                 # have next line in left
                and                 
                $c2 < $max2                 # have next line in right
                and 
                ($stop++) < 1000            # don-t have more then 1000 ( loop-stopper )
                and 
                $outcount < 20              # output count is less then 20
              )
        {
            /**
            *   is the trimmed line of the current left and current right line
            *   the same ? then this is a hit (no difference)
            */  
            if ( trim( $f1[$c1] ) == trim ( $f2[$c2])  )    
            {
                /**
                *   add to output-string, if "show_equal" is enabled
                */
                $out    .= ($show_equal==1) 
                         ?  formatline ( ($c1) , ($c2), "=", $f1[ $c1 ] ) 
                         : "" ;
                /**
                *   increase the out-putcounter, if "show_equal" is enabled
                *   this ist more for demonstration purpose
                */
                if ( $show_equal == 1 )  
                { 
                    $outcount++ ; 
                }
                
                /**
                *   move the current-pointer in the left and right side
                */
                $c1 ++;
                $c2 ++;
            }

            /**
            *   the current lines are different so we search in parallel
            *   on each side for the next matching pair, we walk on both 
            *   sided at the same time comparing with the current-lines
            *   this should be most probable to find the next matching pair
            *   we only search in a distance of 10 lines, because then it
            *   is not the same function most of the time. other algos
            *   would be very complicated, to detect 'real' block movements.
            */
            else
            {
                
                $b      = "" ;
                $s1     = 0  ;      # search on left
                $s2     = 0  ;      # search on right
                $found  = 0  ;      # flag, found a matching pair
                $b1     = "" ;      
                $b2     = "" ;
                $fstop  = 0  ;      # distance of maximum search

                #fast search in on both sides for next match.
                while ( 
                        $found == 0             # search until we find a pair
                        and 
                        ( $c1 + $s1 <= $max1 )  # and we are inside of the left lines
                        and 
                        ( $c2 + $s2 <= $max2 )  # and we are inside of the right lines
                        and     
                        $fstop++  < 10          # and the distance is lower than 10 lines
                      )
                {

                    /**
                    *   test the left side for a hit
                    *
                    *   comparing current line with the searching line on the left
                    *   b1 is a buffer, which collects the line which not match, to 
                    *   show the differences later, if one line hits, this buffer will
                    *   be used, else it will be discarded later
                    */
                    #hit
                    if ( trim( $f1[$c1+$s1] ) == trim( $f2[$c2] )  )
                    {
                        $found  = 1   ;     # set flag to stop further search
                        $s2     = 0   ;     # reset right side search-pointer
                        $c2--         ;     # move back the current right, so next loop hits
                        $b      = $b1 ;     # set b=output (b)uffer
                    }
                    #no hit: move on
                    else
                    {
                        /**
                        *   prevent finding a line again, which would show wrong results
                        *
                        *   add the current line to leftbuffer, if this will be the hit
                        */
                        if ( $hit1[ ($c1 + $s1) . "_" . ($c2) ] != 1 )
                        {   
                            /**
                            *   add current search-line to diffence-buffer
                            */
                            $b1  .= formatline( ($c1 + $s1) , ($c2), "-", $f1[ $c1+$s1 ] );

                            /**
                            *   mark this line as 'searched' to prevent doubles. 
                            */
                            $hit1[ ($c1 + $s1) . "_" . $c2 ] = 1 ;
                        }
                    }



                    /**
                    *   test the right side for a hit
                    *
                    *   comparing current line with the searching line on the right
                    */
                    if ( trim ( $f1[$c1] ) == trim ( $f2[$c2+$s2])  )
                    {
                        $found  = 1   ;     # flag to stop search
                        $s1     = 0   ;     # reset pointer for search
                        $c1--         ;     # move current line back, so we hit next loop
                        $b      = $b2 ;     # get the buffered difference
                    }
                    else
                    {   
                        /**
                        *   prevent to find line again
                        */
                        if ( $hit2[ ($c1) . "_" . ( $c2 + $s2) ] != 1 )
                        {
                            /**
                            *   add current searchline to buffer
                            */
                            $b2   .= formatline ( ($c1) , ($c2 + $s2), "+", $f2[ $c2+$s2 ] );

                            /**
                            *   mark current line to prevent double-hits
                            */
                            $hit2[ ($c1) . "_" . ($c2 + $s2) ] = 1;
                        }

                     }

                    /**
                    *   search in bigger distance
                    *
                    *   increase the search-pointers (satelites) and try again
                    */
                    $s1++ ;     # increase left  search-pointer
                    $s2++ ;     # increase right search-pointer  
                }

                /**
                *   add line as different on both arrays (no match found)
                */
                if ( $found == 0 )
                {
                    $b  .= formatline ( ($c1) , ($c2), "-", $f1[ $c1 ] );
                    $b  .= formatline ( ($c1) , ($c2), "+", $f2[ $c2 ] );
                }

                /** 
                *   add current buffer to outputstring
                */
                $out        .= $b;
                $outcount++ ;       #increase outcounter

                $c1++  ;    #move currentline forward
                $c2++  ;    #move currentline forward

                /**
                *   comment the lines are tested quite fast, because 
                *   the current line always moves forward
                */

            } /*endif*/

        }/*endwhile*/

        return $out;

}/*end func*/

    /**
    *   callback function to format the diffence-lines with your 'style'
    */
function formatline( $nr1, $nr2, $stat, &$value )  #change to $value if problems
{
        if ( trim( $value ) == "" )
        {
            return "";
        }

        switch ( $stat )
        {
            case "=":
                return $nr1. " : $nr2 : = ".htmlentities( $value )  ."<br>";
            break;

            case "+":
                //return $nr1. " : $nr2 : + <img src='images/expand.gif'>".htmlentities( $value )  ."</font><br>";
                return "<img src='images/expand.gif'>".htmlentities( $value )  ."</font><br>";
            break;

            case "-":
                //return $nr1. " : $nr2 : - <font color='red' >".htmlentities( $value )  ."</font><br>";
                return "<img src='images/error.gif'>".htmlentities( $value )  ."</font><br>";
            break;
        }

} /*end func*/




	

function deploy_authorizedkey_file($id,$id_account){

        // Initialising variables
        $hostname = get_host_name($id);
	$hostip = get_host_ip($id);
        $account_name = get_account_name($id_account);
        $now = date("Ymd-His");

	$message="";

        // getting homedir of current user
        //$message.="ssh root@$hostname grep $account_name /etc/passwd\n";
        $output = shell_exec("ssh ".$GLOBALS['sudousr']."@$hostname grep \"$account_name\:\" /etc/passwd 2>&1");
	//echo ("$output<br>\n");
        if (!empty($output)){
                list($field1,$field2,$field3,$field4,$field5,$homedir,$shell) = explode(":",$output);
		$message.= "<img src='images/ok.gif'>homedir of $account_name on $hostname is $homedir<br>\n";

		// Testing presence of file
		// Uncomment for IP if ( test_presence($hostip,"$homedir/.ssh/authorized_keys") == 1 )
		if ( test_presence($hostname,"$homedir/.ssh/authorized_keys") == 1 )
		{
			$message.="<img src='images/warning.gif'>$homedir/.ssh/authorized_keys was not found...<br>\n";
		} else {
                	// Archiving destination file
                	// Uncomment for IP : $output = shell_exec("ssh ".$GLOBALS['sudousr']."@$hostip cp $homedir/.ssh/authorized_keys $homedir/.ssh/authorized_keys.$now 2>&1");
                	$output = shell_exec("ssh ".$GLOBALS['sudousr']."@$hostname cp $homedir/.ssh/authorized_keys $homedir/.ssh/authorized_keys.$now 2>&1");
                	if (empty($output)){
                        	//everything was fine
                        	$message .= "<img src='images/ok.gif'>authorized_keys has been archived successfully to $homedir/.ssh/authorized_keys.$now<br>\n";
			} else {
                        	$message .= "<img src='images/error.gif'>authorized_keys could NOT be archived to $homedir/.ssh/authorized_keys.$now<br>\n";
				return $message;
			}
			// Uncomment for IP $output = shell_exec("scp ".$GLOBALS['sudousr']."@$hostip:/$homedir/.ssh/authorized_keys /tmp/aut2.txt 2>&1");
			$output = shell_exec("scp ".$GLOBALS['sudousr']."@$hostname:/$homedir/.ssh/authorized_keys /tmp/aut2.txt 2>&1");
                	if (!empty($output)){
                        	//everything was fine
                        	$message .= "<img src='images/error.gif'>authorized_keys could not be copied locally ($output). The diff test might not be valid.<br>\n";
			}
			$output = shell_exec("chmod 740 /tmp/aut2.txt 2>&1");
                	if (!empty($output)){
                        	//everything was fine
                        	$message .= "<img src='images/error.gif'>authorized_keys could not chg perm on /tmp/aut2.txt ($output). The diff test might not be valid.<br>\n";
			}
		}

                // Uncomment for IP $output = shell_exec("scp /tmp/authorized_keys root@$hostip:$homedir/.ssh/authorized_keys 2>&1");
                $output = shell_exec("scp /tmp/authorized_keys ".$GLOBALS['sudousr']."@$hostname:$homedir/.ssh/authorized_keys 2>&1");
                if (empty($output)){
                	//everything is fine
                        $message .= "<img src='images/ok.gif'>File authorized_keys has been pushed successfully to $hostname for account $account_name<br>\n";
			//comparing number of keys
			$differences = "";
			#$differences = shell_exec("diff --ignore-blank-lines -u /tmp/aut2.txt /tmp/authorized_keys2 | grep -v ^--- | grep -v ^+++  | sed 's/^-/<img src=images\/add.gif> /g' | sed 's/^+/<img src=images\/error.gif> /g' | sed 's/$/<br>/g'");
			$differences = shell_exec("diff --ignore-blank-lines -u /tmp/aut2.txt /tmp/authorized_keys2 | grep -v ^--- | grep -v ^+++  | sed 's/^-/<P class=delete> /g' | sed 's/^+/<P class=add> /g' | sed 's/^ ssh-rsa/<p > /g' | sed 's/$/<\/P>/g'");
			if ( empty($differences)){
				$message .= "<br>Files are identicals<br>\n";
			} else {
				$message .= "<br>File comparison output :<br>\n";
				$message .= "<br>Legende :<br>";
				$message .= "<p class=add> Key(s) added<br><p class=delete> Key(s) deleted</p><br>";
				$message .= $differences;
			}



		
                 } else {
                        $message .= "<img src='images/error.gif'>An error occured while pushing file authorized_keys to $hostname for account $account_name\n$output"."<br>\n";
                 }
        } else {
		// Account does not exist
                $message.= "<img src='images/error.gif'>User $account_name not found on $hostname<br>\n$message";

		
        }

	$message.="</fieldset><br>\n";
	return $message;
} 

function display_key($id_host,$id_account,$id_key,$id_hostgroup,$ident_level){
       // Afecting values
       //$name = $keyrow["name"];
       $name_key = get_key_name($id_key);

       // Displaying rows
       echo("<tr>\n");
       echo("  <td class='$ident_level'><img src='images/key_little.gif' border=0 >$name_key ");
       //echo("  <td class='$ident_level'><a href='keyrings.php?id=$id&id_key=$id_key&action=deleteJT'><img src=\"images/delete.gif\" border=0 alt=\"Delete\"></a></td>\n");
       echo("<a href='host-view.php?id=$id_host&id_account=$id_account&id_key=$id_key&id_hostgroup=$id_hostgroup&action=deleteKey'>[ Delete ]</a></td>\n");
       echo("</tr>\n");
}


// ********************************* DISPLAY KEYRING *****************************************
function display_keyring($id_host,$id_account,$id_keyring,$id_hostgroup,$ident_level,$display){
	// ident_level : level of identation to display element
	// display (Y/N) : display keys in current keyring


        $name_keyring = get_keyring_name($id_keyring);

        // Displaying rows
	if ( $display == "N" )
	{
        	echo("<tr>\n");
        	echo("  <td class='detail3'><a href=\"host-view.php?id=$id_host&id_hostgroup=$id_hostgroup&action=expandkeyring&account_id=$id_account&keyring_id=$id_keyring\"><img src='images/expand.gif' border='0'></a><img src='images/keyring_little.gif' border='0'>$name_keyring ");
        	echo("<a href='host-view.php?id=$id_host&id_account=$id_account&id_keyring=$id_keyring&action=deleteKeyring&id_hostgroup=$id_hostgroup'>[ Delete ]</a></td>\n");
        	echo("</tr>\n");
	} else {
        	echo("<tr>\n");
        	echo("  <td class='detail3'><a href=\"host-view.php?id=$id_host&account_id=$id_account&keyring_id=$id_keyring&action=collapsekeyring&id_hostgroup=$id_hostgroup\"><img src='images/collapse.gif' border='0'></a><img src='images/keyring_little.gif' border='0'>$name_keyring ");
        	echo("<a href='host-view.php?id=$id_host&id_account=$id_account&id_keyring=$id_keyring&action=deleteKeyring&id_hostgroup=$id_hostgroup'>[ Delete ]</a></td>\n");
        	echo("</tr>\n");


		// looking for keys
		$keys = mysql_query( "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '$id_keyring'" )
		       or die (mysql_error()."<br>Couldn't execute query: $query");
		$nr_keys = mysql_num_rows( $keys );
		if(empty($nr_keys)) {
			//echo ("<tr><td class='$ident_level'>No keys associated</td><td class='$ident_level'></td></tr>\n");
			echo ("<tr><td class='$ident_level'>No keys associated</td></tr>\n");
		} else {
			while ( $keyrow = mysql_fetch_array($keys))
			{
				// Afecting values
				//$name = $keyrow["name"];
				$id_key = $keyrow["id_key"];
				display_key($id_host,$id_account,$id_key,$id_hostgroup,$ident_level);
			} // end while
			mysql_free_result( $keys );
		} //end if
	} //end if
} 


// ********************************* TEST CONNECTION *****************************************
function test_connection($host,$accept_pub_key){
    
        if ($accept_pub_key) $opts='-oStrictHostKeyChecking=no';
	//$output = shell_exec("ssh $opts ".$GLOBALS['sudousr']."@$host ls -la| grep '^.'");
	//if ( empty($output ))
	{
            exec("ssh $opts ".$GLOBALS['sudousr']."@$host ls -la 2>&1",$output,$return_val);
            for ($i=0;$i<count($output);$i++) { $output_final.=$output[$i]."<br>\n"; }
            
            if ($return_val!=0)
            {
                return array(0,"<img src='images/error.gif'>Connection failed. Please see output below.<br>Output is $output_final<br>\n");
		
            } else {
                return array(1,"<img src='images/ok.gif'>SSH connection is OK.<br>\n");
            }
                
	} /*else {
		return array(1,"<img src='images/ok.gif'>SSH connection is OK.<br>\n");
	}   */    
}

// ********************************* TEST PRESENCE *****************************************
function test_presence($host,$file){
	$output = shell_exec("ssh ".$GLOBALS['sudousr']."@$host ls -la $file");
	if ( empty($output ))
	{
		return 1;
	} else {
		return 0;
	}
}

// ********************************* DEPLOY GLOBALFILE *****************************************
function deploy_globalfile($id_file,$id_host){
	$hostname = get_host_name($id_host);
	$hostip = get_host_ip($id_host);
	
        $gfiles = mysql_query( "SELECT * FROM `globalfiles` WHERE `id` = '$id_file'" )
                    or die (mysql_error()."<br>Couldn't execute query: $query");
        $nr_gbfiles = mysql_num_rows( $gfiles );
        if(!empty($nr_gbfiles)) {

		// Preparing file,path, etc...
		$gfilerow = mysql_fetch_array($gfiles);
		$path=$gfilerow['path'];
		$name=$gfilerow['name'];
		//$filecontents=$gfilerow['text'];
		$localfile=$gfilerow['localfile'];
		$now=date("Ymd-His");

		// Testing connectivity... 
		if ( test_connection($hostname) != "OK" )
		{
			$message.="<img src='images/error.gif'>Connection failed. Please see output below.<br>\n";
			return $message;
		} else {
			$message.="<img src='images/ok.gif'>SSH connection is OK.<br>\n";
		}

		// Testing presence of file
		if ( test_presence($hostname,$path/$name) == 1 )
		{
			$message.="<img src='images/warning.gif'>$path/$name was not found...<br>\n";
		} else {
			// File is present, we try to back it up
			// Archiving current file
			$output = shell_exec("ssh ".$GLOBALS['sudousr']."@$hostname cp $path/$name $path/$name.$now 2>&1");
			if (empty($output)){
				// Archiving is OK
				$message.="<img src='images/ok.gif'>$path/$name has been backup successfully.<br>\n";
			} else {
				$message.="<img src='images/error.gif'>$path/$name could not be backed up.<br>\n";
				return $message;
			}
		}

		// Deploying
		$output = shell_exec("scp $localfile ".$GLOBALS['sudousr']."@$hostname:$path/$name 2>&1");

		if (empty($output)){
		// File was correctly transfered
			$message.="<img src='images/ok.gif'>$path/$name was correctly updated.<br>\n";
			$output = shell_exec("ssh ".$GLOBALS['sudousr']."@$hostname chmod 440 $path/$name 2>&1");
			if (empty($output)){
				$message.="<img src='images/ok.gif'>Permission changed successfully to 440 for file $path/$name.<br>\n";
			} else {
				$message.="<img src='images/error.gif'>Could not change permission to 440 for file $path/$name.<br>\n";
			}
		} else {
			$message.="<img src='images/error.gif'>An error occured during the update.<br>\n";
		}
	} else {
		$message.="<img src='images/error.gif'>No global file found with id $id<br>\n";
	}
	return $message;
}

// Clean Known_hosts file

function ssh_clean_known_hosts_file($hostname,$ip)
{
    $output[].="Removing <b>$hostname</b> PubKey from known_hosts";
    exec("ssh-keygen -q -R $hostname 2>&1",$output,$statut1);
    
    $output[].="\n<br>Removing <b>$ip</b> PubKey from known_hosts";
    exec("ssh-keygen -q -R $ip 2>&1",$output,$statut2);
    
    $statut= $statut1+$statut2;
    for ($i=0;$i<count($output);$i++) { $output_final.=$output[$i]."<br>\n"; }
    
    if ($statut==0) {
        return("<img src='images/ok.gif'>$output_final<br>\n");
    } else {
        return("<img src='images/error.gif'>$output_final<br>\n");
    }
}

// Get Application version

function get_version()
{
	$result = mysql_query( "SELECT val FROM `config`" )
                             or die (mysql_error()."<br>Couldn't execute query: $query");
	$row=mysql_fetch_array($result);
	$val=$row["val"];
	mysql_free_result( $result );
	return($val);
    }
?>
