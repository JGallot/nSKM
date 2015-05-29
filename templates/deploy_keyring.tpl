{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
    <center>
    <form name="choose_keyring" action="deploy_keyring.php" method="post">
    <fieldset><legend>Selecting a keyring to deploy</legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type"><img src='images/keyring_little.gif'>

      <select class="list" name="id_keyring">;
      <option selected value="0">Please select a keyring</option>
        {foreach from=$keyrings key=idx item=mkey}
        <option value={$idx}>{$mkey}</option>
        {/foreach}
      </select>
        </td>
      </tr>
    </table>
    </fieldset>
      <center>
      <input name="step" type="hidden" value="1">
      <input name="submit" type="submit" value="Deploy">
      </center>
    </form>
    </center>
{include file="footer.tpl"}
