function check_myform(myform)
{
   var ok = true;
   ok = ok && !myform.dontSave.value;
   ok = ok && isEmpty(myform.name);
   ok = ok && noSpecialChars(myform.name);
 
   return ok;
}

function update_infos(myhostname)
{
    get_ajax_infos_html(myhostname,'nameHint','check_dup_hostgroup.php?q=');
}