<?php
require_once 'inc/classDB.php';
require_once 'inc/sesion.php';
?>

<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>NosTale DrëaM</title>
        <link rel="icon" type="image/png" href="img/favicon.ico" />
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/login.css">
        <link rel='stylesheet' id='thr_font_0-css'  href='http://fonts.googleapis.com/css?family=Roboto%3A400%2C300&#038;subset=latin&#038;ver=1.4.0' type='text/css' media='screen' />
        <link rel='stylesheet' id='thr_font_1-css'  href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow%3A400&#038;subset=latin&#038;ver=1.4.0' type='text/css' media='screen' />
        <link rel='stylesheet' id='thr_font_2-css'  href='http://fonts.googleapis.com/css?family=Roboto+Condensed%3A400&#038;subset=latin&#038;ver=1.4.0' type='text/css' media='screen' />

        <script type="text/javascript" src="js/jquery-1.12.3.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <script language="javascript">
            $(document).ready(function () {
                $("#username").focus();
            });
        </script>

    </head>
    <body>
        <div class="row">
            <div class="container-fluid">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login">
                        <form method="post" action="login_check" id="login_form" class="round">
                            <div class="form-group">
                                <input type="text" placeholder="usuario" name="username" id="username" class="bigInput" value="<?php
                                if (isset($_COOKIE['member_login'])) {
                                    echo $_COOKIE["member_login"];
                                }
                                ?>" />
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="contraseña" name="password" id="password" class="bigInput" value="<?php
                                if (isset($_COOKIE['member_password'])) {
                                    echo $_COOKIE["member_password"];
                                }
                                ?>" />
                            </div>
                            <!--                            <div class="form-group">
                                                            <input type="checkbox" value="Recordarme">Recordarme</input>
                                                        </div>-->
                            <div class="form-group">
                                <button name="Submit" type="submit" id="submit" value="" class="btn">
                                    <span id="submit_acceder">Acceder</span>
                                    <i id="submit_accediendo" class='fa fa-spinner fa-pulse' style="display: none"></i>
                                </button>
                            </div>
                            <div id="msgbox">
                                <span id="acceso_msg"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>