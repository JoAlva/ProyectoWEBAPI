<?php
class Producto extends Conectar {

    // GET - Obtener todos los productos
    public function obtener_productos() {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT p.*, pr.nombre AS nombre_proveedor
                FROM productos p
                LEFT JOIN proveedores pr ON p.cedula_proveedor = pr.cedula_proveedor";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_producto_por_codigo($codigo) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT * FROM productos WHERE codigo = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(1, $codigo);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // POST - Insertar producto
    public function insertar_producto($codigo, $nombre, $precio, $stock, $cedula_proveedor) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "INSERT INTO productos (codigo, nombre, precio, stock, cedula_proveedor) VALUES (?, ?, ?, ?, ?)";
        $consulta = $conexion->prepare($sql);

        $consulta->bindValue(1, $codigo);
        $consulta->bindValue(2, $nombre);
        $consulta->bindValue(3, $precio);
        $consulta->bindValue(4, $stock);
        $consulta->bindValue(5, $cedula_proveedor);

        return $consulta->execute();
    }

    // PUT - Actualizar producto
    public function actualizar_producto($codigo, $nombre, $precio, $stock, $cedula_proveedor) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "UPDATE productos SET nombre = ?, precio = ?, stock = ?, cedula_proveedor = ? WHERE codigo = ?";
        $consulta = $conexion->prepare($sql);

        $consulta->bindValue(1, $nombre);
        $consulta->bindValue(2, $precio);
        $consulta->bindValue(3, $stock);
        $consulta->bindValue(4, $cedula_proveedor);
        $consulta->bindValue(5, $codigo);

        return $consulta->execute();
    }

    // DELETE - Borrar producto
    public function eliminar_producto($codigo) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "DELETE FROM productos WHERE codigo = ?";
        $consulta = $conexion->prepare($sql);

        $consulta->bindValue(1, $codigo);

        return $consulta->execute();
    }
}
?>
