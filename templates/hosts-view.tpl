{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
   {if $hostgroup==0}
<table class=sortable>
    <caption>{$group_name}</caption><tr><td class='detail1'>No host defined</td></tr>
</td></tr></table>
        {else}
  <table class=sortable>
    <caption>{$group_name}</caption>

      <thead><tr><th>icon</th><th>Hostname</th><th>IP @</th>
        {if isset($SKM_GLPI)}
	<th>Serial #</th><th>OS type</th><th>OS Version</th><th>Monitor</th></tr>
	{/if}
       </thead>
	
      <tbody>
	{foreach from=$hostgroup key=idx item=host}
		
                <td class='title'><img src='{$host.icon}' border='0'></td>
                <td><a href='host-view.php?id={$idx}&id_hostgroup={$id_hostgroup}'>{$host.name}</a></td>
                <td>{$host.ip}</td>
                {if isset($SKM_GLPI)} 
                <td>{$host.serialno}</td>
                <td>{$host.ostype}</td>
                <td>{$host.osvers}</td>
		{/if}
      		</tbody>
	{/foreach}
{/if}

</td></tr></table>
{include file="footer.tpl"}
