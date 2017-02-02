<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'inc/classDB.php';
require_once 'inc/clases/item_class.php';
require_once 'inc/sesion.php';
$item1 = new Item();

if ($item1->borrar($_POST['id'], $_POST['fecha'])) {
    echo 1;
} else {
    echo 0;
}
