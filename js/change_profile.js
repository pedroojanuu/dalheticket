username = document.querySelector(".username .content").innerHTML

function save_and_change_to_input(field, old_html) {
  function inner(){
    let new_content = field.querySelector("input").value
    let name = field.querySelector("input").getAttribute("name")
    let token = document.querySelector("p.token").innerHTML

    function print_message(message) {
      if(field.querySelector(".wrong_field") == null)
        field.innerHTML += `<p class="wrong_field">${message}</p>`;
      else
        field.querySelector(".wrong_field").innerHTML = message;
      field.querySelector(".cancel").addEventListener("click", replace_with_old(field, old_html))
      field.querySelector(".save").addEventListener("click", save_and_change_to_input(field, old_html))
    }

    if(new_content == "") {
      print_message(`You can't leave ${name} empty!`)
      return;
    } else if(name == "name" && /^[a-zA-Z1-9\s]+$/.test(new_content) == false) {
      print_message(`Name can only contain letters, numbers and spaces!`)
      return;
    } else if(name == "email" && /^[a-zA-Z1-9_\-\.@]+$/.test(new_content) == false) {
      print_message(`E-mail address invalid!`)
      return;
    }

    let request = new XMLHttpRequest()
    request.open("POST", "../actions/action_edit_profile.php", true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.send(`field=${name}&value=${new_content}&username=${username}&csrf=${token}`)

    replace_with_old(field, old_html)()
    field.querySelector(".content").innerHTML = new_content
  }
  return inner
}

function replace_with_old(field, old_html) {
  function inner(){
    field.innerHTML = old_html 
    field_to_click = field.querySelector(".change_profile_attribute")
    field_to_click.addEventListener("click", change_to_input(field_to_click))
  }
  return inner
}

function change_to_input(field){
  return () => {
    let field_to_change = document.querySelector("." + field.getAttribute("name"))
    let old_html = field_to_change.innerHTML
    let content = field_to_change.querySelector(".content").innerHTML

    let name = field.getAttribute("name")
    field_to_change.innerHTML = `<input type="text" name="${name}" value="${content}" class="change_profile_attribute">
                                 <button class="change_profile_attribute save" name="${name}">Save</button>
                                 <button class="change_profile_attribute cancel" name="${name}">Cancel</button>`
    field_to_change.querySelector(".cancel").addEventListener("click", replace_with_old(field_to_change, old_html))
    field_to_change.querySelector(".save").addEventListener("click", save_and_change_to_input(field_to_change, old_html))
  }
}

let field_all = document.querySelectorAll(".change_profile_attribute")
for(let field of field_all)
  field.addEventListener("click", change_to_input(field))
