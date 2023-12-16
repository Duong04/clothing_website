const headerMain2 = document.querySelector('.header-main');
window.addEventListener('scroll', function () {
    if (window.scrollY > 400) {
        headerMain2.classList.add('header-fixed');
        headerMain2.style.top = '0';
    } else if (window.scrollY < 200) {
        headerMain2.classList.remove('header-fixed');
        headerMain2.style.top = '-100px';
    }
});

    var menuItems = document.querySelectorAll('.defaut');

    menuItems.forEach(function (menuItem) {
        menuItem.addEventListener('click', function (event) {
            event.preventDefault();
            var submenu = this.nextElementSibling;

            if (submenu) {
                submenu.classList.toggle('visible');
            }
        });
    });

// ----------------------------------
const searchBox = document.getElementById('search');

searchBox.setAttribute('autocomplete', 'off');

const searchBox_2 = document.getElementById('search-2');

searchBox_2.setAttribute('autocomplete', 'off');

// ---------------------------------------
$(document).ready(function() {
    
    $('#search').on('input', function() {
        var searchTerm = $(this).val();
        $.ajax({
            type: 'POST',
            url: '../controller/searchResult.php',  
            data: { search: searchTerm },
            success: function(response) {
                $('#search-results').html(response);
            }
        });
    });

    $('#search').on('blur', function() {
        setTimeout(function() {
            if (!$('#search-results').is(':focus')) {
                $('#search-results').hide();
            }
        }, 200); 
    });


    $('#search-result').on('click', function() {
        $('#search-results').show();
    });

    $('#search').on('focus', function() {
        $('#search-results').show();
    });
});

$(document).ready(function() {

    $('#search-2').on('input', function() {
        var searchTerm = $(this).val();
        $.ajax({
            type: 'POST',
            url: '../controller/searchResult.php',  
            data: { search: searchTerm },
            success: function(response) {
                $('#search-results-2').html(response);
            }
        });
    });

    $('#search-2').on('blur', function() {
        setTimeout(function() {
            if (!$('#search-results').is(':focus')) {
                $('#search-results-2').hide();
            }
        }, 200); 
    });


    $('#search-result').on('click', function() {
        $('#search-results-2').show();
    });

    $('#search-2').on('focus', function() {
        $('#search-results-2').show();
    });
});
