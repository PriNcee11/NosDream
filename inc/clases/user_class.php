<?php

Class User {

    private $db;

    public function __construct() {
        $this->db = Conexion::conexion_singleton();
    }

    public function get_db() {
        return $this->db;
    }

    public function getUser($user, $pass) {
        try {
            $sql = "SELECT * FROM users WHERE username=? AND password = md5(?)";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(1, $user);
            $consulta->bindParam(2, $pass);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

}
