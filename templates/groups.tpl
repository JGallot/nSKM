{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
   <fieldset><legend>Groups <a href="groups_setup.php">[add a group]<img src='images/add.gif' border='0'></a></legend>
   <table class='detail'>
    {if !isset($tab_groups)}
      <tr><td class='detail1'>No group found</td><td class='detail2'></td></tr>
	{else}
	{foreach from=$tab_groups key=m_id item=m_value}
        <tr width='100%'>
        <td width='90%' class='detail1'>{$m_value}</td>
        <td width='10%' class='detail1'><a href='groups_setup.php?id={$m_id}'><img src="images/edit.gif" border=0 alt="Edit"></a>
	<a href='groups.php?id={$m_id}&action=delete'><img src="images/delete.gif" border=0 alt="Delete"></a></td>
        </tr>
        {/foreach}
	{/if}
      </table>
  </fieldset>
{include file="footer.tpl"}
