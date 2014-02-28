{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
<table class='detail'>
   <fieldset><legend>Accounts <a href="accounts_setup.php">[create a new account]<img src='images/add.gif' border='0'></a></legend>
{if !isset($accounts)}
	<tr><td class='detail1'>No Account found</td><td class='detail2'></td></tr>
{else}
{foreach from=$accounts key=idx item=mkey}
        <tr>
        <td class='detail1'><img src='images/mister.gif'>{$mkey}</td>
        <td class='detail1'>
        <a href='accounts_setup.php?id={$idx}'><img src="images/edit.gif" border=0 alt="Edit"></a> <a href='accounts.php?id={$idx}&action=delete'><img src="images/delete.gif" border=0 alt="Delete"></a>
        </td>
        </tr>
{/foreach}
{/if}
	</td>
   <table class='detail'>
  </fieldset>
{include file="footer.tpl"}
