document.addEventListener('DOMContentLoaded', function () {
    // loading icon
    $('.spinner-container').fadeOut()
    
    // user profile dropdown
    $('#userProfileDropdown, #navbarDropdownMessages').on('click', function() {
        if (!$(this).next().hasClass('show')) {        
            $('.dropdown-menu').removeClass('show');
            $(this).next().addClass('show')
        } else {
            $('.dropdown-menu').removeClass('show');
        }
    })

    if ($( "#sortable" ).length > 0) {
        $( "#sortable" ).sortable({
            revert: true
        });
    }

    $('.shipping-request-filter').on('click', function() {
        let el = $(this).next();
        
        if (el.hasClass('show')) {
            el.removeClass('show');
        } else {
            el.addClass('show')
        }
    });

    $('body').on('click', function(el) {
        if ($(el.target).closest('.navbar-item').length == 0) {
            $('.dropdown-menu').removeClass('show');
        }
    });
});
function openNav() {
    $('.dropdown-menu').removeClass('show');
    document.getElementById("sidenav").style.width = "300px";
    window.localStorage.aside = true;
}

function closeNav() {
    document.getElementById("sidenav").style.width = "0";
    window.localStorage.aside = false;
}
if (window.localStorage.aside == 'true') {
    openNav();
}