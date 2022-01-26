<?php

// Configura la salida de errores por pantalla
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('INCLUDES_PATH', 'http://localhost/gallery');
define('ZONA_HORARIA', 'America/Mexico_City');
define('IDIOMA_SITIO', ['es', 'spa', 'es_MX']);

// Valores para conectar a la base de datos

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'gallery_db');
