function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}

function reload_messages() {
  let messages = document.querySelector(".message_list");
  var request2 = new XMLHttpRequest()
  request2.open("GET", "../utils/get_ticket_messages.php" + document.location.search, true)
  request2.responseType = "json"
  request2.send()
  request2.addEventListener('readystatechange', (event) => {
    if(request2.readyState === 4 && request2.status === 200) {
      let last_message = request2.response.length - 1
        var right_or_left = ""
        if(request2.response[last_message]["isMine"])
          right_or_left = "right"
        else
          right_or_left = "left"

        messages.innerHTML += `<div class='ticket_message ` + right_or_left + `'>
                                <div class="ticket_message_text"><p>` + request2.response[last_message]["message"] + `</p></div>
                                <div class="ticket_message_date"></div>
                              </div>`
      }
  })
}

function handleEvent(event) {
  event.preventDefault()

  message_text = document.querySelector(".ticket_messages input[type='text']").value
  if(message_text == "") return
  document.querySelector(".ticket_messages input[type='text']").value = ""
  is_from_client = document.querySelector(".ticket_messages input[name='isFromClient']").value
  ticket_id = document.location.search.substring(4)

  var request = new XMLHttpRequest()
  request.open("POST", "../actions/action_send_message.php", true)
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
  request.send(encodeForAjax({ticketId: ticket_id, isFromClient: is_from_client, message: message_text}))

  reload_messages()
}
const button = document.querySelector("button.message_button")
button.addEventListener('click', handleEvent)
