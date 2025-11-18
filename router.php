<?php

// Si la ruta existe en el disco, servirla directo
if (php_sapi_name() === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($file)) {
        return false;
    }
}

// Redirigir todo a index o directamente al controlador
require_once __DIR__ . $_SERVER['REQUEST_URI'];
