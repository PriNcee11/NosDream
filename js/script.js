$(document).ready(function () {
    $(".item_mini").click(function () {
        var id = $(this).attr("id");
        var idval = id.substr(1, id.length);
        $('html, body').stop().animate({
            scrollTop: $("#b" + idval).offset().top - 100
        }, 500);
        $("#valor" + idval).focus();
    });
    $(".top_fila_name").click(function () {
        var id = $(this).attr("id");
        var idval = id.substr(1, id.length);
        $('html, body').stop().animate({
            scrollTop: $("#b" + idval).offset().top - 100
        }, 500);
        $("#valor" + idval).focus();
    });

    // Ajax submit item price
    $(".formu").on('submit', function (e) {
        e.preventDefault();

        var id_form = $(this).attr("id");
        var id_form_s = id_form.split('_');

        if ($("#submit_" + id_form_s[1]).hasClass("disabled")) {

        } else {
            $("#enviar-text-" + id_form_s[1]).css("display", "none");
            $("#enviando-text-" + id_form_s[1]).css("display", "block");

            var valor = $("#valor" + id_form_s[1]).val();
            var params = {id: id_form_s[1], valor: valor};
            $.ajax({
                data: params,
                url: 'insertar_item.php',
                type: 'post',
                dataType: 'html',
                beforeSend: function () {

                }
            }).done(function () {
                console.log("OK");
                $("#enviando-text-" + id_form_s[1]).css("display", "none");
                var boton = $("#enviando-text-" + id_form_s[1]).closest("button");
                $("#enviado-text-" + id_form_s[1]).css("display", "block");
                boton.addClass("btn-danger");
                boton.addClass("disabled");
                boton.removeClass("btn-primary");
            })
        }
    });

    // Ajax submit nd value
    $("#form_nd").on('submit', function (e) {
        e.preventDefault();

        var valor = $("#input-nd").val();

        $("#insert_nd_text").css("display", "none");
        $("#inserting_nd_text").css("display", "block");
        var params = {valor: valor};
        $.ajax({
            data: params,
            url: 'insertar_nd.php',
            type: 'post',
            dataType: 'html',
            beforeSend: function () {

            }
        }).done(function () {
            console.log("OK");
            $("#insert_nd_text").css("display", "block");
            $("#inserting_nd_text").css("display", "none");
        })
    });

    $(".delete_precio").on('click', function (e) {
        var id = $(this).attr("data-id");
        var fecha = $(this).attr("data-fecha");
        var params = {id: id, fecha: fecha};
        $.ajax({
            data: params,
            url: 'borrar_item.php',
            type: 'post',
            dataType: 'html',
            beforeSend: function () {

            }
        }).done(function () {
            console.log("deleted");
            $("#del-" + id).closest('tr').fadeOut(500);
//            $("#del-" + id).closest('tr').remove();
        })
    });

    $("#login_form").on('submit', function (e) {
        e.preventDefault();

        var user = $("#username").val();
        var pass = $("#password").val();
        var params = {user: user, pass: pass};
        $.ajax({
            data: params,
            url: 'comprobar_user.php',
            type: 'post',
            dataType: 'html',
            beforeSend: function () {
                $("#submit_acceder").hide();
                $("#submit_accediendo").show();
            }
        }).done(function (returned) {
            $("#submit_acceder").show();
            $("#submit_accediendo").hide();

            if (returned) {
                console.log("login accepted");
                window.location.replace("/index.php");
            } else {
                $("#acceso_msg").text("Usuario/Contraseña incorrectos");
            }
        })
    });

    $("#logout").on('click', function () {
        $.ajax({
            url: 'logout.php'
        }).done(function () {
            window.location.replace("/login.php");
        })
    });


});

