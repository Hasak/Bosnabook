// ===== Scroll to Top ==== 
function skrolnabilna () {
    if ($(window).scrollTop() >= 50) { // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(200); // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200); // Else fade out the arrow
    }
}
$(window).scroll(skrolnabilna);
$(document).ready(function () {
    skrolnabilna();
});
$('#return-to-top').click(function () {
    // When arrow is clicked

    $('body, html').animate({
        scrollTop: 0 // Scroll to top of body
    }, 500);
});
