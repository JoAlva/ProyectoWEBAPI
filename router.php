<?php

// Obtener ruta sin query params
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Construir path real del archivo
$file = __DIR__ . $request;

// Si el archivo existe físicamente, lo servimos
if (is_file($file)) {
    return false;
}

// RUTAS PARA CONTROLADOR, MODELOS, CONFIGURACION
if (preg_match('#^/(controlador|modelos|configuracion)/.+\.php$#', $request)) {
    require __DIR__ . $request;
    exit;
}

// Si nada coincide, cargar index
require __DIR__ . "/index.php";
