<?php

require_once 'inc/classDB.php';
require_once 'inc/clases/item_class.php';
require_once 'inc/sesion.php';
$item1 = new Item();

$fecha = getdate();
$fech = $fecha['year'] . "-" . $fecha['mon'] . "-" . $fecha['mday'] . " " . $fecha['hours'] . ":" . $fecha['minutes'] . ":" . $fecha['seconds'];

$id = $_POST["id"];
$valor = $_POST["valor"];
$nd = $item1->obtenND($id);
if ($nd != 0) {
    $rel = $valor / $nd;
} else {
    $rel = 0;
}
if ($item1->insertar($id, $valor, $rel, $fech)) {
    echo 1;
} else {
    echo 0;
}
?>