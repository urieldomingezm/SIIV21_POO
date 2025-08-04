<!-- Modal Eliminar Información Académica -->
<div class="modal fade" id="modalEliminarAcademica" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalEliminarLabel">
                    <i class="bi bi-trash3 me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>¡Atención!</strong> Esta acción no se puede deshacer. 
                    ¿Está seguro de que desea eliminar este registro académico?
                </div>

                <!-- Información del registro a eliminar -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información del Registro</h6>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="eliminarId">
                        
                        <!-- Información destacada del número de control -->
                        <div class="alert alert-primary text-center mb-3">
                            <h6 class="mb-1"><i class="bi bi-person-badge me-2"></i>Número de Control:</h6>
                            <h4 class="mb-0 fw-bold" id="eliminarNumero"></h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="bi bi-person me-1"></i>Alumno:</strong> 
                                    <span id="eliminarNombre" class="text-primary"></span>
                                </p>
                                <p class="mb-2">
                                    <strong><i class="bi bi-mortarboard me-1"></i>Carrera:</strong> 
                                    <span id="eliminarCarrera"></span>
                                </p>
                                <p class="mb-0">
                                    <strong><i class="bi bi-calendar-event me-1"></i>Semestre:</strong> 
                                    <span id="eliminarSemestre"></span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="bi bi-calendar3 me-1"></i>Periodo:</strong> 
                                    <span id="eliminarPeriodo"></span>
                                </p>
                                <p class="mb-2">
                                    <strong><i class="bi bi-award me-1"></i>Promedio:</strong> 
                                    <span id="eliminarPromedio" class="fw-bold text-success"></span>
                                </p>
                                <p class="mb-0">
                                    <strong><i class="bi bi-hash me-1"></i>ID Registro:</strong> 
                                    <span id="eliminarRegistroId" class="text-muted"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Opciones de eliminación -->
                <div class="mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoEliminacionAcademica" id="eliminacionCompletaAcademica" value="completa" checked>
                        <label class="form-check-label" for="eliminacionCompletaAcademica">
                            <strong>Eliminación Completa</strong>
                            <small class="d-block text-muted">El registro se eliminará permanentemente de la base de datos</small>
                        </label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="tipoEliminacionAcademica" id="eliminacionSuaveAcademica" value="suave">
                        <label class="form-check-label" for="eliminacionSuaveAcademica">
                            <strong>Eliminación Suave</strong>
                            <small class="d-block text-muted">El registro se marcará como eliminado pero se conservará en la base de datos</small>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminarAcademica">
                    <i class="bi bi-trash3 me-1"></i>Confirmar Eliminación
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmar eliminación académica
    const btnConfirmarEliminarAcademica = document.getElementById('btnConfirmarEliminarAcademica');
    if (btnConfirmarEliminarAcademica) {
        btnConfirmarEliminarAcademica.addEventListener('click', function() {
            const eliminarIdInput = document.getElementById('eliminarId');
            if (!eliminarIdInput) return;
            
            const id = eliminarIdInput.value;
            const tipoEliminacion = document.querySelector('input[name="tipoEliminacionAcademica"]:checked').value;
            
            if (!id) {
                alert('Error: No se pudo obtener el ID del registro');
                return;
            }

            // Mostrar indicador de carga
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Eliminando...';
            this.disabled = true;
            
            const formData = new FormData();
            formData.append('id', id);
            formData.append('tipo', tipoEliminacion);
            
            fetch('private/procesos/planeacion/gestion_academicos/procesar_eliminar.php', {
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
                    document.querySelector('#modalEliminarAcademica .modal-body').insertBefore(alertDiv, document.querySelector('#modalEliminarAcademica .modal-body').firstChild);
                    
                    // Cerrar modal y recargar después de 1.5 segundos
                    setTimeout(() => {
                        bootstrap.Modal.getInstance(document.getElementById('modalEliminarAcademica')).hide();
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
                    document.querySelector('#modalEliminarAcademica .modal-body').insertBefore(alertDiv, document.querySelector('#modalEliminarAcademica .modal-body').firstChild);
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
                document.querySelector('#modalEliminarAcademica .modal-body').insertBefore(alertDiv, document.querySelector('#modalEliminarAcademica .modal-body').firstChild);
            })
            .finally(() => {
                // Restaurar botón
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    }

    // Limpiar modal cuando se cierre
    const modalEliminarAcademica = document.getElementById('modalEliminarAcademica');
    if (modalEliminarAcademica) {
        modalEliminarAcademica.addEventListener('hidden.bs.modal', function() {
            // Limpiar campos
            const campos = ['eliminarId', 'eliminarNumero', 'eliminarNombre', 'eliminarCarrera', 
                           'eliminarSemestre', 'eliminarPeriodo', 'eliminarPromedio', 'eliminarRegistroId'];
            
            campos.forEach(campo => {
                const elemento = document.getElementById(campo);
                if (elemento) {
                    if (elemento.tagName === 'INPUT') {
                        elemento.value = '';
                    } else {
                        elemento.textContent = '';
                    }
                }
            });
            
            // Resetear radio buttons
            const eliminacionCompleta = document.getElementById('eliminacionCompletaAcademica');
            if (eliminacionCompleta) {
                eliminacionCompleta.checked = true;
            }
            
            // Limpiar alertas
            const alerts = this.querySelectorAll('.alert:not(.alert-warning)');
            alerts.forEach(alert => alert.remove());
        });
    }
});
</script>