<?php

class Conexion {

    private static $dns = 'mysql:host=192.168.1.200;dbname=nosdream';
    private static $username = 'pi';
    private static $password = 'pi_pr1N';
    private static $instance;

    private function __construct() {

    }

    /**
     * Crea una instancia de la clase PDO
     */
    public static function conexion_singleton() {
        if (!isset(self::$instance)) {
            try {
                // self se utiliza para referenciar m�todos staticos o atributos estaticos
                //this no puede referenciar a metodos estaticos
                //para acceder a metodos staticos fuera de la clase ::
                self::$instance = new PDO(self::$dns, self::$username, self::$password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));

                //por defecto PDO viene configurado para no mostrar ningun error
                // con la funcion setAttibure lanzamos un error cada vez que se produce una excepcion
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Conexion creada correctamente";
            } catch (PDOException $e) {
                echo 'Error al conectar con la Base de Datos';
            }
        }
        return self::$instance;
    }

    /**
     * Impide que la clase sea clonada
     */
    public function __clone() {
        trigger_error('La clonaci�n de este objeto no est� permitida', E_USER_ERROR);
    }

}

?>