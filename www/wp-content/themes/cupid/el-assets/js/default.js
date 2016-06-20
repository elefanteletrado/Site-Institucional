function telReplace(v) {
    v = v.replace(/\D/g,"");
    if (v.length <= 10) {
        v = v.replace(/(\d{2})(\d)/,"$1 $2")
            .replace(/(\d{4})(\d{1,4})/,"$1-$2")
            .substr(0, 12);
    } else {
        v = v.replace(/(\d{2})(\d)/,"$1 $2")
            .replace(/(\d{5})(\d{1,4})/,"$1-$2")
            .substr(0, 13);
    }
    return v;
}
function checkTel(strTel) {
    var length = strTel.replace(/\D/g, "").length;
    return 10 == length || 11 == length;
}
function onInputTel(input) {
    input.value = telReplace(input.value);
    var value = input.value.replace(/\D/g, '');
    if(!value) {
        input.setCustomValidity("");
    } else if(!checkTel(value)) {
        input.setCustomValidity("Digite um telefone válido.");
    } else {
        input.setCustomValidity("");
    }
}

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

    var form = {
        element: $("#form-ext-contact"),
        processing: false,
        options: {
            dataType: 'json',
            beforeSubmit: function() {
                form.processing = true;
                return true;
            },
            success: function(data) {
                form.processing = false;
                alert(data.msg);
                if(data.status == "1") {
                    window.location.href = form.element.attr("data-redirect-url");
                }
            },
            error: function() {
                form.processing = false;
                $.LoadingOverlay("hide");

                alert("Ocorreu um erro inesperado. Por favor, contate o administrador do sistema.");
            }
        }
    };

    form.element.submit(function () {
        form.element.ajaxSubmit(form.options);

        return false;
    });

    $(".form-contact").submit(function () {
        var $button = $(this).find("button[type='submit']");
        $button.attr("disabled", true);
        $button.attr("data-text-original", $button.text());
        $button.html("Enviando...");

        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            type: "POST",
            dataType: 'json',
            success: function(response) {
                $button.html($button.attr("data-text-original"));
                $("#popup-contact-message").fadeIn();
                $("#popup-contact").hide();
            },
            error: function() {
                $button.html($button.attr("data-text-original"));
                alert("Ocorreu um erro inesperado. Por favor, contate o administrador do sistema.");
            }
        });

        return false;
    });

    $(".popup-contact-message-ok").click(function () {
        $("#popup-contact-message").fadeOut();
    });
    $(".popup-contact-close").click(function () {
        $("#popup-contact").fadeOut();
    });
    $("#popup-contact-open").click(function () {
        $("#popup-contact").fadeIn();

        return false;
    });

    if($(window).width() > 900) {
        $("#main-banner > div > div").attr("style", "min-height: " + ($(window).height() - $("#main-banner").offset().top) + "px");
    }

    $("#owl-example").owlCarousel();

    // BEGIN CAROUSEL COLLECTION
    var theCircle = document.getElementById("el-collection-rotate");

    function setup() {
        theCircle.addEventListener("transitionend", loopTransition, false);
        theCircle.addEventListener("webkitTransitionEnd", loopTransition, false);
        theCircle.addEventListener("mozTransitionEnd", loopTransition, false);
        theCircle.addEventListener("msTransitionEnd", loopTransition, false);
        theCircle.addEventListener("oTransitionEnd", loopTransition, false);
    }
    setup();

    setTimeout(function() {
        setInitialClass();
    }, 500);

    function setInitialClass(e) {
        theCircle.className = "el-section-collection-state-two";
    }

    function loopTransition(e) {
        if (e.propertyName == "left") {
            if (theCircle.className == "el-section-collection-state-two") {
                theCircle.className = "el-section-collection-state-one";
                setTimeout(function() {
                    setInitialClass();
                }, 100);
            } else {
                theCircle.className = "el-section-collection-state-two";
            }
        }
    }
    // END CAROUSEL COLLECTION
})(jQuery);