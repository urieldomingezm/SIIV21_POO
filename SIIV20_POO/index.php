<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');
require_once(LOGIN_PATH. 'proceso_login_registro.php');
require_once(TEMPLATES_PATH . 'header.php');
?>

<!-- Main login section -->
<section class="accordion-demo">
    <div class="container mt-1">
        <br>

                <!-- Add Testing Environment Button -->
                <div class="text-center mb-4">
            <a href="/pruebas/plantilla.php" class="btn btn-info">
                <i class="bi bi-bug"></i> Ambiente de Pruebas
            </a>
        </div>

        <h3 class="text-center">INICIO DE SESIÓN GENERAL</h3>

        <!-- Navigation tabs -->
        <div class="tabs" role="tablist">
            <dd data-target="#Aspirantes" role="tab">
                <a href="#" style="color: black;">ASPIRANTES</a>
            </dd>
            <dd data-target="#Alumnos" role="tab">
                <a href="#" style="color: black;">ALUMNOS</a>
            </dd>
            <dd data-target="#Personal" role="tab">
                <a href="#" style="color: black;">PERSONAL</a>
            </dd>
        </div>

        <!-- Tab content sections -->
        <div class="tabs-content mt-3">
            <?php
            $sections = ['aspirante', 'alumno', 'personal'];
            foreach ($sections as $section) {
                require_once(CUSTOM_INDEX_LOGIN . "seccion_$section.php");
            }
            ?>
        </div>
    </div>
</section>

<!-- Registration Modal -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroModalLabel">Registro de Aspirante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modal-body-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- External Resources -->
<style>
    <?php require_once(CUSTOM_INDEX_LOGIN . 'style.css'); ?>
</style>
<script>
    <?php require_once(CUSTOM_INDEX_LOGIN . 'script.js'); ?>
</script>

<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>