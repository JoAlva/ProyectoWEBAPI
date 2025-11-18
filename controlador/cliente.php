<?php
header("Content-Type: application/json");

require_once("../configuracion/conexion.php");
require_once("../modelos/Cliente.php");

$cliente = new Cliente();
$body = json_decode(file_get_contents("php://input"), true);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case "GET":
        if (isset($_GET["cedula"])) {
            $datos = $cliente->obtener_cliente_por_cedula($_GET["cedula"]);
            echo json_encode($datos);
        } else {
            $datos = $cliente->obtener_clientes();
            echo json_encode($datos);
        }
        break;

    case "POST":
        $cliente->insertar_cliente(
            $body["cedula"],
            $body["nombre"],
            $body["telefono"],
            $body["direccion"]
        );
        echo json_encode(["Correcto" => "Cliente insertado correctamente"]);
        break;

    case "PUT":
        $cliente->actualizar_cliente(
            $body["cedula"],
            $body["nombre"],
            $body["telefono"],
            $body["direccion"]
        );
        echo json_encode(["Correcto" => "Cliente actualizado correctamente"]);
        break;

    case "DELETE":
        $cedula = $body["cedula"];
        $cliente->eliminar_cliente($cedula);
        echo json_encode(["Correcto" => "Cliente eliminado correctamente"]);
        break;
}
?>
