{* Smarty *}
{include file="header.tpl"}
{include file="menu.tpl"}
<td width='80%'>
  <center>
  <br>
  <form action="decrypt_key.php" method="Post">

  <table class="login" align='left' width='200px'>
    <tr>
      <td colspan='2'>
        <img src='images/encrypted.gif'><br><br>
        The local SKM SSH Private key is encrypted (if not do it before proceed)<br><br>
        Please provide the passphrase : 
        <input type="password" name="psPassword" size="25"><br>
      </td>
    </tr>
    <tr>
         <td> Clean known_hosts file ? <input type="checkbox" name="cleanKnownHosts" value="1"></td>
    </tr>
    <tr>
         <td> Create User if not exists ?<input type="checkbox" name="createUser" value="1"></td>
    </tr>

    <tr>
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
