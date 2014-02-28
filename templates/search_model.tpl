{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>

{if !isset($hosts)&&!isset($step)}     
<center>
    <form name="model_search" action="search_model.php" method="post">
    <fieldset><legend>Looking for a host model number</legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type" width="40%">Model Number : </td>
        <td class="Content" width="60%">
        <input name="model" size="50" type="text" maxlength="255" value="">
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
{if !isset($hosts)}
      No host found with that model number...
{else}

  <center><fieldset><legend>Searching for model number {$model}</legend>

      <table class='listegenerale'><tr><td>Serveur</td><td># Serie</td><td>Systeme d'exploitation</td><td># processeurs</td><td>Fournisseur</td><td>Model</td></tr>
	{foreach from=$hosts key=idx item=host}
        	<tr class='{$host.class}'>
                <td><a href='hosts_setup.php?id={$idx}&id_hostgroup={$host.id_group}'>{$host.hostname}</td></a>
		<td><a href='hosts_setup.php?id={$idx}&id_hostgroup={$host.id_group}'>{$host.serialno}</a></td>
		<td>{$host.osversion}</td><td>{$host.procno}</td><td>{$host.provider}</td><td>{$host.model}</td></tr>
        {/foreach}
</table>

{/if}

{/if}
{include file="footer.tpl"}

