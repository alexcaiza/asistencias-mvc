<?php

// Zona Horaria de Ecuador
date_default_timezone_set('America/Guayaquil');

// Configuración de la Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'asistenciasdb');
define('DB_USER', 'root');
define('DB_PASS', '');

// URL Base - Detección automática
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseDir = dirname($_SERVER['SCRIPT_NAME'] ?? '/asistencias-mvc/public');
if ($baseDir === '/' || $baseDir === '\\') $baseDir = '';
define('URL_BASE', $protocol . '://' . $host . $baseDir);

// Nombre del Sitio
define('APP_NAME', 'AttendancePro');
