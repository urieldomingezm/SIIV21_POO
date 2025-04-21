<div class="container mt-4">
    <h2 class="text-center mb-4">DATOS SOCIOECONOMICOS</h2>

    <!-- Progress bar -->
    <div class="progress mb-4">
        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="accordion" id="aspiranteAccordion">
        <!-- Datos Generales Section -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="datosGeneralesHeader">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#datosGeneralesCollapse" aria-expanded="false">
                    <i class="bi bi-circle me-2 step-icon"></i> Datos Generales del Aspirante
                </button>
            </h2>
            <div id="datosGeneralesCollapse" class="accordion-collapse collapse" aria-labelledby="datosGeneralesHeader">
                <div class="accordion-body">
                    <form id="datosGeneralesForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_generales_aspirante.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                </i>Guardar y Continuar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preparatoria Section -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="preparatoriaHeader">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#preparatoriaCollapse" aria-expanded="false">
                    <i class="bi bi-circle me-2 step-icon"></i> Preparatoria de Procedencia
                </button>
            </h2>
            <div id="preparatoriaCollapse" class="accordion-collapse collapse" aria-labelledby="preparatoriaHeader" data-bs-parent="#aspiranteAccordion">
                <div class="accordion-body">
                    <form id="preparatoriaForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_preparatoria_procedencia.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                </i>Guardar y Continuar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Domicilio Section -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="domicilioHeader">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#domicilioCollapse" aria-expanded="false">
                    <i class="bi bi-circle me-2 step-icon"></i> Domicilio Actual
                </button>
            </h2>
            <div id="domicilioCollapse" class="accordion-collapse collapse" aria-labelledby="domicilioHeader" data-bs-parent="#aspiranteAccordion">
                <div class="accordion-body">
                    <form id="domicilioForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_domicilio.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                </i>Guardar y Continuar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Padres Section -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="padresHeader">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#padresCollapse" aria-expanded="false">
                    <i class="bi bi-circle me-2 step-icon"></i> Datos de los Padres
                </button>
            </h2>
            <div id="padresCollapse" class="accordion-collapse collapse" aria-labelledby="padresHeader" data-bs-parent="#aspiranteAccordion">
                <div class="accordion-body">
                    <form id="padresForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_padres.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                </i>Guardar y Continuar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Socioeconomico Section -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="socioeconomicoHeader">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#socioeconomicoCollapse" aria-expanded="false">
                    <i class="bi bi-circle me-2 step-icon"></i> Información Socioeconómica
                </button>
            </h2>
            <div id="socioeconomicoCollapse" class="accordion-collapse collapse" aria-labelledby="socioeconomicoHeader" data-bs-parent="#aspiranteAccordion">
                <div class="accordion-body">
                    <form id="socioeconomicoForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_socioeconomicos.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                </i>Guardar y Continuar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Emergencia Section -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="emergenciaHeader">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emergenciaCollapse" aria-expanded="false">
                    <i class="bi bi-circle me-2 step-icon"></i> Datos de Emergencia
                </button>
            </h2>
            <div id="emergenciaCollapse" class="accordion-collapse collapse" aria-labelledby="emergenciaHeader" data-bs-parent="#aspiranteAccordion">
                <div class="accordion-body">
                    <form id="emergenciaForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_emergencias.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                </i>Finalizar Registro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>