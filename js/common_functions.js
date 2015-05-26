function noSpecialChars(field) {
  if(!/^[a-zA-Z0-9\-_\.]+$/.test(field.value)) {
    alert("Special Characters are not allowed in field " + field.name + "!");
    field.focus();
    return false;
  }
  return true;
}

function isEmpty(field) {
  if(field.value=="") {
    alert("Field " + field.name + " has no data !");
    field.focus();
    return false;
  }
  return true;
}

function get_ajax_infos_form(str,fieldToUpdate,page) {
    if (str == "") {
        document.getElementById(fieldToUpdate).value = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(fieldToUpdate).value = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET",page+str,false);
        xmlhttp.send();
    }
}

function get_ajax_infos_html(str,fieldToUpdate,page) {
    if (str == "") {
        document.getElementById(fieldToUpdate).innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(fieldToUpdate).innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET",page+str,false);
        xmlhttp.send();
    }
}