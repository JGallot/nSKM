{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<script type="text/javascript" src="js/hosts_sync.js"></script>
<td width='80%'>
   {if (($hosts_2_delete==0)&&($hosts_2_add==0)) }
<table class=sortable>
    <caption>{$group_name}</caption><tr><td class='detail1'>No hosts found</td></tr>
</td></tr></table>
        {else}
  <table class=sortable>
      <caption>{$title}</caption>
      <thead><th><input type="checkbox" onchange="checkAll(this)" name="chk[]" />Check/Uncheck All</th><th>Hostname</th><th>IP @</th></thead>
	<form name="sync_hosts" action="hosts_sync.php" method="post">
	{foreach from=$hosts_2_add key=idx item=host}
         <tbody>
         <td><input type="checkbox" name="addhosts[]" value="{$host.name}" /><font color='green'><b>Add</b></font></td>		
                <td>{$host.name}</td>
                <td>{$host.ip}</td>
        </tbody>
	{/foreach}
        {foreach from=$hosts_2_delete key=idx item=host}
          <tbody>
          <td><input type="checkbox" name="deletehosts[]" value="{$idx}" /><font color='red'><b>Delete</b></font></td>
		<td>{$host.name}</td>
                <td>{$host.ip}</td>
        </tbody>
	{/foreach}
        <tr><td colspan='5'><center>
        <input name="step" type="hidden" value="1">
        <input name="submit" type="submit" value="Update SKM Hosts" disabled'>
        </center>
{/if}

</td></tr></table>
{include file="footer.tpl"}
