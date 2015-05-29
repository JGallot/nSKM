{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<script type="text/javascript" src="js/common_functions.js"></script>
<script type="text/javascript" src="js/groups_setup.js" ></script>
<td width='80%'>
<center>
    <form name="setup_group" action="groups_setup.php" method="post" onsubmit="return check_myform(this);">
    <fieldset><legend>Add / Modify a group of host</legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type">Name : </td>
        <td class="Content" width="80%">
        <input name="name" size="50" type="text" maxlength="255" value="{$name}" onchange="update_infos(this.value);">
        <label id="nameHint"></label>
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
