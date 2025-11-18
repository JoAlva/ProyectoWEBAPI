<?php  
class Conectar {

    protected $conexion_bd;

    protected function conectar_bd() {

        // Detectar si estamos en Railway (MYSQLHOST existe)
        if (getenv("MYSQLHOST")) {

            $host = getenv("MYSQLHOST");
            $db   = getenv("MYSQLDATABASE");
            $user = getenv("MYSQLUSER");
            $pass = getenv("MYSQLPASSWORD");
            $port = getenv("MYSQLPORT");

        } else {
            // Modo LOCAL (XAMPP)
            $host = "localhost";
            $db   = "andercode_webservice"; // <-- CAMBIA ESTE A TU BD LOCAL
            $user = "root";
            $pass = "1234";
            $port = "3306";
        }

        try {

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";

            $this->conexion_bd = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            return $this->conexion_bd;

        } catch (Exception $e) {

            // Nunca usar die() en Railway → rompe el servidor
            echo json_encode([
                "status" => "error",
                "message" => "Error al conectar BD",
                "detalle" => $e->getMessage()
            ]);
            exit();
        }
    }

    public function establecer_codificacion() {
        return $this->conexion_bd->query("SET NAMES 'utf8'");
    }
}
