<?php
class Conectar {

    protected $conexion_bd;

    protected function conectar_bd() {
        try {
            // VARIABLES DE RAILWAY
            $host = getenv('MYSQLHOST');
            $db = getenv('MYSQLDATABASE');
            $user = getenv('MYSQLUSER');
            $pass = getenv('MYSQLPASSWORD');
            $port = getenv('MYSQLPORT');

            $conexion = $this->conexion_bd = new PDO(
                "mysql:host=$host;port=$port;dbname=$db",
                $user,
                $pass
            );

            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->exec("SET NAMES 'utf8'");

            return $conexion;

        } catch (Exception $e) {
            die("❌ Error en la conexión: " . $e->getMessage());
        }
    }
}
