const searchbar = document.querySelector('.searchbar');

if (searchbar) {
    searchbar.addEventListener('keyup', function() {
    var items = document.querySelectorAll('.search_item');

    items.forEach(function(item) {
        item.classList.remove('invisible');
        var a = item.querySelector('a');
        var search_name = a.innerHTML;

        if(!((search_name.toLowerCase()).includes(searchbar.value.toLowerCase()))) {
            item.classList.add('invisible');
        }
    });
  });
}
