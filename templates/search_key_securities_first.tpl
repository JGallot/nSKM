{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
    
<center>
    <form name="search_key_securities" action="search_key_securities.php" method="post">
    <fieldset><legend>Select a key </legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type"><img src='images/key_little.gif'>
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
      <input name="submit" type="submit" value="Search">
      </center>
    </form>
    </center>
{include file="footer.tpl"}
