<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(MENU_PATH . 'menu_aspirante.php'); 

require_once(TEMPLATES_PATH . 'header.php');
?>

<!-- Content for aspirante panel -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded-top shadow-sm">
                <h2 class="text-center display-5 fw-bold mb-3">Bienvenido(a) Aspirante</h2>
                <p class="text-end mb-0 fw-light">Usuario: <?php echo htmlspecialchars($_SESSION['aspirante_curp']); ?></p>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="bg-light p-4 rounded mb-4">
                        <h4 class="text-primary fw-bold">Recomendaciones</h4>
                        <h5 class="text-muted mb-4">Saludos:</h5>
                        
                        <p class="lead">El Instituto Tecnológico de Cd. Victoria te da la más cordial bienvenida. En este momento eres <span class="badge bg-primary">ASPIRANTE</span> a ingresar a éste INSTITUTO.</p>

                        <div class="bg-white p-3 rounded shadow-sm">
                            <p>Antes de comenzar a llenar la solicitud, te recomendamos que leas cuidadosamente los siguientes requisitos, te ayudarán en el proceso de registro de la solicitud. Es importante detenerse a leer estas recomendaciones antes de continuar, lo cual te facilitará el trabajo de llenado e impresión de la solicitud. Te sugerimos te pongas cómodo y dispuesto a capturar esta solicitud, el tiempo estimado de captura será de aproximadamente 30 minutos.</p>
                        </div>

                        <div class="mt-5">
                            <h5 class="text-primary fw-bold mb-4">El proceso de llenado de ésta solicitud consta de cuatro pasos:</h5>
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-3">
                                    <div class="card h-100 border-primary">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">Paso 1</h5>
                                            <p class="card-text">Llenar la solicitud de ficha de examen de selección con datos generales y escolares.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="card h-100 border-success">
                                        <div class="card-body">
                                            <h5 class="card-title text-success">Paso 2</h5>
                                            <p class="card-text">Llenar el formulario de datos socioeconómicos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="card h-100 border-info">
                                        <div class="card-body">
                                            <h5 class="card-title text-info">Paso 3</h5>
                                            <p class="card-text">Imprimir la solicitud desde FORMATOS IMPRESOS.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="card h-100 border-warning">
                                        <div class="card-body">
                                            <h5 class="card-title text-warning">Paso 4</h5>
                                            <p class="card-text">Generar ficha de depósito para pago en banco.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-5 shadow-sm">
                            <h5 class="alert-heading fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>¡IMPORTANTE!</h5>
                            <p class="mb-0">UNA VEZ CAPTURADA TU INFORMACIÓN SIGUE EL PROCEDIMIENTO IMPRESO DE TU SOLICITUD DE ASPIRANTE</p>
                        </div>

                        <div class="mt-5">
                            <h5 class="text-primary fw-bold">Requisitos para capturar esta solicitud:</h5>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-person-fill me-2"></i>Apellido y nombre(s)</div>
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-card-text me-2"></i>CURP completa</div>
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-calendar-date me-2"></i>Fecha de nacimiento</div>
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-flag-fill me-2"></i>Nacionalidad, sexo</div>
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-book-fill me-2"></i>Opciones de carrera</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="list-group">
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-building me-2"></i>Preparatoria de procedencia</div>
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-star-fill me-2"></i>Promedio general</div>
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-geo-alt-fill me-2"></i>Domicilio, estado civil</div>
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-pin-map-fill me-2"></i>Zona de procedencia</div>
                                        <div class="list-group-item list-group-item-action"><i class="bi bi-people-fill me-2"></i>Datos de padres</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-5 shadow-sm">
                            <h5 class="alert-heading fw-bold"><i class="bi bi-info-circle-fill me-2"></i>NOTA:</h5>
                            <p class="mb-0">DEBERAS LLENAR EL MÁXIMO DE DATOS QUE SE TE PIDEN, EL PROGRAMA NO TE DEJARÁ SEGUIR SI NO LO HACES ASÍ.</p>
                        </div>

                        <div class="card bg-light mt-5">
                            <div class="card-body">
                                <h5 class="card-title text-primary fw-bold">Necesidades técnicas</h5>
                                <p class="card-text">Si ya estás aquí es porque estás frente a una PC con conexión a internet, ahora sólo basta saber si tienes el programa adecuado para imprimir ésta solicitud.</p>
                                <p class="card-text">Al término de llenado de tu solicitud está la opción de IMPRIMIR solicitud, deberás seleccionar esta opción e intentar imprimir los datos capturados.</p>
                                <p class="card-text mb-0">Cuando ya termines puedes CERRAR SESION.</p>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <p class="lead mb-0">Bueno ahora ponte cómodo y a capturar la solicitud.</p>
                            <p class="text-muted">Saludos nuevamente y gracias por tu comprensión</p>
                            
                            <!-- Added Continue Button -->
                            <div class="mt-4">
                                <a href="solicitud.php" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-arrow-right-circle-fill me-2"></i>Continuar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>