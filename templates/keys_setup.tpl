{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<script type="text/javascript" src="js/common_functions.js" async></script>
<script type="text/javascript" src="js/keys_setup.js" async></script>
<td width='80%'>  
<form name="setup_key" action="keys_setup.php" method="post" onsubmit="return(check_myform(this));">
    <fieldset><legend>Add / Modify a key</legend>
        <label for "Desc">Description :</label><input name="description" id="Desc" size="50" type="text" maxlength="255" value="{$name}"><br>
        <label for "Key">Key Value :</label><textarea name="key" id="Key" cols="61" rows="12">{$key}</textarea>
      </fieldset>
      <center>
      <input name="step" type="hidden" value="1">
      <input name="id" type="hidden" value="{$id}">
      <input name="submit" type="submit" value="add">
      </center>
    </form>
{include file="footer.tpl"}
