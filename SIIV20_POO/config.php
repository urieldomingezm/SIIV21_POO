<?php

// Root path definition
define('ROOT_PATH', __DIR__ . '/');

// Core directory paths
define('PRIVATE_PATH', ROOT_PATH.'private/');
define('PUBLIC_PATH', ROOT_PATH.'public/');

// Template and layout paths
define('TEMPLATES_PATH', PRIVATE_PATH.'plantillas/');
define('MENU_PATH', PRIVATE_PATH.'menu/');

// Database and process paths
define('CONFIG_PATH', PRIVATE_PATH.'conexion/');
define('PROCESOS_PATH', PRIVATE_PATH.'procesos/');
define('LOGIN_PATH', ROOT_PATH.'private/procesos/SII_login_y_registro/');
define('CAPTURA_DATOS_SOCIOECONOMICOS_PATH', ROOT_PATH.'private/procesos/aspirante/socioeconomicos/');

// Modal paths by user type
define('MODALES_PERSONAL_PATH', PRIVATE_PATH.'modales/personal/');
define('MODALES_ASPIRANTES_PATH', PRIVATE_PATH.'modales/aspirantes/');
define('MODALES_ALUMNOS_PATH', PRIVATE_PATH.'modales/alumnos/');
define('MODALES_INICIO_SESSION_PATH', PRIVATE_PATH.'modal/modal_session_general/');

// Aspirante specific paths
define('DATOS_SOCIOECONOMICOS_PATH', ROOT_PATH.'modulo/aspirante/');
define('DATOS_PATH', ROOT_PATH.'modulo/aspirante/datos_socioeconomicos/');

// Asset paths
define('CUSTOM_INDEX_LOGIN', PUBLIC_PATH.'custom/custom_index_login/');

?>


