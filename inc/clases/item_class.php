<?php

class Item {

    private $db;

    public function __construct() {
        $this->db = Conexion::conexion_singleton();
    }

    public function get_db() {
        return $this->db;
    }

    public function mostrarItems() {
        try {
            $sql = "SELECT * from item";
            $consulta = $this->db->prepare($sql);
            $consulta->execute();

            while ($fila = $consulta->fetch()) {
                $id = $fila["id"];
                $nombre = $fila["alias"];
                $nd = $fila["nd"];
                $imagen = $fila["imagen"];
                echo "<div class='item_mini' id='a" . $id . "'>";
                echo "<img src=img/" . $imagen . ".PNG>";
                if ($nd != 0) {
                    echo "<div class='mini_nd'><span>" . $nd . "</span></div>";
                }
                echo "</div>";
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function info($id) {
        try {
            $sql = "SELECT * FROM precio WHERE id=? ORDER BY fecha DESC LIMIT 10";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(1, $id);
            $consulta->execute();

            $sql2 = "SELECT nombre FROM item WHERE id=?";
            $consulta2 = $this->db->prepare($sql2);
            $consulta2->bindParam(1, $id);
            $consulta2->execute();
            $nombre = $consulta2->fetch();

            $sql3 = "SELECT valor FROM nd ORDER BY fecha DESC LIMIT 1";
            $consulta3 = $this->db->prepare($sql3);
            $consulta3->execute();
            $val = $consulta3->fetch();
            $valor = number_format($val[0]);

            $sql4 = "SELECT imagen FROM item WHERE id=?";
            $consulta4 = $this->db->prepare($sql4);
            $consulta4->bindParam(1, $id);
            $consulta4->execute();
            $imagen = $consulta4->fetch();

            $sql_media_precio = "SELECT AVG(precio)
                                    FROM precio
                                    WHERE DATE(fecha) > DATE_SUB(curdate(), INTERVAL 10 DAY)
                                    AND id=?";
            $consulta5 = $this->db->prepare($sql_media_precio);
            $consulta5->bindParam(1, $id);
            $consulta5->execute();
            $avg_precio = $consulta5->fetch();
            $media_precio = $avg_precio[0];

            echo "<div class='col col-md-6 col-sm-12'>";
            echo "<div class='panel panel-primary' id='b" . $id . "'>";
            echo "<div class='panel-heading'>" . $nombre[0] . "</div>";
            echo "<div class='panel panel-body'>";
            echo "<table class='table  table-condensed'>";
            echo "<th></th><th>Fecha</th><th>Precio</th><th>Valor</th>";
            while ($fila = $consulta->fetch()) {
                $precio = number_format($fila["precio"], 0, ",", ".") . " ";
                $relacion = number_format(($fila["relacion"] / 1000), 0, ",", ".");
                $K = "K";
                if ($relacion == 0) {
                    $relacion = "";
                    $K = "";
                }
                $fecha = $fila["fecha"];
                if ($fecha != "") {
                    $date = date_create($fecha);
                    $dia2 = date_format($date, 'M-d');
                    $hora2 = date_format($date, 'G:i');
                }
                $mes = substr($fecha, 5, 2);
                $dia = substr($fecha, 8, 2);
                $hora = substr($fecha, 11, 5);
                $hoy_d = date("d");
                $hoy_m = date("m");
                $hoy_y = date("Y");
                echo "<tr>";
                echo "<td><button class='delete_precio btn-danger' id='del-" . $id . "'value=' ' data-id='" . $id . "' data-precio='" . $fila["precio"] . "' data-fecha='" . $fila["fecha"] . "'>"
                . "<i class='fa fa-minus'></i></input></td>";

                // Fecha
                if ($hoy_d == $dia && $hoy_m == $mes) {
                    echo "<td style='background-color:rgb(95, 255, 188); padding: 1px 5px;'><span>" . $dia2 . "</span> <span style='color: grey;'>" . $hora2 . "</span></td>";
                } else {
                    echo "<td style='padding: 1px 5px;'><span>" . $dia2 . "</span> <span style='color: grey;'>" . $hora2 . "</span></td>";
                }
                // Precio
                if ($precio > $media_precio) {
                    echo "<td style='color:green'>" . $precio . "<img src='img/oro.png'/></td>";
                } else {
                    echo "<td style='color:red'>" . $precio . "<img src='img/oro.png'/></td>";
                }
                // Relacion
                if ($relacion > $valor) {
                    echo "<td style='color:green'>" . $relacion . $K . "</td>";
                } else if ($relacion == $valor) {
                    echo "<td style='color:green'>" . $relacion . $K . "</td>";
                } else if ($relacion < $valor) {
                    echo "<td style='color:red'>" . $relacion . $K . "</td>";
                }

                echo "</tr>";
            }
            echo "</table>";
            echo "<form id='form_" . $id . "' class='formu' method='post'>
                    <input type='hidden' name='id' value='" . $id . "'/>
                    <img src='img/" . $imagen[0] . ".PNG' class='mini-icon-insert'/>
                    <input type='text' name='valor' id='valor" . $id . "' class='input-precio' min='1'/>
                    <button type='submit' id='submit_" . $id . "' class='btn btn-primary btn-block'>
                        <span id='enviando-text-" . $id . "' style='display:none'><i class='fa fa-2x fa-spinner fa-pulse'></i></span>
                        <span id='enviar-text-" . $id . "'>Añadir</span>
                        <span id='enviado-text-" . $id . "' style='display:none'><i class='fa fa-check'></i></span>
                    </button>
                </form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function insertar($id, $valor, $rel, $fech) {
        try {
            $sentencia = $this->db->prepare("INSERT INTO precio(id,precio,relacion,fecha) VALUES (?,?,?,?)");
            $sentencia->bindParam(1, $id);
            $sentencia->bindParam(2, $valor);
            $sentencia->bindParam(3, $rel);
            $sentencia->bindParam(4, $fech);

            $sentencia->execute();
            return true;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function borrar($id, $fech) {
        try {
            $sentencia = $this->db->prepare("DELETE FROM precio WHERE id=? AND fecha=?");
            $sentencia->bindParam(1, $id);
            $sentencia->bindParam(2, $fech);

            $sentencia->execute();
            return true;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function obtenND($id) {
        try {
            $sql = "SELECT nd FROM item WHERE id=?";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(1, $id);
            $consulta->execute();

            $fila = $consulta->fetch();
            $nd = $fila["nd"];
            return $nd;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function contarItems() {
        try {
            $sql = "SELECT * from item";
            $consulta = $this->db->prepare($sql);
            $consulta->execute();
            $num = $consulta->rowCount();
            return $num;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function precio_nd() {
        try {
            $sql = "SELECT valor FROM nd ORDER BY fecha DESC LIMIT 1";
            $consulta = $this->db->prepare($sql);
            $consulta->execute();
            $fila = $consulta->fetch();
            return $fila[0];
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function modif_nd($nd) {
        try {
            $sql = "UPDATE nd SET valor=? WHERE id=1";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(1, $nd);
            $consulta->execute();
            return true;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function insert_nd($nd, $fecha) {
        try {
            $sentencia = $this->db->prepare("INSERT INTO nd(valor,fecha) VALUES (?,?)");
            $sentencia->bindParam(1, $nd);
            $sentencia->bindParam(2, $fecha);

            $sentencia->execute();
            return true;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function todo() {
        try {
            $sql = "SELECT * FROM todo ORDER BY prioridad";
            $consulta = $this->db->prepare($sql);
            $consulta->execute();
            while ($fila = $consulta->fetch()) {
                echo "<p><b>[" . $fila["prioridad"] . "]</b> " . $fila["desc"] . "</p>";
            }
            return $fila[0];
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function top_items() {
        try {
            /* HOY */
            $sql = "SELECT id, alias, relacion, imagen, MAX(fecha) FROM (
                        SELECT precio.id, item.alias, relacion, imagen, fecha
                            FROM precio
                            INNER JOIN item ON item.id = precio.id
                            WHERE DATE(fecha) = DATE(NOW())
                            ORDER BY relacion DESC
                        ) as t1
                        GROUP BY id
                        ORDER BY relacion DESC";

            $consulta = $this->db->prepare($sql);
            $consulta->execute();

            /* AYER */
            $sql2 = "SELECT id, alias, relacion, imagen, MAX(fecha) FROM (
                        SELECT precio.id, item.alias, relacion, imagen, fecha
                            FROM precio
                            INNER JOIN item ON item.id = precio.id
                            WHERE DATE(fecha) = DATE(NOW())-1
                            ORDER BY relacion DESC
                        ) as t1
                        GROUP BY id
                        ORDER BY relacion DESC";

            $consulta2 = $this->db->prepare($sql2);
            $consulta2->execute();

            $array_top = [];
            $i = 0;
            while ($fila2 = $consulta2->fetch()) {
                $i++;
                $array_top[$fila2['id']] = $i;
            }

            echo "<div><h4>Hoy</h4></div>";
            $j = 0;
            while ($fila = $consulta->fetch()) {
                $j++;
                $pos = $array_top[$fila['id']] - $j;
                if ($fila["relacion"] != 0) {
                    echo "<div class='top_fila'>";
                    if ($pos > 0) {
                        echo "<span style='color: green'><i class='fa fa-arrow-up'></i>" . $pos . "</span>";
                    } else if ($pos < 0) {
                        echo "<span style='color: red'><i class='fa fa-arrow-down'></i>" . $pos . "</span>";
                    } else {
                        echo "<span style='color: blue'>" . $pos . "</span>";
                    }
                    if ($this->precio_nd() > number_format(($fila["relacion"] / 1000))) {
                        echo "<div class='top_fila_val' style='color: red'><b>" . number_format(($fila["relacion"] / 1000), 0, ",", ".") . " K</b></div>";
                    } else {
                        echo "<div class='top_fila_val' style='color: blue'><b>" . number_format(($fila["relacion"] / 1000), 0, ",", ".") . " K</b></div>";
                    }
                    echo "<div class='top_fila_name' style='color: black' id='" . $fila['id'] . "'><img class='mini-icon' src='img/" . $fila["imagen"] . ".PNG'/> ";
//                    if ($this->precio_nd() > number_format(($fila["relacion"] / 1000))) {
//                        echo "<span style='color: red'>" . $fila['id'] . "</span>";
//                    } else {
//                        echo "<span style='color: blue'>" . $fila['id'] . "</span>";
//                    }
                    echo "</div></div>";
                }
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function top_items_ayer() {
        try {
            $sql = "SELECT id, alias, relacion, imagen, MAX(fecha) FROM (
                        SELECT precio.id, item.alias, relacion, imagen, fecha
                            FROM precio
                            INNER JOIN item ON item.id = precio.id
                            WHERE DATE(fecha) = DATE(NOW())-1
                            ORDER BY relacion DESC
                        ) as t1
                        GROUP BY id
                        ORDER BY relacion DESC";

            $consulta = $this->db->prepare($sql);
            $consulta->execute();
            echo "<div><h4>Previo</h4></div>";
            while ($fila = $consulta->fetch()) {
                if ($fila["relacion"] != 0) {
                    echo "<div class='top_fila'>";
                    if ($this->precio_nd() > number_format(($fila["relacion"] / 1000))) {
                        echo "<div class='top_fila_val' style='color: red'><b>" . number_format(($fila["relacion"] / 1000), 0, ",", ".") . " K</b></div>";
                    } else {
                        echo "<div class='top_fila_val' style='color: blue'><b>" . number_format(($fila["relacion"] / 1000), 0, ",", ".") . " K</b></div>";
                    }
                    echo "<div class='top_fila_name' style='color: black' id='" . $fila['id'] . "'><img class='mini-icon' src='img/" . $fila["imagen"] . ".PNG'/> ";
//                    if ($this->precio_nd() > number_format(($fila["relacion"] / 1000))) {
//                        echo "<span style='color: red'>" . $fila['id'] . "</span>";
//                    } else {
//                        echo "<span style='color: blue'>" . $fila['id'] . "</span>";
//                    }
                    echo "</div></div>";
                }
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage
                    ();
        }
    }

//    public function grafico_items() {
//        try {
//            $sql = "SELECT *
//                            FROM precio p
//                            INNER JOIN item i ON p.id = i.id
//                            WHERE relacion != 0 AND FECHA > DATE_SUB(curdate(), INTERVAL 10 DAY) AND fecha = curdate()
//                            GROUP BY DAY(fecha), nombre
//                            ORDER BY fecha DESC, p.relacion DESC";
//            $consulta = $this->db->prepare($sql);
//            $consulta->execute();
//            while ($fila = $consulta->fetch()) {
//                echo "data.addColumn('number', '" . $fila["nombre"] . "' );
//                    \n";
//            }
//        } catch (PDOException $e) {
//            print "Error!: " . $e->getMessage
//                    ();
//        }
//    }

    public function grafico_items() {
        try {
            $sql = "SELECT *, DATE_FORMAT(p.fecha, '%Y-%m-%d') AS fch
                            FROM precio p
                            INNER JOIN item i ON p.id = i.id
                            WHERE relacion != 0 AND FECHA > DATE_SUB(curdate(), INTERVAL 10 DAY)
                            GROUP BY fch, nombre
                            ORDER BY fch DESC, relacion DESC";
            $consulta = $this->db->prepare($sql);
            $consulta->execute();
            $array = [];
            while ($fila = $consulta->fetch()) {
                $array[$fila["fch"]][$fila["nombre"]] = $fila["relacion"];
            }
            $cad = "";
            // Order array
            $i = 0;
            $order_array = [];
            foreach ($array as $fecha => $value) {
                if ($i == 0) {
                    $order_array = $value;
                } else {
                    $array[$fecha] = $this->sortArrayByArray($value, $order_array);
                }
                $i++;
            }

            // Make the cad
            $j = 0;
            foreach ($array as $fecha => $value) {
                if ($j == 0) {
                    foreach ($value as $nombre => $rel) {
                        echo "data.addColumn('number', '" . $nombre . "' );\n";
                    }
                }

                $j++;
            }
            $cad = rtrim($cad, ", ");
            echo $cad;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    /* Needed functions */

    function sortArrayByArray($array, $orderArray) {
        $ordered = array();
        foreach ($orderArray as $key => $value) {
            if (array_key_exists($key, $array)) {
                $ordered[$key] = $array[$key];
                unset($array[$key]);
            } else {
                $ordered[$key] = 0;
            }
        }
        return $ordered + $array;
    }

    function refill($array) {
        $i == 0;
        $array_prev = [];
        $narray = [];
        foreach ($array as $fecha => $items) {
            if ($i != 0) {
                foreach ($items as $item => $rel) {
                    if ($rel == 0) {
                        $narray[$fecha][$item] = $array_prev[$item];
                    } else {
                        $narray[$fecha][$item] = $rel;
                    }
                }
            } else {
                $narray[$fecha] = $items;
            }
            $i++;
            $array_prev = $narray[$fecha];
        }

        return $narray;
    }

    public function grafico_valores() {
        try {
            $sql = "SELECT *, DATE_FORMAT(p.fecha, '%Y-%m-%d') AS fch
                            FROM precio p
                            INNER JOIN item i ON p.id = i.id
                            WHERE relacion != 0 AND FECHA > DATE_SUB(curdate(), INTERVAL 10 DAY)
                            GROUP BY fch, nombre
                            ORDER BY fch DESC, relacion DESC";
            $consulta = $this->db->prepare($sql);
            $consulta->execute();
            $array = [];
            while ($fila = $consulta->fetch()) {
                $array[$fila["fch"]][$fila["nombre"]] = $fila["relacion"];
            }
            $cad = "";
            // Order array
            $i = 0;
            $order_array = [];
            foreach ($array as $fecha => $value) {
                if ($i == 0) {
                    $order_array = $value;
                } else {
                    $array[$fecha] = $this->sortArrayByArray($value, $order_array);
                }
                $i++;
            }
            $array = $this->refill($array);
//            print_r($array);
            // Make the cad
            foreach ($array as $fecha => $value) {
                $nfecha = split("-", $fecha);
                $cad .= "[new Date(" . $nfecha[0] . ", " . ($nfecha[1]) . ", " . $nfecha[2] . ")";
                foreach ($value as $nombre => $rel) {
                    $cad .= ", " . $rel;
                }
                $cad .= "], ";
            }
            $cad = rtrim($cad, ", ");
            echo $cad;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    // Evita que el objeto se pueda clonar
    public function __clone() {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

}
