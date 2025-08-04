<?php

// Root path definition
define('ROOT_PATH', __DIR__ . '/');

// Core directory paths
define('PRIVATE_PATH', ROOT_PATH.'private/');
define('PUBLIC_PATH', ROOT_PATH.'public/');

// PLANTILLAS Y MENUS DEL SISTEMA
define('TEMPLATES_PATH', PRIVATE_PATH.'plantillas/');
define('MENU_PATH', PRIVATE_PATH.'menu/');

// CONEXION A BASE DE DATOS Y PROCESOS
define('CONFIG_PATH', PRIVATE_PATH.'conexion/');
define('PROCESOS_PATH', PRIVATE_PATH.'procesos/');
define('LOGIN_PATH', ROOT_PATH.'private/procesos/login/');
define('CAPTURA_DATOS_SOCIOECONOMICOS_PATH', ROOT_PATH.'private/procesos/aspirante/socioeconomicos/');
define('GESTION_ALUMNOS', PRIVATE_PATH.'procesos/planeacion/gestion_alumnos/');
define('GESTION_PAGOS_PATH', PRIVATE_PATH.'procesos/planeacion/gestion_pagos/');

// MODALES DEL SISTEMA
define('MODALES_PATH', PRIVATE_PATH.'modales/');
define('MODALES_PERSONAL_PATH', PRIVATE_PATH.'modales/personal/');
define('MODALES_ASPIRANTES_PATH', PRIVATE_PATH.'modales/aspirantes/');
define('MODALES_ALUMNOS_PATH', PRIVATE_PATH.'modales/alumnos/');
define('MODALES_INICIO_SESSION_PATH', PRIVATE_PATH.'modal/modal_session_general/');

// MODULOS DEL SISTEMA DE ASIPIRANTES
define('DATOS_SOCIOECONOMICOS_PATH', ROOT_PATH.'modulo/aspirante/');
define('DATOS_PATH', ROOT_PATH.'modulo/aspirante/datos_socioeconomicos/');

// Asset paths
define('CUSTOM_INDEX_LOGIN', PUBLIC_PATH.'assets/custom/login/');