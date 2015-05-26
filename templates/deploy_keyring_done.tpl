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
        {if isset($account.result_clean)} <table class='detail'><tr><td class='deployment'>{$account.result_clean}</td></tr></table> {/if}
        <table class='detail'><tr><td class='deployment'>{$account.result1}</td></tr></table>
        {if isset($account.result2)} <table class='detail'><tr><td class='deployment'>{$account.result2}</td></tr></table> {/if}
    </fieldset>
    {/foreach}
{/foreach}
    </fieldset>
{/if}
{include file="footer.tpl"}