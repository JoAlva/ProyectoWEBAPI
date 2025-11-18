<?php
class Proveedor extends Conectar {

    // Obtener todos los proveedores
    public function obtener_proveedores() {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $consulta_sql = "SELECT * FROM proveedores";   
        $consulta = $conexion->prepare($consulta_sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);   
    }

    // Obtener proveedor por cedula_proveedor
    public function obtener_proveedor_por_id($cedula_proveedor) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $consulta_sql = "SELECT * FROM proveedores WHERE cedula_proveedor = ?";
        $consulta = $conexion->prepare($consulta_sql);
        $consulta->bindValue(1, $cedula_proveedor);
        $consulta->execute();

        return $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insertar nuevo proveedor
    public function insertar_proveedor($nombre, $telefono, $direccion) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sentencia_sql = "INSERT INTO proveedores (nombre, telefono, direccion) VALUES (?, ?, ?)";
        $sentencia = $conexion->prepare($sentencia_sql);
        $sentencia->bindValue(1, $nombre);
        $sentencia->bindValue(2, $telefono);
        $sentencia->bindValue(3, $direccion);
        $sentencia->execute();

        return $conexion->lastInsertId(); // Devuelve el ID generado
    }

    // Actualizar proveedor existente
    public function actualizar_proveedor($cedula_proveedor, $nombre, $telefono, $direccion) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sentencia_sql = "UPDATE proveedores SET nombre = ?, telefono = ?, direccion = ? WHERE cedula_proveedor = ?";
        $sentencia = $conexion->prepare($sentencia_sql);
        $sentencia->bindValue(1, $nombre);
        $sentencia->bindValue(2, $telefono);
        $sentencia->bindValue(3, $direccion);
        $sentencia->bindValue(4, $cedula_proveedor);
        $sentencia->execute();

        return true;
    }

    // Eliminar proveedor
    public function eliminar_proveedor($cedula_proveedor) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sentencia_sql = "DELETE FROM proveedores WHERE cedula_proveedor = ?";
        $sentencia = $conexion->prepare($sentencia_sql);
        $sentencia->bindValue(1, $cedula_proveedor);
        $sentencia->execute();

        return true;
    }

}
?>
