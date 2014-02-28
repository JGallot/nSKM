{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}

  <fieldset><legend>Host List </legend>

  <table class='detail'>

{if !isset($hosts)}
	<tr><td class='detail1'>No host to deploy</td><td class='detail2'></td></tr>
{else}

{/if}

{include file="footer.tpl"}
