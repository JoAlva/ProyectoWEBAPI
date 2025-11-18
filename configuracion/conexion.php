<?php
class Conectar {

    protected $conexion_bd;

    protected function conectar_bd() {
        try {
            $host = getenv("MYSQLHOST");
            $db   = getenv("MYSQLDATABASE");
            $user = getenv("MYSQLUSER");
            $pass = getenv("MYSQLPASSWORD");
            $port = getenv("MYSQLPORT");

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";

            $this->conexion_bd = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            return $this->conexion_bd;

        } catch (Exception $e) {
            die("❌ Error en la base de datos: " . $e->getMessage());
        }
    }

    public function establecer_codificacion() {
        return $this->conexion_bd->query("SET NAMES 'utf8'");
    }
}
