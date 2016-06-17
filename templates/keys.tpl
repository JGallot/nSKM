{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
<fieldset><legend>Keys <a href="keys_setup.php">[add a key]<img src='images/add.gif' border='0'></a></legend>

<table class='detail'>
{if !isset($keys)}
      <tr><td class='detail1'>No key found</td></tr>\n");
{else} 
	{foreach from=$keys key=idx item=key}
	<tr wdth='100%'>
	<td width='90%' class='detail1'><img src='images/key_little.gif' border=0'>{$key}
	[ <a href='keys_setup.php?id={$idx}'>Edit</a>
        {if ($idx > 1)}
          | <a href='keys.php?id={$idx}&action=delete'>Delete</a> ]</td>
        {else}
          ]
	{/if}
	</tr>
	{/foreach}
{/if}
</table></fieldset>
{include file="footer.tpl"}
