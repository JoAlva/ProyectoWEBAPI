<?php
class Conectar {
    protected $dbh;

    protected function Conexion() {
        try {
            $host = "mysql.railway.internal";
            $dbname = "railway";
            $user = "root";
            $pass = "OSqpNpBuwhRqGqKRgsJaydhVQIGICtnr";
            $port = "3306";

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

            $this->dbh = new PDO($dsn, $user, $pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->dbh;
        } catch (Exception $e) {
            die("❌ Error de conexión: " . $e->getMessage());
        }
    }
}
?>
