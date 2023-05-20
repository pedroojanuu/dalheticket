let clicker, input, canceller;

clicker = document.querySelector(".add_hashtag");
input = document.querySelector(".hashtag_box");
canceller = document.querySelector(".cancel_hashtag");

clicker.addEventListener('click', () => {
    clicker.classList.add("invisible");
    input.classList.remove("invisible");
    canceller.classList.remove("invisible");
});

canceller.addEventListener('click', () => {
    clicker.classList.remove("invisible");
    input.classList.add("invisible");
    canceller.classList.add("invisible");
});
