<?php
require_once 'inc/classDB.php';
require_once 'inc/clases/item_class.php';
require_once 'inc/sesion.php';

//if (empty($_SESSION['username'])) {
//    header('Location: login.php');
//}

$item1 = new Item();
$fecha = getdate();
$fech = $fecha['year'] . "-" . $fecha['mon'] . "-" . $fecha['mday'] . " " . $fecha['hours'] . ":" . $fecha['minutes'] . ":" . $fecha['seconds'];
?>
<!DOCTYPE html>

<html lang="es">
    <head>
        <!--https://geekytheory.com/como-configurar-un-virtual-host-de-apache-en-linux/-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>NosTale DrëaM</title>
        <link rel="icon" type="image/png" href="img/favicon.ico" />
        <link rel="stylesheet" href="css/style.css">
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

        <script type="text/javascript">
            $(document).ready(function () {

                google.charts.load('current', {'packages': ['line', 'corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var chartDiv = document.getElementById('chart_div');

                    var data = new google.visualization.DataTable();
                    data.addColumn('date', '');
<?php $item1->grafico_items(); ?>
                    data.addRows([
<?php $item1->grafico_valores(); ?>
                    ]);

                    var options = {
                        animation: {
                            'startup': true,
                            duration: 1500,
                            easing: 'inAndOut'
                        },
                        chartArea: {height: '95%'},
                        legend: {position: 'top'},
                        width: $("#chart_div").width(),
                        height: 500,
                        hAxis: {textColor: '#ffffff', fontSize: 0}
                    };

                    function drawMaterialChart() {
                        var materialChart = new google.charts.Line(chartDiv);
                        materialChart.draw(data, options);
                    }

                    drawMaterialChart();
                    $(window).resize(function () {
                        drawMaterialChart();
                    });
                    fixmeTop = $('.item-list').offset().top;
                }

            });
        </script>
        <!--<script type="text/javascript" src="js/scroll.js"></script>-->

    </head>
    <body>
        <div class="body-bg-img" style="opacity:1">
            <div class="overlay_bg_div"></div>
            <img id="bg_alter" src="img/bg.jpg"/>
        </div>
        <div id="header">
            <span <?php echo $_SESSION['usename'] ?> ></span><i id="logout" class="fa fa-power-off"></i>
            <!--<div class="big_logo"><img src="img/logo.png"></div>-->
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="margin-top: 115px">
                    <!-- Chart -->
                    <div id="chart_div" style="width: 100%"></div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="margin-top: 25px">
                    <div class="col-md-3 item-list-2" style="display: none">
                    </div>
                    <div class="col-md-2 item-list">
                        <!--<div class="item-list">-->
                        <?php $item1->mostrarItems(); ?>
                        <!--</div>-->
                    </div>
                    <div class="col-md-8">
                        <div class="items">
                            <?php
                            $num = $item1->contarItems();
                            $k = 1;
                            for ($i = 1; $i < $num + 1; $i++) {
                                $k++;
                                if ($k % 2 == 0) {
                                    echo "<div class='row'>";
                                }
                                $item1->info($i);
                                if ($k % 2 != 0) {
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="content-right">
                            <div class="right-title">Precio ND</div>
                            <form id="form_nd" method="post">
                                <input type="text" name="nd" id="input-nd" value="<?php echo $item1->precio_nd(); ?>">
                                <input type="hidden" name="fecha_nd" id="fecha_nd" value="<?php echo $fech; ?>"></input>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <span id='inserting_nd_text' style='display:none'><i class='fa fa-2x fa-spinner fa-pulse'></i></span>
                                    <span id='insert_nd_text'>Cambiar</span>
                                </button>
                            </form>
                        </div>
                        <div class="content-right" style="margin-top: 10px; background: white">
                            <div class="right-title">TOP VALOR</div>
                            <div class="row">
                                <div class="col-md-6"><?php $item1->top_items(); ?></div>
                                <div class="col-md-6"><?php $item1->top_items_ayer(); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    require_once 'inc/footer.php';
    ?>
</body>
</html>