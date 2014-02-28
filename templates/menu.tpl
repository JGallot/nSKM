{* Smarty *}
<td width='20%'>
      <fieldset><legend>Access Management</legend>
        <a href='keys.php'>SSH Keys</a><br>
        <a href='keyrings.php'>Keyrings</a><br>
        <a href='keyrings.php'><img src='images/arrowbright.gif'> Management</a><br>
        <a href='deploy_keyring.php'><img src='images/arrowbright.gif'> Re-Deploy</a><br>
        <a href='accounts.php'>Accounts</a><br>
      </fieldset>
      <fieldset><legend>Hosts Management</legend>
        <a href='hosts_setup.php'>Add new host</a><br>
        <a href='groups.php'>Add new group</a><br>
      </fieldset>
      <fieldset><legend>Host Groups</legend>
        <a href='show_all_hosts.php'>All Hosts</a><br>
         {foreach from=$menu_hostgrps key=m_id item=m_value}
          <a href="hosts-view.php?id_hostgroup={$m_id}"><img src='images/arrowbright.gif'> {$m_value}</a><br>
         {/foreach}
      </fieldset>
      <fieldset><legend>Reports</legend>
        <a href='view_keys.php'>Key String value list</a><br>
	{if isset($SKM_GLPI)}
        <a href='serial_search.php'>SerialNo Search</a><br>
        <a href='search_model.php'>Model # Search</a><br>
        <a href='search_contract.php'>Maint.Contract Search</a><br>
	{/if}
        <a href='search_key_securities.php'>Search Key Securities</a><br>
        <a href='search_keyring_securities.php'>Search Keyring Securities</a><br>
      </fieldset>
</td>
