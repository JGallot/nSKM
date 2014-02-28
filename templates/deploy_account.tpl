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

<fieldset><legend>Deploying securities for {$account_name} on host {$hostname}</legend>

<table class="detail">
  <tr>
    <td class="deployment">

      {$output2}

    </td>
  </tr>
</table>

</fieldset>

<a href='host-view.php?id_hostgroup={$id_group}&id={$id}'><img src='images/arrowbright.gif'> Return to {$hostname}</a>

{include file="footer.tpl"}
