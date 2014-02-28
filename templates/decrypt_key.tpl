{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
  <center>
  <br>
  <form action="decrypt_key.php" method="Post">

  <table class="login" align='left' width='200px'>
    <tr>
      <td class='line' colspan='2'>
        <img src='images/encrypted.gif'><br><br>
        The local SKM SSH Private key is encrypted (if not do it before proceed)<br>
        Please provide the passphrase :<br>
        <input type="password" name="psPassword"><br>
      </td>
    </tr><tr>
      <td class='line' colspan='2'><br><input type="submit" value="Continue"><br></td>
    </tr>
  </table>
  <input type="hidden" name="step" value="1">
  <input type="hidden" name="id" value="{$id}">
  <input type="hidden" name="id_account" value="{$id_account}">
  <input type="hidden" name="id_hostgroup" value="{$id_hostgroup}">
  <input type="hidden" name="id_keyring" value="{$id_keyring}">
  <input type="hidden" name="id_key" value="{$id_key}">
  <input type="hidden" name="action" value="{$action}">
  </form>
{include file="footer.tpl"}
