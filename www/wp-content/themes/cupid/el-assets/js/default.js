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
        $(window).scroll(function() {
            $('.fade-effect, .fade-effect-rotate').each(function () {
                var bottom_of_object = $(this).position().top + $(this).outerHeight() / 2;
                var bottom_of_window = $(window).scrollTop() + $(window).height();

                if($(this).hasClass("el-collection-rotate")) {
                    $(this).removeClass("el-section-collection-state-one");
                    $(this).addClass("el-section-collection-state-two");
                    $(this).children().css('left', $(this).attr("data-left-transition"));
                } else {
                    if (bottom_of_window > bottom_of_object) {
                        $(this).addClass('fade-in-fast');
                    } else {
                        $(this).removeClass('fade-in-fast');
                    }
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
            var $form = $(this);
            var $button = $form.find("button[type='submit']");
            $button.attr("disabled", true);
            $button.attr("data-text-original", $button.text());
            $button.html("Enviando...");

            $.ajax({
                url: $(this).attr("action"),
                data: $(this).serialize(),
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    var $popupMessage = $("#popup-contact-message");

                    $button.html($button.attr("data-text-original"));
                    $popupMessage.find(".el-modal-title").html(response.title);
                    $popupMessage.find(".el-modal-message").html(response.msg);
                    $popupMessage.fadeIn();
                    $button.attr("disabled", false);

                    if("1" == response.status) {
                        $("#popup-contact").hide();
                        $form.find("input, textarea").val("");
                    }
                },
                error: function() {
                    $button.html($button.attr("data-text-original"));
                    $button.attr("disabled", false);
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

        if($(".owl-carousel-main").length) {
            $(".owl-carousel-main").owlCarousel({items: 1, singleItem: true, autoPlay: true, autoPlay: 5000});
            $(".owl-carousel-main").addClass("fade-in");
            function resize() {
                var _this = $(".el-banner-container:visible");
                var offset = _this.offset();
                if(offset) {
                    $(".el-banner-container > div > div").attr("style", "min-height: " + ($(window).height() - offset.top) + "px");
                    $(".el-banner-container .el-content > div > div").css("padding-top", (_this.height() - $(".el-banner-container:visible .el-content > div > div").height()) / 2);
                }
            }

            $(window).resize(resize);
            resize();
        }

        $("#owl-carousel-devices").owlCarousel({items: 1, singleItem: true, autoPlay: true, autoPlay: 5000});

        var firstFeatures = true;
        function resizeFeatures() {
            if($(window).height() > 900) {
                if(firstFeatures) {
                    firstFeatures = false;
                    $("#owl-carousel-features").owlCarousel({items: 1, singleItem: true, autoPlay: 10000});
                }
                $("#owl-carousel-features img").height($(window).height() - 500);
            } else {
                $("#owl-carousel-features img").removeAttr("height");
            }

            var windowWidth = $(window).width();
            $(".el-collection-rotate").each(function () {
                var width = $(this).find("img").attr("width");
                var left = - width + windowWidth;
                $(this).attr("data-left-transition", left);
                if($(this).hasClass("el-section-collection-state-two")) {
                    var $el = $(this).find(".el-section-collection-content");
                    $el.css("left", left);
                }
            });
        }
        $(window).resize(resizeFeatures);
        resizeFeatures();

        // END CAROUSEL COLLECTION
    });
})(jQuery);