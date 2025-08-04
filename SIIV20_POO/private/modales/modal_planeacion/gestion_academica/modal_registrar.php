<!-- Modal Registrar Información Académica -->
<div class="modal fade" id="modalRegistrarAcademica" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalRegistrarLabel">
                    <i class="bi bi-plus-circle me-2"></i>Registrar Nueva Información Académica
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formRegistrarAcademica" class="needs-validation" novalidate>
                    <!-- Búsqueda por Número de Control -->
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="alert alert-info" role="alert">
                                <h6 class="mb-2"><i class="bi bi-search me-2"></i>Búsqueda de Alumno</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="buscarNumeroControl" placeholder="Ingrese número de control del alumno" pattern="[0-9]{8}">
                                    <button class="btn btn-outline-primary" type="button" id="btnBuscarAlumno">
                                        <i class="bi bi-search"></i> Buscar
                                    </button>
                                </div>
                                <small class="text-muted">Al buscar se llenarán automáticamente los datos del alumno</small>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Alumno -->
                    <div class="row g-3">
                        <!-- Campo oculto para almacenar el ID del alumno encontrado -->
                        <input type="hidden" id="alumno_id" name="alumno_id" required>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="numeroControlMostrar" readonly style="background-color: #f8f9fa;">
                                <label for="numeroControlMostrar">
                                    <i class="bi bi-card-text me-1"></i>Número de Control
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombreAlumnoMostrar" readonly style="background-color: #f8f9fa;">
                                <label for="nombreAlumnoMostrar">
                                    <i class="bi bi-person me-1"></i>Nombre del Alumno
                                </label>
                            </div>
                        </div>
                        
                        <!-- Información Académica -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-select" id="carrera_id" name="carrera_id" required>
                                    <option value="">Seleccione una carrera</option>
                                    <option value="ISC">Ing. en Sistemas Computacionales</option>
                                    <option value="IEM">Ing. Electromecánica</option>
                                    <option value="IGE">Ing. en Gestión Empresarial</option>
                                    <option value="II">Ing. Industrial</option>
                                    <option value="IC">Ing. Civil</option>
                                    <option value="IM">Ing. Mecánica</option>
                                    <option value="IE">Ing. Electrónica</option>
                                    <option value="LA">Lic. en Administración</option>
                                    <option value="LC">Lic. en Contaduría</option>
                                </select>
                                <label for="carrera_id">
                                    <i class="bi bi-mortarboard me-1"></i>Carrera
                                </label>
                                <div class="invalid-feedback">Por favor seleccione una carrera</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="semestre" name="semestre" required>
                                    <option value="">Seleccione el semestre</option>
                                    <?php for($i=1; $i<=12; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?>° Semestre</option>
                                    <?php endfor; ?>
                                </select>
                                <label for="semestre">
                                    <i class="bi bi-calendar-event me-1"></i>Semestre
                                </label>
                                <div class="invalid-feedback">Por favor seleccione un semestre</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="periodo" name="periodo" required>
                                    <option value="">Seleccione el periodo</option>
                                    <option value="ENE-JUN">Enero - Junio</option>
                                    <option value="AGO-DIC">Agosto - Diciembre</option>
                                    <option value="ENE-MAY">Enero - Mayo</option>
                                    <option value="SEP-DIC">Septiembre - Diciembre</option>
                                    <option value="FEB-JUN">Febrero - Junio</option>
                                    <option value="JUL-NOV">Julio - Noviembre</option>
                                </select>
                                <label for="periodo">
                                    <i class="bi bi-calendar3 me-1"></i>Periodo
                                </label>
                                <div class="invalid-feedback">Por favor seleccione un periodo</div>
                            </div>
                        </div>

                        <!-- Promedio -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="promedio" name="promedio" min="0" max="100" step="0.01" required>
                                <label for="promedio">
                                    <i class="bi bi-award me-1"></i>Promedio
                                </label>
                                <div class="invalid-feedback">El promedio debe estar entre 0 y 100</div>
                                <div class="form-text">Ingrese el promedio con hasta 2 decimales</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Nota:</strong> Asegúrese de que el alumno esté registrado en el sistema antes de crear su información académica.
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-primary" form="formRegistrarAcademica">
                    <i class="bi bi-check-circle me-1"></i>Registrar Información
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función de búsqueda de alumno
    const btnBuscarAlumno = document.getElementById('btnBuscarAlumno');
    const inputNumeroControl = document.getElementById('buscarNumeroControl');
    
    if (btnBuscarAlumno && inputNumeroControl) {
        btnBuscarAlumno.addEventListener('click', function() {
            const numeroControl = inputNumeroControl.value.trim();
            if (numeroControl) {
                buscarAlumnoPorNumeroControl(numeroControl);
            } else {
                mostrarAlertaAcademica('Por favor ingrese un número de control', 'warning');
            }
        });
        
        // Buscar al presionar Enter
        inputNumeroControl.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                btnBuscarAlumno.click();
            }
        });
    }

    // Manejar envío del formulario de registro académico
    const formRegistrarAcademica = document.getElementById('formRegistrarAcademica');
    if (formRegistrarAcademica) {
        formRegistrarAcademica.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (this.checkValidity()) {
                const formData = new FormData(this);
                
                // Mostrar indicador de carga
                const submitBtn = document.querySelector('button[form="formRegistrarAcademica"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Registrando...';
                submitBtn.disabled = true;
                
                fetch('private/procesos/planeacion/gestion_academicos/procesar_registrar.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar mensaje de éxito
                        mostrarAlertaAcademica(data.message, 'success');
                        
                        // Cerrar modal y recargar después de 1.5 segundos
                        setTimeout(() => {
                            bootstrap.Modal.getInstance(document.getElementById('modalRegistrarAcademica')).hide();
                            location.reload();
                        }, 1500);
                    } else {
                        // Mostrar mensaje de error
                        mostrarAlertaAcademica('Error: ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarAlertaAcademica('Error al procesar la solicitud', 'danger');
                })
                .finally(() => {
                    // Restaurar botón
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            }
            
            this.classList.add('was-validated');
        });
    }

    // Limpiar formulario cuando se cierre el modal
    const modalRegistrarAcademica = document.getElementById('modalRegistrarAcademica');
    if (modalRegistrarAcademica) {
        modalRegistrarAcademica.addEventListener('hidden.bs.modal', function() {
            limpiarFormularioAcademico();
        });
    }
});

function buscarAlumnoPorNumeroControl(numeroControl) {
    // Verificar que el array de alumnos esté disponible
    if (typeof window.alumnos === 'undefined' || !Array.isArray(window.alumnos)) {
        mostrarAlertaAcademica('Error: Los datos de alumnos no están disponibles', 'danger');
        return;
    }
    
    // Buscar en el array de alumnos
    const alumnoEncontrado = window.alumnos.find(alumno => {
        const numeroControlAlumno = String(alumno.alumno_numero_control).trim();
        const numeroControlBusqueda = String(numeroControl).trim();
        return numeroControlAlumno === numeroControlBusqueda;
    });
    
    if (alumnoEncontrado) {
        // Llenar los campos con los datos encontrados
        document.getElementById('alumno_id').value = alumnoEncontrado.alumno_id;
        document.getElementById('numeroControlMostrar').value = alumnoEncontrado.alumno_numero_control;
        document.getElementById('nombreAlumnoMostrar').value = alumnoEncontrado.nombre_completo;
        
        // Mostrar mensaje de éxito
        mostrarAlertaAcademica(`¡Alumno encontrado! ${alumnoEncontrado.nombre_completo}`, 'success');
        
    } else {
        // Limpiar campos si no se encuentra
        document.getElementById('alumno_id').value = '';
        document.getElementById('numeroControlMostrar').value = '';
        document.getElementById('nombreAlumnoMostrar').value = '';
        
        mostrarAlertaAcademica('No se encontró un alumno con ese número de control', 'danger');
    }
}

function limpiarFormularioAcademico() {
    document.getElementById('buscarNumeroControl').value = '';
    document.getElementById('alumno_id').value = '';
    document.getElementById('numeroControlMostrar').value = '';
    document.getElementById('nombreAlumnoMostrar').value = '';
    document.getElementById('carrera_id').value = '';
    document.getElementById('semestre').value = '';
    document.getElementById('periodo').value = '';
    document.getElementById('promedio').value = '';
    
    // Remover validaciones
    const form = document.getElementById('formRegistrarAcademica');
    if (form) {
        form.classList.remove('was-validated');
    }
    
    // Limpiar alertas
    const alerts = document.querySelectorAll('#modalRegistrarAcademica .alert:not(.alert-info)');
    alerts.forEach(alert => alert.remove());
}

function mostrarAlertaAcademica(mensaje, tipo) {
    // Remover alertas existentes
    const alertasExistentes = document.querySelectorAll('#modalRegistrarAcademica .alert-success, #modalRegistrarAcademica .alert-danger, #modalRegistrarAcademica .alert-warning');
    alertasExistentes.forEach(alerta => alerta.remove());
    
    // Crear nueva alerta
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show mt-2`;
    alertDiv.innerHTML = `
        <i class="bi bi-${tipo === 'success' ? 'check-circle' : tipo === 'warning' ? 'exclamation-triangle' : 'exclamation-circle'} me-2"></i>
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const searchAlert = document.querySelector('#modalRegistrarAcademica .alert-info');
    if (searchAlert && searchAlert.parentNode) {
        searchAlert.parentNode.insertBefore(alertDiv, searchAlert.nextSibling);
    }
    
    // Remover el mensaje después de 5 segundos
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>