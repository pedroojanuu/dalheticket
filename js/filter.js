const tickets = document.querySelectorAll("li.ticket");
const radio_buttons = document.querySelectorAll("form.radio_form input");

function filterStatus (status) {
    tickets.forEach(function (ticket) {
        ticket.classList.remove('invisible');
        if (status == 'All') return;
        const ticket_status = ticket.querySelector("a span#status").innerHTML;

        if (ticket_status != status) ticket.classList.add('invisible');
    });
}

radio_buttons.forEach(function (button) {
    button.addEventListener("change", function() {
        if (this.checked) filterStatus(this.value);
    })
});
