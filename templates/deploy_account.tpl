{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
{if isset($output_clean)}
<fieldset><legend>Cleaning Known_hosts for {$hostname}</legend>
<table class="detail">
  <tr>
    <td class="deployment">

      {$output_clean}

    </td>
  </tr>
</table>

</fieldset>
{/if}
    
{if isset($output1)}
<fieldset><legend>Constructing securities for {$account_name} on host {$hostname}</legend>
<table class="detail">
  <tr>
    <td class="deployment">

      {$output1}

    </td>
  </tr>
</table>

</fieldset>
{/if}
{if isset($output2)}
<fieldset><legend>Deploying securities for {$account_name} on host {$hostname}</legend>

<table class="detail">
  <tr>
    <td class="deployment">

      {$output2}

    </td>
  </tr>
</table>

</fieldset>
{/if}
<a href='host-view.php?id_hostgroup={$id_group}&id={$id}'><img src='images/arrowbright.gif'> Return to {$hostname}</a>

{include file="footer.tpl"}
