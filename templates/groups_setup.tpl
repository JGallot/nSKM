{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
<center>
    <form name="setup_group" action="groups_setup.php" method="post">
    <fieldset><legend>Add / Modify a group of host</legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type">Name : </td>
        <td class="Content" width="80%">
        <input name="name" size="50" type="text" maxlength="255" value="{$name}">
        </td>
      </tr>
      </table>
      </fieldset>
      <center>
      <input name="step" type="hidden" value="1">
      <input name="id" type="hidden" value="{$id}">
      <input name="submit" type="submit" value="add">
      </center>
    </form>
    </center>
{include file="footer.tpl"}
