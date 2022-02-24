document.addEventListener('DOMContentLoaded', function () {
    // loading icon
    $('.spinner-container').fadeOut()
    
    // user profile dropdown
    $('#userProfileDropdown').on('click', function() {
        let el =  $(this).next();
        if (el.hasClass('show')) {
            el.removeClass('show');
        } else {
            el.addClass('show')
        }
    })

    if ($( "#sortable" ).length > 0) {
        $( "#sortable" ).sortable({
            revert: true
        });
    }
});
function openNav() {
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