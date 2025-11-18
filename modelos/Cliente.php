<?php
// ---------------------------------------------
//  IMPORTANTE: llamar la conexión correctamente
// ---------------------------------------------
require_once __DIR__ . "/../configuracion/conexion.php";

class Cliente extends Conectar {

    // ----------------------------------------------------------
    // Obtener todos los clientes
    // ----------------------------------------------------------
    public function obtener_clientes() {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT * FROM clientes";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ----------------------------------------------------------
    // Obtener cliente por cédula
    // ----------------------------------------------------------
    public function obtener_cliente_por_cedula($cedula) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT * FROM clientes WHERE cedula = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $cedula);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ----------------------------------------------------------
    // Insertar cliente
    // ----------------------------------------------------------
    public function insertar_cliente($cedula, $nombre, $telefono, $direccion) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "INSERT INTO clientes (cedula, nombre, telefono, direccion) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindValue(1, $cedula);
        $stmt->bindValue(2, $nombre);
        $stmt->bindValue(3, $telefono);
        $stmt->bindValue(4, $direccion);

        return $stmt->execute();
    }

    // ----------------------------------------------------------
    // Actualizar cliente
    // ----------------------------------------------------------
    public function actualizar_cliente($cedula, $nombre, $telefono, $direccion) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "UPDATE clientes SET nombre = ?, telefono = ?, direccion = ? WHERE cedula = ?";
        $stmt = $conexion->prepare($sql);

        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $telefono);
        $stmt->bindValue(3, $direccion);
        $stmt->bindValue(4, $cedula);

        return $stmt->execute();
    }

    // ----------------------------------------------------------
    // Eliminar cliente
    // ----------------------------------------------------------
    public function eliminar_cliente($cedula) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "DELETE FROM clientes WHERE cedula = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $cedula);

        return $stmt->execute();
    }
}
?>

