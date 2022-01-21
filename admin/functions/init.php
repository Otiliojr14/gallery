<?php
require_once __DIR__ . './functions.php';
if (!file_exists(__DIR__ . './config.php')) {
    die('ERROR:No existe config.php');
}

// Archivo de configuracion
require_once __DIR__ . './config.php';
// Archivo del objeto de la base de datos
require_once __DIR__ . './classDB.php';
// // Archivo de las funciones del proyecto
// require __DIR__ . './functions.php';

setlocale(LC_ALL, IDIOMA_SITIO);
date_default_timezone_set(ZONA_HORARIA);

$conn = new DB(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

require_once __DIR__ . './classUser.php';
require_once __DIR__ . './classSession.php';
