<?php
header("Content-Type: application/json");

require_once("../configuracion/conexion.php");
require_once("../modelos/Proveedor.php");
require_once("../modelos/Usuarios.php");

$usuario = new Usuarios();
$encabezados = getallheaders();

// Validar cabecera
if (!isset($encabezados['cedula'])) {
    echo json_encode(["error" => "Acceso no autorizado: cabecera 'cedula' requerida"]);
    exit();
}

// Buscar usuario
$cedula = $encabezados['cedula'];
$usuario_db = $usuario->obtener_por_cedula($cedula);
if (!$usuario_db || !isset($usuario_db['llave'])) {
    echo json_encode(["error" => "Acceso no autorizado: cédula no encontrada o sin llave"]);
    exit();
}

$clave_secreta_usuario = $usuario_db['llave'];

// Función para desencriptar
function Desencriptar_BODY($JSON, $clave) {
    $cifrado = "aes-256-ecb";
    if (empty($JSON) || empty($clave)) return false;
    $decoded = base64_decode($JSON, true);
    if ($decoded === false) return false;
    return openssl_decrypt($decoded, $cifrado, $clave, OPENSSL_RAW_DATA);
}

$proveedor = new Proveedor();
$body_encriptado = file_get_contents("php://input");

if (!empty($body_encriptado)) {
    $desencriptado = Desencriptar_BODY($body_encriptado, $clave_secreta_usuario);
    $body = json_decode($desencriptado, true);
    if ($body === null) {
        echo json_encode(["Error" => "Error al desencriptar los datos."]);
        exit();
    }
} else {
    $body = [];
}

if (!isset($_GET["op"])) {
    echo json_encode(["error" => "Operación no válida (falta parámetro 'op')"]);
    exit();
}

$op = trim($_GET["op"]);

switch ($op) {
    case "ObtenerTodos":
        $datos = $proveedor->obtener_proveedores();
        echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    case "ObtenerPorId":
        $datos = $proveedor->obtener_proveedor_por_id($body["cedula_proveedor"]);
        echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    case "Insertar":
        $nuevo_id = $proveedor->insertar_proveedor($body["nombre"], $body["telefono"], $body["direccion"]);
        echo json_encode(["Correcto" => "Proveedor insertado correctamente", "cedula_proveedor" => $nuevo_id]);
        break;

    case "Actualizar":
        $proveedor->actualizar_proveedor($body["cedula_proveedor"], $body["nombre"], $body["telefono"], $body["direccion"]);
        echo json_encode(["Correcto" => "Proveedor actualizado correctamente"]);
        break;

    case "Eliminar":
        $proveedor->eliminar_proveedor($body["cedula_proveedor"]);
        echo json_encode(["Correcto" => "Proveedor eliminado correctamente"]);
        break;

    default:
        echo json_encode(["error" => "Operación no válida", "valor_op" => $op]);
        break;
}
?>
