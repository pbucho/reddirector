function getToken() {
  var allCookies = document.cookie;
  var splitten = allCookies.split(";");
  if(splitten.length < 1){
    return null;
  }
  for(var i = 0; i < splitten.length; i++){
    var thisCookie = splitten[i].split("=");
    if(thisCookie.length < 1){
      continue;
    }
    if(thisCookie[0] == "token"){
      return thisCookie[1];
    }
  }
  return null;
}
function setEditFields(short_url, long_url) {
	$("#ed_short_url").val(short_url);
	$("#ed_long_url").val(long_url);
	$("#ed_short_url_disabled").val(short_url);
}
function setConfirmFields(short_url) {
	$("#conf_short_url").val(short_url);
	$("#conf_show_url").html(short_url);
}
