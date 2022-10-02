$(function () {

    var input = document.querySelector(".phone-input");
    var inputModal = document.querySelector(".phone-input-modal");

    window.intlTelInput(input, {
        initialCountry: "sa",
        nationalMode: false,
        autoHideDialCode: false,
        separateDialCode: true
    });

    window.intlTelInput(inputModal, {
        initialCountry: "sa",
        nationalMode: false,
        autoHideDialCode: false,
        separateDialCode: true
    });


    $('.toggle-menu').on('click', function () {
        $('.header-nav').toggleClass("show-menu");
    });


    $(document).on('click', function (e) {
        var clickHover = $(e.target);
        if (!clickHover.closest('header, .header-nav').length && $('.header-nav, body').hasClass('show-menu')) {
            $('.header-nav').removeClass('show-menu');
        }
    });

    $(".header-end .header-nav li a").click(function (e) {
        // e.preventDefault();
        $("html, body").animate({
            scrollTop: $('#' + $(this).data("scroll")).offset().top - 120
        }, 0);
    });


    $(window).on("scroll", function () {
        var cur_pos = $(this).scrollTop();
        $("body .block-sec").each(function () {
            var top = $(this).offset().top - 150
            if (cur_pos >= top) {
                $('.header .header-nav li > a[data-scroll="' + $(this).attr('id') + '"]').parent().addClass("active").siblings("li").removeClass("active");
            }
    
            if (window.matchMedia('(max-width: 991px)').matches) {
                if (cur_pos >= top - 100) {
                    $('.header .header-nav li > a[data-scroll="' + $(this).attr('id') + '"]').parent().addClass("active").siblings("li").removeClass("active");
                    $('.header-nav').removeClass('show-menu');
                }
            }
        });

    });
    
})
