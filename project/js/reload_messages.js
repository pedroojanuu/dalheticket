let messages = document.querySelector(".message_list");

function reload_messages() {
  var request = new XMLHttpRequest()
  request.open("GET", "../utils/get_ticket_messages.php" + document.location.search, true)
  request.responseType = "json"
  request.send()
  request.addEventListener('readystatechange', (event) => {
    if(request.readyState === 4 && request.status === 200) {
      messages.innerHTML = "";
      for(var i = 0; i < request.response.length; i++){
        if(request.response[i]["message"] != null){
          var right_or_left = "";
          if(request.response[i]["isMine"])
            right_or_left = "right";
          else
            right_or_left = "left";

          messages.innerHTML += `<div class='ticket_message ` + right_or_left + `'>
                                  <div class="ticket_message_text"><p>` + request.response[i]["message"] + `</p></div>
                                  <div class="date_not_hidden">` + request.response[i]["datetime"] + `</div>
                                </div>`;
        } else {
          messages.innerHTML += `<div class='ticket_message center'>
                                  <div class="ticket_message_text"><p>` + request.response[i]["action"] + `</p></div>
                                  <div class="date_not_hidden">` + request.response[i]["datetime"] + `</div>
                                </div>`;
        }
      }
    }
  })
}

async function async_wraper() {
  while(true){
    reload_messages();
    
    await new Promise(r => setTimeout(r, 2000));
  }
}

async_wraper();
