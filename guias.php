<?php
	require_once 'inc/classDB.php';
	require_once 'inc/clases/item_class.php';
	require_once 'inc/sesion.php';
	$item1 = new Item();
	$fecha = getdate();
	$fech = $fecha['year'] . "-" . $fecha['mon'] . "-" . $fecha['mday'] . " " . $fecha['hours'] . ":" . $fecha['minutes'] . ":" . $fecha['seconds'];
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>NosTale Market</title>
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

        <script type="text/javascript">

        </script>
    </head>

    <body>
        <div class="body-bg-img" style="opacity:1">
            <div class="overlay_bg_div"></div>
            <img id="bg_alter" src="img/bg.jpg" alt="bg"/>
        </div>
        <div id="header">
            <div class="big_logo"><img src="img/logo.png"></div>
        </div>

        <div class="containter">
        	<div class="row">
        		<div class="col-md-8">
        			- Palancas Ibra
        			- Diarias
        			- Alas: Formas y porcentajes
        			- Gasto subir alas y combis
        			- Resis Hight level
        		</div>
        		<div class="col-md-4">
	                <div class="content-right">
	                    <div>
	                        <iframe src="http://www.zeitverschiebung.net/clock-widget-iframe?language=es&timezone=Europe%2FMadrid" width="100%" height="135" frameborder="0" seamless>
	                        </iframe>
	                    </div>
	                </div>
	                <div class="content-right" style="margin-top: 10px;">
	                    <div class="right-title">Precio ND</div>
	                    <form id="form_nd" method="post">
	                        <input type="text" name="nd" id="input-nd" value="<?php echo $item1->precio_nd(); ?>">
	                        <input type="hidden" name="fecha_nd" id="fecha_nd" value="<?php echo $fech; ?>"></input>
	                        <button type="submit" class="btn btn-default">
	                            <span id='inserting_nd_text' style='display:none'><i class='fa fa-2x fa-spinner fa-pulse'></i></span>
	                            <span id='insert_nd_text'>Cambiar</span>
	                        </button>
	                    </form>
	                </div>
	                <div class="content-right" style="margin-top: 10px;">
	                    <div class="right-title">TOP VALOR</div>
	                    <div class="valor_dia">	<?php $item1->top_items(); ?></div>
	                    <div class="valor_ayer"> <?php $item1->top_items_ayer(); ?></div>
	                </div>
        		</div>
        	</div>
        </div>

	    <?php
	    	require_once 'inc/footer.php';
	    ?>
    </body>
</html>