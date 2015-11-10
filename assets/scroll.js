$(function() {
    $('ul.scroll-buttons li a').click(function(event) {
        event.preventDefault();

        if (this.hash !== '') {
            $('body').animate({
                scrollTop: $(this.hash).offset().top - 50
            }, 400);
        } else {
            $('body').animate({
                scrollTop: 0
            }, 400);
        }
    });
});
