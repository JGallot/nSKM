{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
      
{if !isset($hosts)}
    <fieldset><legend>Error</legend>This keyring does not seem to be in use...</fieldset>
{else}
    <fieldset><legend>Deploying keyring <b>{$keyring_name}</b></legend>
{foreach from=$hosts key=idx item=host}
    {foreach from=$host.accounts key=idx2 item=account}
    <fieldset><legend>Processing account <b>{$account.name}</b> on host <b>{$host.name}</b> </legend>
        <table class='detail'><tr><td class='deployment'>{$account.result1}</td></tr></table>
        <table class='detail'><tr><td class='deployment'>{$account.result2}</td></tr></table>
    </fieldset>
    {/foreach}
{/foreach}
    </fieldset>
{/if}
{include file="footer.tpl"}