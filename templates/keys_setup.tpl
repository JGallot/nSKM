{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
    
<form name="setup_key" action="keys_setup.php" method="post">
    <fieldset><legend>Add / Modify a key</legend>
        <label for "Desc">Description :</label><input name="name" id="Desc" size="50" type="text" maxlength="255" value="{$name}"><br>
        <label for "Key">Key Value :</label><textarea name="key" id="Key" cols="61" rows="12">{$key}</textarea>
      </fieldset>
      <center>
      <input name="step" type="hidden" value="1">
      <input name="id" type="hidden" value="{$id}">
      <input name="submit" type="submit" value="add">
      </center>
    </form>
{include file="footer.tpl"}
