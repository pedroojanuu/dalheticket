let input = document.querySelector("#hashtag_box");

let container = document.querySelector(".tag_container");

input.onkeypress = function (event) {
    if (input.value != '' && event.which == 13) {
        event.preventDefault();
        var text = document.createTextNode(input.value);
        var p = document.createElement('p');
        container.appendChild(p);
        p.appendChild(text);
        p.classList.add('tag');

        input.value = '';

        let tags = document.querySelectorAll(".tag");

        for (let i = 0; i < tags.length; i++) {
            tags[i].addEventListener('click', () => {
                container.removeChild(tags[i]);
            });
        }
    }
}
