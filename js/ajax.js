console.log("Hello World!");

var request = new XMLHttpRequest();

request.open("GET", "get_ticket_messages.php?" + document.location.search, true);

request.responseType = "json";

request.send();

request.addEventListener("readystatechange", function(){
  if(request.readyState === 4 && request.status === 200) {
    var messages = document.querySelector(".ticket_messages");
    messages.innerHTML = document.location.search;

    for(var i = 0; i < request.response.length; i++){
      messages.innerHTML += "<p>" + request.response[i] + "</p>";
    }
  }
});
