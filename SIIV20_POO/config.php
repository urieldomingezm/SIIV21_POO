<?php

define('ROOT_PATH', __DIR__ . '/');

// Definir rutas para carpetas específicas
define('PRIVATE_PATH', ROOT_PATH.'private/');
define('MODULOS_PATH', ROOT_PATH.'menu/'); // Ruta a menu alumnos, aspirantes y personal
define('TEMPLATES_PATH', PRIVATE_PATH.'plantillas/'); // Ruta a header.php y footer.php
define('CONFIG_PATH', PRIVATE_PATH.'conexion/'); // RUTA DE BD

// RUTA PARA MODALES
define('MODALES', PRIVATE_PATH.'modal/');

// RUTA PARA MODALES DE INICIO DE SESIÓN
define('MODALES_INICIO_SESSION_PATH', PRIVATE_PATH.'modal/modal_session_general/'); 

// define('MENU_PATH', PRIVATE_PATH.'menu/');
?>


