<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(MENU_PATH . 'menu_aluimno.php'); 

require_once(TEMPLATES_PATH . 'header.php');
?>

<?php

if (isset($_GET['page'])) {

    if ($_GET['page'] == 'Inicio') {
        include 'ASPB.php';
    } elseif ($_GET['page'] == 'Datos socioeconomicos') {
        include 'ASSO.php';
    } elseif ($_GET['page'] == 'Fichas de pagos') {
        include 'ASFP.php';
    } elseif ($_GET['page'] == 'Solicitud de examen') {
        include 'ASSE.php';

        include 'GVP.php';
    } else {
        echo "<h1>Página no encontrada</h1>";
        echo "<p>Redirigiendo a la página principal...</p>";
        header("refresh:3;url=index.php");
        exit();
    }
} else {
    include 'ALHO.php';
}
?>



<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>
            
           