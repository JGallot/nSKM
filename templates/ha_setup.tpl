{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
    
<td width='80%'>
<form name="setup_ha" action="ha_setup.php" method="post">
    <fieldset><legend>Adding Account(s) to host {$host_name}</legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type">
      	<select class="list" name="account">';
	
	{foreach from=$accounts key=idx item=name}
        <option value={$idx}>{$name}</option>
	{/foreach}


	</td>
        </td>
      </tr>
      </table>
      </fieldset>
      <center>
      <input name="step" type="hidden" value="1">
      <input name="id_hostgroup" type="hidden" value="{$id_hostgroup}">
      <input name="id" type="hidden" value="{$id_host}">
      <input name="submit" type="submit" value="add">
      </center>
    </form>
    </center>
{include file="footer.tpl"}

