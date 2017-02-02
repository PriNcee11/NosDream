<?php

require_once 'inc/classDB.php';
require_once 'inc/clases/item_class.php';
require_once 'inc/sesion.php';
$item1 = new Item();

$fecha = getdate();
$fech = $fecha['year'] . "-" . $fecha['mon'] . "-" . $fecha['mday'] . " " . $fecha['hours'] . ":" . $fecha['minutes'] . ":" . $fecha['seconds'];

$valor = $_POST["valor"];

if ($item1->insert_nd($valor, $fech)) {
    echo 1;
} else {
    echo 0;
}
?>