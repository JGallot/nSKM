{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
<fieldset><legend>Keyring List <a href="keyrings_setup.php">[create a new keyring |</a><a href="keyrings.php?action=expandall">Expand all |</a><a href="keyrings.php?action=collapseall">Collapse all ]</a></legend>
<table class='detail'>
<tr>
{foreach from=$keyrings key=idx item=keyr}
<td class='title'><a href="keyrings.php?id={$idx}&action={$keyr.expand}"><img src='images/{$keyr.expand}.gif' border=0"></a><img src='images/keyring_little.gif'>{$keyr.name} <a href="kk_setup.php?id={$idx}&keyring_name={$keyr.name}">[ add a key</a>

<a href='keyrings_setup.php?id={$idx}'>| edit name</a><a href='keyrings.php?id={$idx}&action=delete'>| Delete ]</a>
<tr>
{if !isset($keyr.keys)&&$keyr.expand=='collapse'}
<tr><td class='detail2'>No keys associated</td></tr>
{/if}
{if isset($keyr.keys)&&$keyr.expand=='collapse'}
{foreach from=$keyr.keys key=idx2 item=fkey}
<tr>
<td class='detail2'><img src='images/key_little.gif' border=0 >{$fkey}
<a href='keyrings.php?id={$idx}&id_key={$idx2}&action=deleteJT'>[ Delete ]</a></td>
</tr>
{/foreach}
{/if}
{/foreach}
{include file="footer.tpl"}
