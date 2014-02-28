{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
{if $step==''}    
<center>
    <form name="serial_search" action="serial_search.php" method="post">
    <fieldset><legend>Looking for a host serial number</legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type" width="40%">Serial Number : </td>
        <td class="Content" width="60%">
        <input name="serial" size="50" type="text" maxlength="255" value="">
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
<center><fieldset><legend>Searching for serial number {$serial}</legend>
{if !isset($hosts)}
      No host found with that serial number...
  {else}
	<table class='listegenerale'><tr><td>Server</td><td># Serie</td><td>Operating System</td><td># Processors</td><td>Supplier</td></tr>
	{foreach from=$hosts key=idx item=host}
                <td><a href='hosts_setup.php?id={$idx}&id_hostgroup={$host.id_group}'>{$host.name}</td></a>
		<td><a href='hosts_setup.php?id={$idx}&id_hostgroup={$host.id_group}'>{$host.serialno}</a></td>
		<td>{$host.os}</td><td>{$host.procno}</td><td>{$host.provider}</td></tr>
        {/foreach}
     </table>
{/if}
{/if}

{include file="footer.tpl"}
