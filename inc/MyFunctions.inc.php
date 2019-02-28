<?php

include_once('config.inc.php'); // Our global configuration file
include_once('database.inc.php'); // Our database connectivity file

// Check if Hostname is already used
// // ****************************** DISPLAY GROUP AVAILABLE ****************************************
function exists_hostname($name){
    //Display the selection box for the groups
    $query = "SELECT * FROM `hosts` where `name`='" . $name . "'";
    $result = mysqli_query($GLOBALS['mysql_link'], $query )
                             or die (mysqli_error()."<br>Couldn't execute query: $query");

    $nr = $result->num_rows;
    mysqli_free_result( $result );
    return($nr);
}

// Check if Hostgroup is already used
// // ****************************** DISPLAY GROUP AVAILABLE ****************************************
function exists_hostgroup($name){
    //Display the selection box for the groups
    $query = "SELECT * FROM `groups` where `name`='" . $name . "'";
    $result = mysqli_query($GLOBALS['mysql_link'], $query )
                             or die (mysqli_error()."<br>Couldn't execute query: $query");

    $nr = $result->num_rows;
    mysqli_free_result( $result );
    return($nr);
}

// ****************************** DISPLAY GROUP AVAILABLE ****************************************
function display_available_hosts(){
    //Display the selection box for the groups
    $result = mysqli_query($GLOBALS['mysql_link'], "SELECT * FROM `hosts` ORDER BY `name` " )
                             or die (mysqli_error()."<br>Couldn't execute query: $query");

    $nr = $result->num_rows;
    if(empty($nr)) {
      echo 'No host found...';
    }
    else {
      echo '<select class="list" name="host">';
      echo '<option selected value="0">Please select a host</option>';
      while( $row = mysqli_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
		$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysqli_free_result( $result );
    }
}


// ****************************** DISPLAY GROUP AVAILABLE ****************************************
function display_available_groups($id_hostgroup){

    //Display the selection box for the groups
    $result = mysqli_query($GLOBALS['mysql_link'], "SELECT * FROM `groups` ORDER BY `name` " )
                             or die (mysqli_error()."<br>Couldn't execute query: $query");

    $nr = $result->num_rows;
    if(empty($nr)) {
      echo 'No group found...';
    }
    else {
      echo '<select class="list" name="group">';
      echo '<option selected value="1">Please select a group</option>';
      while( $row = mysqli_fetch_array( $result ))
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
      mysqli_free_result( $result );
    }
}

function get_all_hostgroups()
{
    $hostgroup_ar=array();
    
    $hostgroup=mysqli_query( $GLOBALS['mysql_link'], "SELECT * FROM `groups` ORDER BY `name`" )
                            or die (mysqli_error()."<br>Couldn't execute query: $query");

    $hostgroup_nr = $hostgroup->num_rows;
    if (!empty($hostgroup_nr)) {
        while( $hostgroup_row = mysqli_fetch_array( $hostgroup ))
        {
                  // Afecting values
                  $name = $hostgroup_row["name"];
                  $id_hostgroup = $hostgroup_row["id"];

                  $hostgroup_ar[$id_hostgroup]=$name;
          }
          mysqli_free_result( $hostgroup );
    }
    return ($hostgroup_ar);
}


function get_group_name($id_hostgroup){

    //Display the selection box for the groups
    $result = mysqli_query($GLOBALS['mysql_link'], "SELECT name FROM `groups` WHERE `id`='$id_hostgroup' " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");
    $nr = $result->num_rows;
    if(empty($nr)) {
      return ('No group assigned');
    }
    else {
      $row = mysqli_fetch_array( $result );
      mysqli_free_result( $result );
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
    $result = mysqli_query($GLOBALS['mysql_link'], "SELECT * FROM `keys` ORDER BY `name` " )
                             or die (mysqli_error()."<br>Couldn't execute query: $query");

    $nr = $result->num_rows;
    if(!empty($nr)) {
      while( $row = mysqli_fetch_array( $result ))
      {
	$id=$row['id'];
	$name=$row['name'];
        // Afecting values
	$res[$id]['name']=$name;
      }
      mysqli_free_result( $result );
    }
    return ($res);
}

// ****************************** DISPLAY ACCOUNT AVAILABLE ****************************************
function display_availables_accounts(){
    $result = mysqli_query($GLOBALS['mysql_link'], "SELECT * FROM `accounts` ORDER BY `name` " )
                             or die (mysqli_error()."<br>Couldn't execute query: $query");

    $nr = $result->num_rows;
    if(empty($nr)) {
      echo 'No account found...';
    }
    else {
      echo '<select class="list" name="account">';
      while( $row = mysqli_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
		$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysqli_free_result( $result );
    }
}

// ****************************** DISPLAY keyring AVAILABLE ****************************************
function display_availables_keyrings(){
    $result = mysqli_query( $GLOBALS['mysql_link'], "SELECT * FROM `keyrings` ORDER BY `name` " )
                             or die (mysqli_error()."<br>Couldn't execute query: $query");

    $nr =$result->num_rows;
    if(!empty($nr)) {
      echo '<select class="list" name="keyring">';
      echo '<option selected value="0">Please select a keyring</option>';
      while( $row = mysqli_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
	$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysqli_free_result( $result );
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
    $result = mysqli_query( $GLOBALS['mysql_link'],"SELECT * FROM `keys` WHERE `id` = '$id' " )
		or die (mysqli_error()."<br>Couldn't execute query: $query");

    $nr = $result->num_rows;
    if(empty($nr)) {
      return('Zombie Key');
    }
    else {
      $row = mysqli_fetch_array( $result );
      mysqli_free_result( $result );
      return $row['name'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_account_name($id){
    $result = mysqli_query($GLOBALS['mysql_link'], "SELECT * FROM `accounts` WHERE `id` = '$id' " )
		or die (mysqli_error()."<br>Couldn't execute query: $query");

    $nr = $result->num_rows;
    if(empty($nr)) {
      return('Zombie account');
    }
    else {
      $row = mysqli_fetch_array( $result );
      mysqli_free_result( $result );
      return $row['name'];
    }
}
function get_all_keyrings($id_host='',$id_account='')
{

if (($id_host!='')&&($id_account!=''))
	$req="SELECT * FROM keyrings where id not in (SELECT id_keyring from hak where id_host=$id_host and id_account=$id_account) ORDER BY `name`";
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
    $result = mysql_query( "SELECT `ip`,`name` FROM `hosts` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      return '';
      //echo 'No host found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      //return $row['ip'];
  
      // Beware IPV4 only....
      return (gethostbyname($row['name']));
    }
}

// ****************************** GET HOST SSH PORT ****************************************
function get_host_ssh_port($id){
    $result = mysql_query( "SELECT `ssh_port`,`name` FROM `hosts` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      return 22;
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['ssh_port'];
    }
}

// ****************************** GET ALL HOSTS INFORMATION ****************************************
function get_all_hosts(){
    $result = mysql_query( "SELECT *  FROM `hosts` ORDER BY `name` " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nb=0;
    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      return(array());
    } else {
        while( $row = mysql_fetch_array($result))
        {
          $id=$row['id'];
          $hosts [$id]['name'] = $row['name'];
          $hosts [$id]['ip'] = $row['ip'];
          $hosts [$id]['icon'] = $row['icon'];
          $hosts [$id]['serialno'] = $row['serialno'];

        }
        mysql_free_result( $result );
        return ($hosts);
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

function prepare_authorizedkey_file($id,$id_account,$id_run){
    
	global $SKM_AUTH_MSG;
        // Initialising variables
        $hostname = get_host_name($id);
        $account_name = get_account_name($id_account);
        $now = date("Ymd-His");

	$message="";

	// Add default message;
	$authorized_keys="$SKM_AUTH_MSG\n";

        // -----------------------------------------------
        // We get all keys associated with current keyring/account
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
        $tmp_file="/tmp/skm_tmp_authorized_keys.$id.$id_account.$id_run";
        $handle = fopen($tmp_file,"w");
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

        $handle = fopen("/tmp/skm_new_authorized_keys.$id_run","w");
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


function deploy_authorizedkey_file($id,$id_account,$id_run,$create_user=0){
    // Initialising variables
    $hostname = get_host_name($id);
    $hostip = get_host_ip($id);
    $ssh_port = get_host_ssh_port($id);
    $account_name = get_account_name($id_account);
    $now = date("Ymd-His");
    
    $ssh_dir_output='';
    
    $opts="$ssh_port -o ConnectTimeout=".$GLOBALS['ssh_timeout'];
    $opts_ssh="-p $opts";
    $opts_scp="-P $opts";
    
    // Temporary file containig new authorized_keys
    $tmp_file="/tmp/skm_tmp_authorized_keys.$id.$id_account.$id_run";
    // Nom du fichier récupéré sur le serveur SKM
    $tmp_local_file="/tmp/skm_tmp_remote_authorized_keys.$id.$id_account.$id_run";
            
    $message="";
    // Getting homedir of current user
    $output = shell_exec("ssh $opts_ssh ".$GLOBALS['sudousr']."@$hostname grep \"$account_name\:\" /etc/passwd 2>&1");

    if (empty($output)&&$create_user) {
        // Account does not exist           
        // So we want to create user ....
        exec("ssh $opts_ssh ".$GLOBALS['sudousr']."@$hostname \"adduser --quiet --disabled-password --gecos '' $account_name\" 2>&1 ",$create_output,$create_return_val);
        if ($create_return_val!=0) {
            // oups account not created
                for ($i=0;$i<count($create_return_val);$i++) { $output_final.=$create_return_val[$i]."<br>\n"; }
                $message.="<img src='images/error.gif'>Can 't create user $account_name on $hostname<br>\n$output_final";
        } else {
            // Account was created
            // Getting again homedir of current user (it's better to test again)
            $output = shell_exec("ssh $opts".$GLOBALS['sudousr']."@$hostname grep \"$account_name\:\" /etc/passwd 2>&1");

            $message.="<img src='images/ok.gif'>Account $account_name on $hostname created<br>\n";

            $ssh_dir_output=exec("ssh $opts_ssh ".$GLOBALS['sudousr']."@$hostname \"mkdir ~$account_name/.ssh ;chmod 700 ~$account_name/.ssh; chown $account_name:$account_name ~$account_name/.ssh \" 2>&1",$ssh_dir_output,$ssh_dir_val);
            if (!empty($ssh_dir_output)) {
                for ($i=0;$i<count($ssh_dir_output);$i++) { $output_final2.=$ssh_dir_output[$i]."<br>\n"; }
                $message.="<img src='images/error.gif'>Can 't create .ssh directory for $account_name on $hostname<br>\n$output_final2";
            } else {
                $message.= "<img src='images/ok.gif'>.ssh Directory created for $account_name on $hostname<br>\n";
            }

       }
    } elseif (empty($output) ){
        $message.= "<img src='images/error.gif'>User $account_name not found on $hostname<br>\n";
    }
    if (!empty($output)){
            // There's an answer, let's go
            list($field1,$field2,$field3,$field4,$field5,$homedir,$shell) = explode(":",$output);
            $message.= "<img src='images/ok.gif'>homedir of $account_name on $hostname is $homedir<br>\n";

            // Testing presence of file
            // Uncomment for IP if ( test_presence($hostip,"$homedir/.ssh/authorized_keys") == 1 )
            if ( test_presence($hostname,"$homedir/.ssh/authorized_keys",$ssh_port ) == 1 )
            {
                    $message.="<img src='images/warning.gif'>$homedir/.ssh/authorized_keys was not found...<br>\n";
            } else {
                // Archiving destination file
                // Uncomment for IP : $output = shell_exec("ssh ".$GLOBALS['sudousr']."@$hostip cp $homedir/.ssh/authorized_keys $homedir/.ssh/authorized_keys.$now 2>&1");
                $backup_file = "$homedir/.ssh/authorized_keys.$now";

                $output = shell_exec("ssh $opts_ssh ".$GLOBALS['sudousr']."@$hostname cp $homedir/.ssh/authorized_keys $backup_file 2>&1");
                if (empty($output)){
                        //everything was fine
                        $message .= "<img src='images/ok.gif'>authorized_keys has been archived successfully to $backup_file<br>\n";
                } else {
                        $message .= "<img src='images/error.gif'>authorized_keys could NOT be archived to $backup_file<br>\n";
                        return $message;
                }
                // Get new authorized keys
                // Uncomment for IP $output = shell_exec("scp ".$GLOBALS['sudousr']."@$hostip:/$homedir/.ssh/authorized_keys $tmp_diff_file 2>&1");
                $output = shell_exec("scp $opts_scp ".$GLOBALS['sudousr']."@$hostname:/$homedir/.ssh/authorized_keys $tmp_local_file 2>&1");
                if (!empty($output)){
                        //everything was fine
                        $message .= "<img src='images/error.gif'>authorized_keys could not be copied locally ($output). The diff test might not be valid.<br>\n";
                }
                // Changing rights (really needed ?)
                $output = shell_exec("chmod 740 $tmp_local_file 2>&1");
                if (!empty($output)){
                        //everything was fine
                        $message .= "<img src='images/error.gif'>authorized_keys could not chg perm on $tmp_local_file ($output). The diff test might not be valid.<br>\n";
                }
            }

            // Uncomment for IP $output = shell_exec("scp $tmp_file root@$hostip:$homedir/.ssh/authorized_keys 2>&1");
            
            // Send new authorized_keys on server
            $output = shell_exec("scp $opts_scp $tmp_file ".$GLOBALS['sudousr']."@$hostname:$homedir/.ssh/authorized_keys 2>&1");
            if (empty($output)){
                //everything is fine
                $message .= "<img src='images/ok.gif'>File authorized_keys has been pushed successfully to $hostname for account $account_name<br>\n";
                //comparing number of keys
                $differences = "";
                $differences = shell_exec("diff --ignore-blank-lines -u  $tmp_file $tmp_local_file | grep -v ^--- | grep -v ^+++  |grep -v ^@@ | sed 's/^-/<img src=images\/add.gif> /g' | sed 's/^+/<img src=images\/error.gif> /g' | sed 's/$/<br>/g'");
                #$differences = shell_exec("diff --ignore-blank-lines -u $tmp_file $tmp_local_file | grep -v ^--- | grep -v ^+++  | sed 's/^-/<img src='images/error.gif'><P class=delete> /g' | sed 's/^+/<P class=add> /g' | sed 's/^ ssh-rsa/<p > /g' | sed 's/$/<\/P>/g'");

                if ( empty($differences)){
                        $message .= "<br><img src='images/warning.gif'>Files are identicals<br>\n";
                } else {
                        $message .= "<br>File comparison output :<br>\n";
                        $message .= $differences;
                }
             } else {
                $message .= "<img src='images/error.gif'>An error occured while pushing file authorized_keys to $hostname for account $account_name\n$output"."<br>\n";
             }
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
function test_connection($host,$accept_pub_key,$ssh_port=22){
    
    $output_final='';
    
    $opts="$ssh_port -o ConnectTimeout=".$GLOBALS['ssh_timeout'];
    $opts_ssh="-p $opts";
    
    if ($accept_pub_key) $opts_ssh.=' -oStrictHostKeyChecking=no';
    //$output = shell_exec("ssh $opts_ssh ".$GLOBALS['sudousr']."@$host ls -la| grep '^.'");
    //if ( empty($output ))
    {
        exec("ssh $opts_ssh ".$GLOBALS['sudousr']."@$host ls -la 2>&1",$output,$return_val);
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
function test_presence($host,$file,$ssh_port=22){
    
    $opts="$ssh_port -o ConnectTimeout=".$GLOBALS['ssh_timeout'];
    $opts_ssh="-p $opts";
    
    $output = shell_exec("ssh $opts_ssh ".$GLOBALS['sudousr']."@$host ls -la $file");
    
    if ( empty($output )) return 1;
    else return 0;
}

// ********************************* DEPLOY GLOBALFILE *****************************************
function deploy_globalfile($id_file,$id_host){
	$hostname = get_host_name($id_host);
	$hostip = get_host_ip($id_host);
	$ssh_port = get_host_ssh_port($id_host);
        
        $opts="$ssh_port -o ConnectTimeout=".$GLOBALS['ssh_timeout'];
        $opts_ssh="-p $opts";
        
        
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
		if ( test_presence($hostname,$path/$name,$ssh_port) == 1 )
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
		$output = shell_exec("scp $opts_ssh $localfile ".$GLOBALS['sudousr']."@$hostname:$path/$name 2>&1");

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
	$result = mysqli_query($GLOBALS['mysql_link'], "SELECT val FROM `config`" )
                             or die (mysqli_error()."<br>Couldn't execute query: $query");
	$row=mysqli_fetch_array($result);
	$val=$row["val"];
	mysqli_free_result( $result );
	return($val);
}
function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            //return $current_key;
            return true;
        }
    }
    return false;
}
  
// Must be implemented
function delete_account()
{
    
}
// Delete all accounts of a host
// -----------------------------
// Input :
//      - Id of host
// Output :
//      - null if accounts are deleted
//      - error string if error

function delete_host_accounts($id_host)
{
    $result = mysql_query( "DELETE FROM `hosts-accounts` WHERE `id_host`='$id_host';" );
    if (!isset($result)) {
        $err=mysql_error();
        mysql_free_result($result);
        return($err);
    }
}
// Delete all keys/keyring/account association of a host
// -----------------------------
// Input :
//      - Id of host
// Output :
//      - null if deletion worked
//      - error string if deletion failed
function delete_host_keys_keyrings($id_host)
{
    $result = mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id_host';" );
    if (!isset($result)) {
        $err=mysql_error();
        mysql_free_result($result);
        return($err);
    }
}
// Delete a host
// -----------------------------
// Input :
//      - Id of host
// Output :
//      - null if deletion worked
//      - error string if deletion failed
function delete_host($id_host)
{
    // First delete accounts
    $res_del_a=delete_host_accounts($id_host);
    if ($res_del_a) {
        // Oups deletion is not completed !
        return($res_del_a);
    }
    // Accounts are deleted so delete keys/keyrings account association for this host
    $res_del_k=delete_host_keys_keyrings($id_host);
    if ($res_del_k) {
        // Oups deletion is not completed !
        return($res_del_k);
    }
    // So accounts and keys association are deleted, we can delete host
     $result = mysql_query( "DELETE FROM `hosts` WHERE `id`='$id_host';" );
    if (!$result) {
        $err=mysql_error();
        echo "--".mysql_error()."--";
        mysql_free_result($result);
        return($err);
    }
    // If job is completed, NULL is send
}
// ADD a host
// -----------------------------
// Input :
//      - too much elements
// Output :
//      - null if deletion worked
//      - error string if deletion failed
function add_host($hostname,$ip='',$id_group='',$serialno='',$memory='',$osversion='',
        $cabinet='',$uloc='',$cageno='',$model='',$procno='',$provider='',$install_dt,$po='',$cost='',
        $maint_cost='',$maint_po='',$maint_provider='',$maint_end_dt='',$life_end_dt='',$ostype='',
        $osvers='',$intf1='',$intf2='',$defaultgw='',$monitor='',$selinux='',$datechgroot='')
{
      $result = mysql_query( "INSERT INTO `hosts` (`name`,`ip`,`id_group`,`serialno`,`memory`,`osversion`,`cabinet`,"
              . "`uloc`,`cageno`,`model`,`procno`,`provider`,`install_dt`,`po`,`cost`,`maint_cost`,`maint_po`,"
              . "`maint_provider`,`maint_end_dt`,`life_end_dt`,`ostype`,`osvers`,`intf1`,`intf2`,`defaultgw`,"
              . "`monitor`,`selinux`,`datechgroot`) "
              . "VALUES('$hostname','$ip','$group','$serialno','$memory','$osversion','$cabinet','$uloc',"
              . "'$cageno','$model','$procno','$provider','$install_dt','$po','$cost','$maint_cost',"
              . "'$maint_po','$maint_provider','$maint_end_dt','$life_end_dt','$ostype','$osvers',"
              . "'$intf1','$intf2','$defaultgw','$monitor','$selinux','$datechgroot')" );
 
    if (!$result) {
        $err=mysql_error();
        echo "--".mysql_error()."--";
        mysql_free_result($result);
        return($err);
     }
    $id = mysql_insert_id();

    // add account root (id 1) to created host
    $result = mysql_query("INSERT INTO `hosts-accounts` (`id_host`,`id_account`) VALUES ('$id','1')");
   if (!$result) {
        $err=mysql_error();
        echo "--".mysql_error()."--";
        mysql_free_result($result);
        return($err);
     }
    // add SKM Public Key (id 1) for user root on created host
    $result = mysql_query("INSERT INTO `hak` (`id_host`,`id_account`,`id_key`) VALUES ('$id','1','1')");
    if (!$result) {
        $err=mysql_error();
        echo "--".mysql_error()."--";
        mysql_free_result($result);
        return($err);
     }   
}
?>
