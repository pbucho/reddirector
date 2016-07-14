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
