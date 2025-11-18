<?php
header("Content-Type: application/json");

require_once("../configuracion/conexion.php");
require_once("../modelos/Producto.php");

$producto = new Producto();
$body = json_decode(file_get_contents("php://input"), true);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case "GET":
        if (isset($_GET["codigo"])) {
            $datos = $producto->obtener_producto_por_codigo($_GET["codigo"]);
            echo json_encode($datos);
            break;
        }
        $datos = $producto->obtener_productos();
        echo json_encode($datos);
        break;

    case "POST":
        $producto->insertar_producto(
            $body["codigo"],
            $body["nombre"],
            $body["precio"],
            $body["stock"],
            $body["cedula_proveedor"]
        );
        echo json_encode(["Correcto" => "Producto insertado correctamente"]);
        break;

    case "PUT":
        $producto->actualizar_producto(
            $body["codigo"],
            $body["nombre"],
            $body["precio"],
            $body["stock"],
            $body["cedula_proveedor"]
        );
        echo json_encode(["Correcto" => "Producto actualizado correctamente"]);
        break;

    case "DELETE":
        $codigo = $body["codigo"];
        $producto->eliminar_producto($codigo);
        echo json_encode(["Correcto" => "Producto eliminado correctamente"]);
        break;
}
?>
