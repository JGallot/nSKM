{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>

{if !isset($list)}
<fieldset><legend>Searching key "{$key_name}" in accounts</legend>This key doesn't seem to be used...</fieldset>
{else}
	<fieldset><legend>Searching securities for key {$key_name}</legend>
	<table class='detail'>
	{foreach from=$list key=idx item=mykeys}
		{foreach from=$mykeys key=idx2 item=myitem}

			<tr><td class='title'><img src='images/server.gif' border='0'>{$myitem.hostname}</td></tr>
			{foreach from=$myitem.accounts key=idx3 item=accounts}
				{foreach from=$accounts key=idx4 item=account}
				<tr><td class='detail1'><img src='images/mister.gif' border='0'>{$account}</td></tr>
				{/foreach}
			{/foreach}
		{/foreach}
	{/foreach}
	</table></fieldset>
{/if}
{if isset($list2)}
	{foreach from=$list2 key=idx item=mykeys}
	<fieldset><legend>The key "{$key_name}" was found in keyring {$mykeys.keyring_name}</legend>
        <table class='detail'>
		{foreach from=$mykeys.hosts key=idx2 item=myitem}
                        <tr><td class='title'><img src='images/server.gif' border='0'>{$myitem.hostname}</td></tr>
			{foreach from=$myitem.accounts key=idx3 item=accounts}
				{foreach from=$accounts key=idx4 item=account}
                        	<tr><td class='detail1'><img src='images/mister.gif' border=0>{$account}</td></tr>
				{/foreach}
			{/foreach}
		{/foreach}
        </table></fieldset>
	{/foreach}
{else}
<fieldset><legend>Searching key "{$key_name}" in keyrings</legend>This key doesn't seem to be used in a keyring...</fieldset>

{/if}
<center><a href='search_key_securities.php'>Click here for a new search</a></center>
{include file="footer.tpl"}
