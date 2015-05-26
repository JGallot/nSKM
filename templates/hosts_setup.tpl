{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<script type="text/javascript" src="js/common_functions.js"></script>
<script type="text/javascript" src="js/hosts_setup.js" ></script>
        <td width='80%'>
            <center>
            <form name="setup_host" action="hosts_setup.php" method="post" onsubmit="return check_myform(this);">
            <!-- Host info -->
            <fieldset><legend>Add / Modify a host</legend>
            <table border='0' align='center' class="modif_contact">
              <tr>
                    <td class="Type" width="40%">Host Name : </td>
                    <td class="Content" width="60%">
                    <input name="name" size="50" type="text" maxlength="255" value="{$name}"
                           onchange="update_infos(this.value);">
                    <label id="nameHint"></label>
                    </td>
              </tr>
              <tr>
                    <td class="Type" width="40%">Host IP :</td>
                    <td class="Content" width="60%">
                        <input id="ip" name="ip" size="50" type="text" maxlength="255"
                               {if isset($ip)}
                                   {if ({$ip}!="")}
                                   value="{$ip}"
                                   {/if}
                               {/if} >
                    </td>
              </tr>
              <tr>
                    <td class="Type">Host group available : </td>
                    <td class="Content" width="60%">
                    <select class="list" name="group">
                            <option selected value="1">Please select a group</option>
                            {foreach from=$menu_hostgrps key=m_id item=m_value}
                            <option value={$m_id}>{$m_value}</option>
                            {/foreach}
                    </select>
                    </td>
              </tr>
            </table>
            </fieldset>

            {if $SKM_GLPI eq 1}
            <!-- Installation info -->
            <fieldset><legend>Installation information</legend>
            <table border='0' align='center' class="modif_contact">
              <tr> <td class="Type" width="40%"> OS Type : </td> <td class="Content" width="60%">
              <input name="ostype" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%"> OS Version : </td> <td class="Content" width="60%">
              <input name="osvers" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%"> Interface #1 : </td> <td class="Content" width="60%">
              <input name="intf1" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%"> Interface #2 : </td> <td class="Content" width="60%">
              <input name="intf2" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%"> Default Gateway : </td> <td class="Content" width="60%">
              <input name="defaultgw" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%"> Is this hosts monitored ? : </td> <td class="Content" width="60%">
              <input name="monitor" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%"> SELINUX config : </td> <td class="Content" width="60%">
              <input name="selinux" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%"> Root passwd change date : </td> <td class="Content" width="60%">
              <input name="datechgroot" size="50" type="text" maxlength="255" value=""> </td> </tr>
            </table>
            </fieldset>

            <!-- Additional info -->
            <fieldset><legend>Additional information</legend>
            <table border='0' align='center' class="modif_contact">
              <tr> <td class="Type" width="40%">Serial Number : </td> <td class="Content" width="60%">
              <input name="serialno" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Model : </td> <td class="Content" width="60%">
              <input name="model" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Memory : </td> <td class="Content" width="60%">
              <input name="memory" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Processor Info : </td> <td class="Content" width="60%">
              <input name="procno" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Provider : </td> <td class="Content" width="60%">
              <input name="provider" size="50" type="text" maxlength="255" value=""> </td> </tr>
            </table>
            </fieldset>

            <!-- Location Information -->
            <fieldset><legend>Location information</legend>
            <table border='0' align='center' class="modif_contact">
              <tr> <td class="Type" width="40%">Cage Number : </td> <td class="Content" width="60%">
              <input name="cageno" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Cabinet : </td> <td class="Content" width="60%">
              <input name="cabinet" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">U Location: </td> <td class="Content" width="60%">
              <input name="uloc" size="50" type="text" maxlength="255" value=""> </td> </tr>
            </table>
            </fieldset>
            <fieldset><legend>Contract information</legend>
            <table border='0' align='center' class="modif_contact">
              <tr> <td class="Type" width="40%">Installation date : </td> <td class="Content" width="60%">
              <input name="install_dt" size="10" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">PO : </td> <td class="Content" width="60%">
              <input name="po" size="11" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Initial cost: </td> <td class="Content" width="60%">
              <input name="cost" size="12" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Maintenance cost: </td> <td class="Content" width="60%">
              <input name="maint_cost" size="12" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Maintenance PO : </td> <td class="Content" width="60%">
              <input name="maint_po" size="11" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Maintenance Provider : </td> <td class="Content" width="60%">
              <input name="maint_provider" size="50" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">Maintenance end : </td> <td class="Content" width="60%">
              <input name="maint_end_dt" size="10" type="text" maxlength="255" value=""> </td> </tr>
              <tr> <td class="Type" width="40%">End of life : </td> <td class="Content" width="60%">
              <input name="life_end_dt" size="10" type="text" maxlength="255" value=""> </td> </tr>
            </table>
            </fieldset>
            {/if}
            <center>
              <input name="step" type="hidden" value="1">
              <input name="id" type="hidden" value="{$id}">
              <input name="submit" type="submit" value="add/modify">
            </center>
            </form>
            </center>
        </td>
    </tr>
</table>
{include file="footer.tpl"}
