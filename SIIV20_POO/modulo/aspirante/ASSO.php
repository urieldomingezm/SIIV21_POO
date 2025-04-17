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
                                <i class="bi bi-save me-2"></i>Guardar y Continuar
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
            <div id="preparatoriaCollapse" class="accordion-collapse collapse" aria-labelledby="preparatoriaHeader">
                <div class="accordion-body">
                    <form id="preparatoriaForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_preparatoria_procedencia.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Guardar y Continuar
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
            <div id="domicilioCollapse" class="accordion-collapse collapse" aria-labelledby="domicilioHeader">
                <div class="accordion-body">
                    <form id="domicilioForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_domicilio.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Guardar y Continuar
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
            <div id="padresCollapse" class="accordion-collapse collapse" aria-labelledby="padresHeader">
                <div class="accordion-body">
                    <form id="padresForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_padres.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Guardar y Continuar
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
            <div id="socioeconomicoCollapse" class="accordion-collapse collapse" aria-labelledby="socioeconomicoHeader">
                <div class="accordion-body">
                    <form id="socioeconomicoForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_socioeconomicos.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Guardar y Continuar
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
            <div id="emergenciaCollapse" class="accordion-collapse collapse" aria-labelledby="emergenciaHeader">
                <div class="accordion-body">
                    <form id="emergenciaForm" class="step-form needs-validation" novalidate>
                        <?php require_once(DATOS_PATH . 'datos_emergencias.php'); ?>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Finalizar Registro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.step-form');
    const progressBar = document.querySelector('.progress-bar');
    const accordionItems = document.querySelectorAll('.accordion-item');
    const totalSteps = forms.length;
    let completedSteps = 0;

    // Check for completed steps in localStorage
    const checkCompletedSteps = () => {
        forms.forEach((form, index) => {
            const isCompleted = localStorage.getItem(`step_${index}_completed`);
            if (isCompleted === 'true') {
                completedSteps++;
                markStepCompleted(accordionItems[index]);
            }
        });
        updateProgress();
    };

    // Update progress bar
    const updateProgress = () => {
        const progress = (completedSteps / totalSteps) * 100;
        progressBar.style.width = `${progress}%`;
        progressBar.setAttribute('aria-valuenow', progress);
    };

    // Mark step as completed
    const markStepCompleted = (accordionItem) => {
        const button = accordionItem.querySelector('.accordion-button');
        const icon = button.querySelector('.step-icon');
        button.classList.add('completed');
        icon.classList.remove('bi-circle');
        icon.classList.add('bi-check-circle-fill');
        icon.style.color = '#198754';
    };

    // Move to next section
    const moveToNextSection = (currentAccordionItem) => {
        const nextAccordionItem = currentAccordionItem.nextElementSibling;
        if (nextAccordionItem) {
            const nextCollapse = nextAccordionItem.querySelector('.accordion-collapse');
            const currentCollapse = currentAccordionItem.querySelector('.accordion-collapse');
            
            new bootstrap.Collapse(currentCollapse).hide();
            new bootstrap.Collapse(nextCollapse).show();
        }
    };

    // Handle form submissions
    forms.forEach((form, index) => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);
            formData.append('form_type', form.id);
            const accordionItem = form.closest('.accordion-item');
            
            fetch('guardar_datos_socioeconomicos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.setItem(`step_${index}_completed`, 'true');
                    completedSteps++;
                    updateProgress();
                    markStepCompleted(accordionItem);
                    
                    if (index < totalSteps - 1) {
                        moveToNextSection(accordionItem);
                    }
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: data.message || 'Información guardada correctamente',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    if (index === totalSteps - 1) {
                        setTimeout(() => {
                            window.location.href = 'dashboard.php';
                        }, 1500);
                    }
                } else {
                    throw new Error(data.message || 'Error al guardar');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message
                });
            });
        });
    });

    // Check completed steps on page load
    checkCompletedSteps();
});
</script>

<style>
.accordion-button.completed {
    background-color: #f8f9fa;
}
.step-icon {
    font-size: 1.2rem;
    transition: all 0.3s ease;
}
.progress {
    height: 10px;
    border-radius: 5px;
}
.progress-bar {
    transition: width 0.5s ease-in-out;
    background-color: #198754;
}
.accordion-button.completed .step-icon {
    color: #198754;
}
</style>