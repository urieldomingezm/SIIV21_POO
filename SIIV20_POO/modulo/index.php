<?php
ob_start();

session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');
require_once(TEMPLATES_PATH . 'footer.php');


if (isset($_SESSION['user_type'])) {

    $userType = $_SESSION['user_type'];
    
    if ($userType === 'aspirante') {

        $aspiranteId = $_SESSION['aspirante_id'];
        $aspiranteCurp = $_SESSION['aspirante_curp'];
        ob_end_clean();
        header('Location: /modulo/aspirante/');
        exit;
    } elseif ($userType === 'alumno') {

        $userId = $_SESSION['user_id'];
        $numeroControl = $_SESSION['numero_control'];
        ob_end_clean();
        header('Location: /modulo/alumno/');
        exit;
    } elseif ($userType === 'personal') {

        $userId = $_SESSION['user_id'];
        $personalUsuario = $_SESSION['personal_usuario'];
        ob_end_clean();
        header('Location: /modulo/personal/');
        exit;
    }
} else {

    header('Location: /index.php');
    exit;
}

ob_end_clean();
header('Location: /');
exit;
?>