{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
<table>
   <caption>{$name} - Information</caption>
   <tr><td>OS Type : <img src='{$icon}' border='0'> {$ostype} version {$osvers}, hostgroup : <a href='hosts-view.php?id_hostgroup=$id_hostgroup'>{$groupname}</a></td></tr>
   <tr><td>Provider : {$po} , model : {$model} ( SR# : {$serialno} )</td></tr>
</table>

  <table>
  <tr>
  <th><a href='hosts_setup.php?id={$id}&id_hostgroup={$id_hostgroup}'>Click here to edit {$name} details</a></th>
  <th><a href='host-view.php?id={$id}&action=delete&id_hostgroup={$id_hostgroup}'>Click here to delete {$name}</a></th>
  </tr></table>

  <table>
  	<caption>Ssh key management</caption>
        <th><a href="ha_setup.php?id={$id}&host_name={$name}&id_hostgroup={$id_hostgroup}">Click here to manage a new unix account on {$name}</a></th>
  </tr></table>
        
  <table class='detail'>
         {foreach from=$accounts key=idx item=acc}
                        <tr>
                        <td class='detail2'><a href='host-view.php?id={$id}&id_hostgroup={$id_hostgroup}&action={$acc.expand_account}&account_id={$idx}'>
			<img src='images/{$acc.exp_gif}' border='0'></a>
			<img src='images/mister.gif' border=0>{$acc.name_account}<a href="hak_setup.php?id={$id}&host_name={$name}&id_account={$acc.id_account}&account_name={$acc.name_account}&id_hostgroup={$id_hostgroup}"> [Add a keyring | </a>
			<a href="hakk_setup.php?id={$id}&host_name={$name}&id_account={$acc.id_account}&account_name={$acc.name_account}&id_hostgroup={$id_hostgroup}">Add a key | </a><a href="decrypt_key.php?action=deploy_account&id={$id}&id_account={$acc.id_account}&id_hostgroup={$id_hostgroup}">Deploy |</a>
			<a href="view_aut_account.php?id={$id}&id_account={$acc.id_account}&id_hostgroup={$id_hostgroup}"> View Auth </a>
                        <a href='host-view.php?id={$id}&id_account={$acc.id_account}&action=deleteAccount&id_hostgroup={$id_hostgroup}'>| Delete ]</a></td>
                        </tr>
{if isset($acc.keyrings) }
			{foreach from=$acc.keyrings key=idx2 item=keyr}

			 <tr>
                <td class='detail3'><a href="host-view.php?id={$id}&id_hostgroup={$id_hostgroup}&action={$keyr.expand_action}&account_id={$idx}&keyring_id={$idx2}">
		<img src='images/{$keyr.expand_gif}' border='0'></a><img src='images/keyring_little.gif' border='0'>{$keyr.name_keyring}
                <a href='host-view.php?id={$id}&id_account={$acc.id_account}&id_keyring={$idx2}&action=deleteKeyring&id_hostgroup={$id_hostgroup}'>[ Delete ]</a></td>
                </tr>
			{if isset($keyr.keys) }
			{foreach from=$keyr.keys key=idx4 item=skey}
	                <tr>
                        <td class='{$skey.indent}'><img src='images/key_little.gif' border=0 >{$skey.name_key}
                        <a href='host-view.php?id={$id}&id_account={$acc.id_account}&id_key={$idx4}&id_hostgroup={$id_hostgroup}&action=deleteKey'>[ Delete ]</a></td>
                        </tr>

         		{/foreach}
			{/if}
			{/foreach}
{/if}
		{if isset($acc.keys) }
		{foreach from=$acc.keys key=idx3 item=key}
			<tr>
			<td class='{$key.indent}'><img src='images/key_little.gif' border=0 >{$key.name_key}
			<a href='host-view.php?id={$id}&id_account={$acc.id_account}&id_key={$idx3}&id_hostgroup={$id_hostgroup}&action=deleteKey'>[ Delete ]</a></td>
       			</tr>
			{/foreach}
		{/if}
         {/foreach}
	{if !isset($acc.keyrings) && !isset($acc.keys) }
		<tr><td class='detail3'>No keyrings or keys associated</td></tr>
	{/if}
</table>
{include file="footer.tpl"}
