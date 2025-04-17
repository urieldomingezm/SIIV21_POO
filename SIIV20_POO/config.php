<?php

define('ROOT_PATH', __DIR__ . '/');

// Definir rutas para carpetas específicas
define('PRIVATE_PATH', ROOT_PATH.'private/');
define('TEMPLATES_PATH', PRIVATE_PATH.'plantillas/'); // Ruta a header.php y footer.php
define('CONFIG_PATH', PRIVATE_PATH.'conexion/'); // RUTA DE BD
define('PROCESOS_PATH', PRIVATE_PATH.'procesos/'); // RUTA DE PROCESOS
define('DATOS_SOCIOECONOMICOS_PATH', ROOT_PATH.'modulo/aspirante/'); // RUTA DE DATOSSOCIOECONMICOS

// RUTA PARA DATOS SOCIOECONOMICOS DE ASPIRANTES
define('DATOS_PATH', ROOT_PATH.'modulo/aspirante/datos_socioeconomicos/');

// RUTA PARA PROCESOS DE INICIO DE SESIÓN Y REGISTRO DE ASPIRANTES, PERSONAL Y DE ALUMNOS
define('LOGIN_PATH', ROOT_PATH.'private/procesos/SII_login_y_registro/');

// RUTA PARA MODALES
define('MODALES', PRIVATE_PATH.'modal/');

// RUTA PARA MODALES DE INICIO DE SESIÓN
define('MODALES_INICIO_SESSION_PATH', PRIVATE_PATH.'modal/modal_session_general/'); 

// DEFINIR RUTAS PARA ARCHIVOS PUBLICOS
define('PUBLIC_PATH', ROOT_PATH.'public/');

// RUTA PARA ARCHIVOS CSS PARA INICIO DE SESSION
define('CUSTOM_INDEX_LOGIN', PUBLIC_PATH.'custom/custom_index_login/');

// RUTA PARA ARCHIVOS PARA MENUS
define('MENU_PATH', PRIVATE_PATH.'menu/');

// define('MENU_PATH', PRIVATE_PATH.'menu/');
?>


