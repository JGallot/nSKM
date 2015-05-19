{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>

<table class=sortable>
<center><fieldset><legend>All Hosts Overview</legend>

<div id="onglets_html">
    <ul class="paginate pag1 clearfix" id="onglets">
        {for $var=1 to $nb_pages}
            {if $current_page == $var}   
            <li class="current">{$var}</li>
            {else}
            <li class="single"><a href="?page={$var}">{$var}</a></li>
            {/if}
        {/for}
    </ul>
</div>

<thead><tr><th>icon</th><th>Hostname</th><th>IP @</th>
{if isset($SKM_GLPI)}
<th>Serial #</th><th>OS type</th><th>OS Version</th><th>Monitor</th></tr>
{/if}
</thead><tbody>
{foreach from=$hosts key=idx item=host}
{if $host.odd==1}
<tr class=odd>
{else}
<tr>
{/if}
<td class='title'><img src='{$host.icon}' border='0'></td>
<td><a href='host-view.php?id={$idx}&id_hostgroup={$host.id_group}'>{$host.name}</a></td>
<td>{$host.ip}</td>
{if isset($SKM_GLPI)}
<td>{$host.serialno}</td><td>{$host.ostype}</td><td>{$host.osvers}</td>
{/if}
{if $host.monitor != ''}
 <td><img src='images/ok.gif'></td>
{else}
<td></td>
{/if}

{/foreach}
</tr></tbody></table>

{include file="footer.tpl"}
