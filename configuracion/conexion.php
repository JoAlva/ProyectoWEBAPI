<?php
class Conectar {

    protected $conexion_bd;

    protected function conectar_bd() {
        try {

            $host = $_ENV['MYSQLHOST'] ?? 'localhost';
            $db   = $_ENV['MYSQLDATABASE'] ?? 'proyecto';
            $user = $_ENV['MYSQLUSER'] ?? 'root';
            $pass = $_ENV['MYSQLPASSWORD'] ?? '';
            $port = $_ENV['MYSQLPORT'] ?? '3306';

            $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8";

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
