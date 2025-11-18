<?php

// Obtener la ruta solicitada
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Si el archivo existe físicamente, servirlo directamente
$file = __DIR__ . $request;
if (is_file($file)) {
    return false;
}

// Redirigir rutas hacia carpetas (controlador/, modelos/, etc.)
if (preg_match('/^\/controlador\/.+\.php$/', $request)) {
    require __DIR__ . $request;
    exit;
}

// Si nada coincide, cargar index
require __DIR__ . "/index.php";
