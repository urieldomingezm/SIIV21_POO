<?php
ob_start();

session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');
require_once(TEMPLATES_PATH . 'footer.php');

if (!isset($_SESSION['user_type'])) {
    ob_end_clean();
    header('Location: /');
    exit;
}

switch ($_SESSION['user_type']) {
    case 'alumno':
        ob_end_clean();
        header('Location: /modulo/alumno/');
        exit;
    case 'aspirante':
        ob_end_clean();
        header('Location: /modulo/aspirante/');
        exit;
    case 'personal':
        ob_end_clean();
        header('Location: /modulo/personal/');
        exit;
    default:
        ob_end_clean();
        header('Location: /');
        exit;
}

ob_end_clean();
header('Location: /');
exit;
?>