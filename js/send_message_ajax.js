function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}

function handleEvent() {
  message_text = document.querySelector(".ticket_messages input[type='text']").value;
  is_from_client = document.querySelector(".ticket_messages input[name='isFromClient']").value;
  ticket_id = document.location.search.substring(4);

  var request = new XMLHttpRequest();
  request.open("post", "../actions/action_send_message.php", true);
  let j = encodeForAjax({ticketId: ticket_id, isFromClient: is_from_client, message: message_text});
  console.log(j);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(j);
  console.log("sent");
}
const button = document.querySelector("button.message_button")
button.addEventListener('click', handleEvent)
