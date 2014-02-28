{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>

  <title>Keyring list</title>

  <fieldset><legend>Keyring List <a href="keyrings_setup.php">[create a new keyring |</a><a href="keyrings.php?action=expandall">Expand all |</a><a href="keyrings.php?action=collapseall">Collapse all ]</a></legend>
{if !isset($keyrings) }
<tr><td class='detail1'>No keyring defined</td></tr>
{else}
  <table class='detail'>


{foreach from=$acc.keyrings key=idx2 item=keyr}
{/foreach }
    </table>

</td></tr></table>

{/if}
{include file="footer.tpl"}
