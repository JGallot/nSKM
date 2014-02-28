{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>

{if !isset($hosts)}
<center>
    <form name="search_keyring_securities" action="search_keyring_securities.php" method="post">
    <fieldset><legend>Select a keyring </legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type"><img src='images/keyring_little.gif'>
      <select class="list" name="keyring">;
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
      <input name="submit" type="submit" value="Search">
      </center>
    </form>
    </center>
{else}
<fieldset><legend>Seaching securities for keyring {$keyring_name}</legend>
    <table class='detail'>
	{foreach from=$hosts key=idx item=host}
                <tr><td class='title'><img src='images/server.gif' border='0'>{$host.name}</td></tr>
		{foreach from=$host.accounts key=idx2 item=account}
       			 <tr><td class='detail2'><img src='images/mister.gif' border=0>{$account}</td></tr>
		{/foreach}
		
	{/foreach}
	<center><a href='skm/search_keyring_securities.php'>Click here for a new search</a></center>
    </fieldset>
{/if}
{include file="footer.tpl"}
