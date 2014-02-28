{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
<fieldset><legend>Constructing securities for {$account_name} on host {$hostname}</legend>
<table class="detail">
  <tr>
    <td class="deployment">

	{$output1}

    </td>
  </tr>
</table>
</fieldset>

<fieldset><legend>File authorized_keys2 for {$account_name} on host {$hostname}</legend>
<table class="detail">
  <tr>
    <td class="deployment">

	{$output2}

    </td>
  </tr>
</table>
<center><a href='host-view.php?id={$id}&id_hostgroup={$id_hostgroup}'>Click here to return to {$hostname} details</a></center>
</fieldset>

{include file="footer.tpl"}

