function check_myform(myform)
{
   var ok = true;
   ok = ok && isEmpty(myform.name);
   ok = ok && noSpecialChars(myform.name);
   ok = ok && (!myform.dontSave);
   
   return ok;
}