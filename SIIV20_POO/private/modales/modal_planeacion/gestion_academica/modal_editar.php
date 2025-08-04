<!-- Modal Editar Información Académica -->
<div class="modal fade" id="modalEditarAcademica" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditarLabel">
                    <i class="bi bi-pencil-square me-2"></i>Editar Información Académica
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información del Alumno (Solo lectura) -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Información del Alumno</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Número de Control:</strong> <span id="editNumeroControl" class="text-primary fw-bold"></span></p>
                                <p class="mb-0"><strong>Nombre:</strong> <span id="editNombreAlumno"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Registro ID:</strong> <span id="editRegistroId" class="text-info"></span></p>
                                <p class="mb-0"><strong>Estado:</strong> <span class="badge bg-success">Activo</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Edición -->
                <form id="formEditarAcademica" class="needs-validation" novalidate>
                    <input type="hidden" name="id" id="editId">
                    
                    <div class="row g-3">
                        <!-- Carrera -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-select" id="editCarrera" name="carrera_id" required>
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
                                <label for="editCarrera">
                                    <i class="bi bi-mortarboard me-1"></i>Carrera
                                </label>
                                <div class="invalid-feedback">Por favor seleccione una carrera</div>
                            </div>
                        </div>

                        <!-- Semestre -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="editSemestre" name="semestre" required>
                                    <option value="">Seleccione el semestre</option>
                                    <?php for($i=1; $i<=12; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?>° Semestre</option>
                                    <?php endfor; ?>
                                </select>
                                <label for="editSemestre">
                                    <i class="bi bi-calendar-event me-1"></i>Semestre
                                </label>
                                <div class="invalid-feedback">Por favor seleccione un semestre</div>
                            </div>
                        </div>

                        <!-- Periodo -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="editPeriodo" name="periodo" required>
                                    <option value="">Seleccione el periodo</option>
                                    <option value="ENE-JUN">Enero - Junio</option>
                                    <option value="AGO-DIC">Agosto - Diciembre</option>
                                    <option value="ENE-MAY">Enero - Mayo</option>
                                    <option value="SEP-DIC">Septiembre - Diciembre</option>
                                    <option value="FEB-JUN">Febrero - Junio</option>
                                    <option value="JUL-NOV">Julio - Noviembre</option>
                                </select>
                                <label for="editPeriodo">
                                    <i class="bi bi-calendar3 me-1"></i>Periodo
                                </label>
                                <div class="invalid-feedback">Por favor seleccione un periodo</div>
                            </div>
                        </div>

                        <!-- Promedio -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="editPromedio" name="promedio" min="0" max="100" step="0.01" required>
                                <label for="editPromedio">
                                    <i class="bi bi-award me-1"></i>Promedio
                                </label>
                                <div class="invalid-feedback">El promedio debe estar entre 0 y 100</div>
                                <div class="form-text">Ingrese el promedio con hasta 2 decimales</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Nota:</strong> Los cambios se aplicarán inmediatamente al registro académico del alumno.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancelar
                </button>
                <button type="submit" form="formEditarAcademica" class="btn btn-warning">
                    <i class="bi bi-check-circle me-1"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar envío del formulario de edición académica
    const formEditarAcademica = document.getElementById('formEditarAcademica');
    if (formEditarAcademica) {
        formEditarAcademica.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (this.checkValidity()) {
                const formData = new FormData(this);
                
                // Mostrar indicador de carga
                const submitBtn = document.querySelector('button[form="formEditarAcademica"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Guardando...';
                submitBtn.disabled = true;
                
                fetch('private/procesos/planeacion/gestion_academicos/procesar_editar.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar mensaje de éxito
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            <i class="bi bi-check-circle me-2"></i>${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.querySelector('#modalEditarAcademica .modal-body').insertBefore(alertDiv, document.querySelector('#modalEditarAcademica .modal-body').firstChild);
                        
                        // Cerrar modal y recargar después de 1.5 segundos
                        setTimeout(() => {
                            bootstrap.Modal.getInstance(document.getElementById('modalEditarAcademica')).hide();
                            location.reload();
                        }, 1500);
                    } else {
                        // Mostrar mensaje de error
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            <i class="bi bi-exclamation-triangle me-2"></i>Error: ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.querySelector('#modalEditarAcademica .modal-body').insertBefore(alertDiv, document.querySelector('#modalEditarAcademica .modal-body').firstChild);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="bi bi-exclamation-triangle me-2"></i>Error al procesar la solicitud
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.querySelector('#modalEditarAcademica .modal-body').insertBefore(alertDiv, document.querySelector('#modalEditarAcademica .modal-body').firstChild);
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
    const modalEditarAcademica = document.getElementById('modalEditarAcademica');
    if (modalEditarAcademica) {
        modalEditarAcademica.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('formEditarAcademica');
            if (form) {
                form.reset();
                form.classList.remove('was-validated');
            }
            
            // Limpiar información del alumno
            document.getElementById('editNumeroControl').textContent = '';
            document.getElementById('editNombreAlumno').textContent = '';
            document.getElementById('editRegistroId').textContent = '';
            
            // Limpiar alertas
            const alerts = this.querySelectorAll('.alert:not(.alert-info)');
            alerts.forEach(alert => alert.remove());
        });
    }
});
</script>