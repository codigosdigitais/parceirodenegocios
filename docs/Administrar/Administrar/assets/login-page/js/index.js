$(document).ready(function () {

    $('#formLogin').submit(function () {
        event.preventDefault();
        realizaLogin();
    });

    var animating = false,
        submitPhase1 = 1100,
        submitPhase2 = 400,
        logoutPhase1 = 800,
        $login = $(".login"),
        $app = $(".app");

    function ripple(elem, e) {
        $(".ripple").remove();
        var elTop = elem.offset().top,
            elLeft = elem.offset().left,
            x = e.pageX - elLeft,
            y = e.pageY - elTop;
        var $ripple = $("<div class='ripple'></div>");
        $ripple.css({
            top: y,
            left: x
        });
        elem.append($ripple);
    };

    $(document).on("click", ".login__submit", function (e) {
        if (animating) return;
        animating = true;
        var that = '.login__submit';
        ripple($(that), e);
        $(that).addClass("processing");
    });

    /*  $('.login__submit').click(function() {
            realizaLogin();
      });*/
});

function realizaLogin() {
    var that = '.login__submit';

    var url = $('#formLogin').attr('action');
    var data = $('#formLogin').serialize();

    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "json",
        beforeSend: function (xhr) {

        },
        success: function (data) {
            if (data.success) {
                //$(that).addClass("success");
                setTimeout(function () {
                    $('#formSuccess').append($('#formLogin input')).submit();
                }, 300);
            }
            if (data.error) {
                $('.login__signup').html('<div class="error">' + data.mensagem) + '</div>';
                //$(that).removeClass("processing");
            }
        },
        error: function (request, error) {
            $('.login__signup').html('<div class="error">Problemas ao realizar login</div>');
            var that = '.login__submit';
            //$(that).removeClass("processing");
        }
    });
}