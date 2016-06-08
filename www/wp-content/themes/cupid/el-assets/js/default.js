(function($){
    $(document).ready(function () {
        $("#main-banner").addClass("fade-in");
    });

    $(window).scroll(function() {
        $('.fade-effect').each(function () {
            var bottom_of_object = $(this).position().top + $(this).outerHeight() / 2;
            var bottom_of_window = $(window).scrollTop() + $(window).height();

            if (bottom_of_window > bottom_of_object) {
                $(this).addClass('fade-in-fast');
            } else {
                $(this).removeClass('fade-in-fast');
            }
        });
    }).scroll();
})(jQuery);