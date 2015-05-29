{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<script type="text/javascript" src="js/hosts_sync.js"></script>
<td width='80%'>
  <table class=sortable>
      <caption>Result of hosts synchronization</caption>
      <thead><th>Hostname</th><th>Result</th></thead>
	{foreach from=$result key=hostname item=host}
        <tbody>
            <td>{$hostname}</td>
            <td><img src='images/{$host.statut}.gif'>{$host.message}</td>
        </tbody>
	{/foreach}
</td></tr></table>
{include file="footer.tpl"}
