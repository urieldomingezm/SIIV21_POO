<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(MENU_PATH . 'menu_personal.php'); 

require_once(TEMPLATES_PATH . 'header.php');
?>

<!-- Content for personal panel -->
<div class="container mt-4">
    <h2>Panel de Personal</h2>
    <p>Bienvenido, Usuario: <?php echo htmlspecialchars($_SESSION['numero_control']); ?></p>
    <!-- Add your personal panel content here -->
</div>

<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>