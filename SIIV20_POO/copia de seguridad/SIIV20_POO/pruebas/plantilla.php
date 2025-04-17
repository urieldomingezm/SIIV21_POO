<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');
require_once(MENU_PATH . 'menu_personal.php');
?>

<section class="container mt-4">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <a href="crud.php" class="btn btn-primary btn-lg">
                <i class="bi bi-table"></i> Acceder al CRUD
            </a>
            <div class="mt-2 text-muted">
                <small>Sistema de gestión para Crear, Leer, Actualizar y Eliminar registros de prueba</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Prueba de Contenido Responsivo</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sección de Prueba</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <div class="alert alert-info">
                        <p>Esta es una sección de prueba para verificar el comportamiento responsivo del contenido. El texto se ajustará automáticamente según el tamaño de la pantalla.</p>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6>Columna 1</h6>
                                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6>Columna 2</h6>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>