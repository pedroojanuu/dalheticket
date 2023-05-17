const tickets = document.querySelectorAll("li.ticket");
const radio_buttons = document.querySelectorAll("form.radio_form input");
var radio_status = 'All';
const date_input = document.querySelector("form.date_form input#date");
const date_filter_check = document.querySelector("form.date_form input#filter");
var filter_by_date = false;

date_input.valueAsDate = new Date();

function filter (status, date) {
    tickets.forEach(function (ticket) {
        ticket.classList.remove('invisible');
        if (status == 'All') return;
        const ticket_status = ticket.querySelector("a span#status").innerHTML;

        if (ticket_status != status) ticket.classList.add('invisible');
    });
    
    if (date == '') return;

    tickets.forEach(function (ticket) {
        const ticket_date = ticket.querySelector("a span#date").innerHTML;

        if (ticket_date != date) ticket.classList.add('invisible');
    });
}

radio_buttons.forEach(function (button) {
    button.addEventListener("change", function() {
        if (this.checked) {
            radio_status = this.value;
            if (filter_by_date) filter(this.value, date_input.value);
            else filter(this.value, '');
        }
    });
});

date_filter_check.addEventListener("change", function() {
    if (this.checked) {
        filter_by_date = true;
        filter(radio_status, date_input.value);
    }
    else {
        filter_by_date = false;
        filter(radio_status, '');
    }
});
