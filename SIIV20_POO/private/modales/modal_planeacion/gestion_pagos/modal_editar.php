<!-- Modal Editar Pago -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditarLabel">
                    <i class="bi bi-pencil-square me-2"></i>Editar Pago
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
                                <p class="mb-1"><strong>Nombre:</strong> <span id="editNombreCompleto"></span></p>
                                <p class="mb-1"><strong>Número de Control:</strong> <span id="editNumeroControl"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Carrera:</strong> <span id="editCarrera"></span></p>
                                <p class="mb-1"><strong>Semestre:</strong> <span id="editSemestre"></span></p>
                                <p class="mb-0"><strong>Periodo:</strong> <span id="editPeriodo"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Edición -->
                <form id="formEditar" novalidate>
                    <input type="hidden" name="id" required>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editDescuento" class="form-label">
                                    <i class="bi bi-percent me-1"></i>Descuento (%)
                                </label>
                                <input type="number" 
                                       class="form-control" 
                                       id="editDescuento" 
                                       name="descuento" 
                                       min="0" 
                                       max="100" 
                                       step="1"
                                       required>
                                <div class="form-text">Ingrese el porcentaje de descuento (0-100)</div>
                                <div class="invalid-feedback">
                                    Por favor ingrese un descuento válido entre 0 y 100.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editTotal" class="form-label">
                                    <i class="bi bi-currency-dollar me-1"></i>Total a Pagar
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="editTotal" 
                                       readonly 
                                       style="background-color: #f8f9fa;">
                                <div class="form-text">Total calculado automáticamente</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="checkPagado" 
                                       name="realizado" 
                                       value="1">
                                <label class="form-check-label" for="checkPagado">
                                    <i class="bi bi-check-circle me-1"></i>Marcar como pagado
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Nota:</strong> El precio base de reinscripción es de $3,200.00 MXN. 
                        El total se calcula automáticamente aplicando el descuento especificado.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancelar
                </button>
                <button type="submit" form="formEditar" class="btn btn-warning">
                    <i class="bi bi-check-circle me-1"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para calcular total en el modal de edición
    function calcularTotalEdicion() {
        const descuento = parseFloat(document.getElementById('editDescuento').value) || 0;
        const precioBase = 3200;
        const total = precioBase - (precioBase * descuento / 100);
        document.getElementById('editTotal').value = '$' + total.toFixed(2) + ' MXN';
    }

    // Evento para recalcular cuando cambie el descuento
    const editDescuentoInput = document.getElementById('editDescuento');
    if (editDescuentoInput) {
        editDescuentoInput.addEventListener('input', calcularTotalEdicion);
    }

    // Manejar envío del formulario de edición
    const formEditar = document.getElementById('formEditar');
    if (formEditar) {
        formEditar.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (this.checkValidity()) {
                const formData = new FormData(this);
                
                // Mostrar indicador de carga
                const submitBtn = document.querySelector('button[form="formEditar"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Guardando...';
                submitBtn.disabled = true;
                
                fetch('private/procesos/planeacion/gestion_pagos/procesar_editar.php', {
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
                        document.querySelector('.modal-body').insertBefore(alertDiv, document.querySelector('.modal-body').firstChild);
                        
                        // Cerrar modal y recargar después de 1.5 segundos
                        setTimeout(() => {
                            bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();
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
                        document.querySelector('.modal-body').insertBefore(alertDiv, document.querySelector('.modal-body').firstChild);
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
                    document.querySelector('.modal-body').insertBefore(alertDiv, document.querySelector('.modal-body').firstChild);
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
    const modalEditar = document.getElementById('modalEditar');
    if (modalEditar) {
        modalEditar.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('formEditar');
            if (form) {
                form.reset();
                form.classList.remove('was-validated');
            }
            // Limpiar alertas
            const alerts = this.querySelectorAll('.alert');
            alerts.forEach(alert => alert.remove());
        });
    }
});
</script>