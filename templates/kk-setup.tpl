{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
    <center>
    <form name="setup_kk" action="kk_setup.php" method="post">
    <fieldset><legend>Adding key(s) to keyring {$keyring_name}</legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type">
	<select class="list" name="key">
	<option selected value="0">Please select a key</option>
	{foreach from=$allkeys key=idx item=mkey}
	<option value={$idx}>{$mkey.name}</option>
	{/foreach}
	</select>
        </td>
      </tr>
      </table>
      </fieldset>
      <center>
      <input name="step" type="hidden" value="1">
      <input name="id" type="hidden" value="{$keyring_id}>">
      <input name="submit" type="submit" value="add">
      </center>
    </form>
    </center>
{include file="footer.tpl"}
