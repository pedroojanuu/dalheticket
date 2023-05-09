console.log("Hello World!");

async function async_wraper() {
  var request = new XMLHttpRequest();
  request.open("GET", "../utils/get_ticket_messages.php" + document.location.search, true);
  request.responseType = "json";
  request.send();
  var messages = document.querySelector(".message_list");

  while(true){
    console.log(request.response);
    if(request.readyState === 4 && request.status === 200) {
      messages.innerHTML = "";
      for(var i = 0; i < request.response.length; i++){
        var right_or_left = "";
        if(request.response[i]["isMine"])
          right_or_left = "right";
        else
          right_or_left = "left";

        messages.innerHTML += `<div class='ticket_message ` + right_or_left + `'>
                                <div class="ticket_message_text"><p>` + request.response[i]["message"] + `</p></div>
                                <div class="ticket_message_date"></div>
                              </div>`;
      }
      request = new XMLHttpRequest();
      request.open("GET", "../utils/get_ticket_messages.php" + document.location.search, true);
      request.responseType = "json";
      request.send();
    }
    await new Promise(r => setTimeout(r, 2000));
  }
}

async_wraper();
