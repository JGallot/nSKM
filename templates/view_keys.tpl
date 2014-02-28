{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
<table class='detail'>
    {if !isset($keys)}
      <tr><td class='title'>No key found</td><td class='detail2'></td></tr>
    {else}
	{foreach from=$keys key=idx item=key}

        <tr width='100%'><td class='{$key.style}'><img src='images/key_little.gif' border=0'>{$key.name} : {$key.value}</td></tr>
	{/foreach}
	{/if}
      </table>
  </fieldset>
{include file="footer.tpl"}

