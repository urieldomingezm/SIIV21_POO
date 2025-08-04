<!-- Modal Registrar Nuevo Pago -->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalRegistrarLabel">
                    <i class="bi bi-plus-circle me-2"></i>Registrar Nuevo Pago
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formRegistrar" class="needs-validation" novalidate>
                    <!-- Información del Alumno -->
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="numero_control" name="numero_control" required pattern="[0-9]{8}">
                                <label for="numero_control">
                                    <i class="bi bi-card-text me-1"></i>Número de Control
                                </label>
                                <div class="invalid-feedback">Por favor ingrese un número de control válido (8 dígitos)</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                <label for="nombre">
                                    <i class="bi bi-person me-1"></i>Nombre(s)
                                </label>
                                <div class="invalid-feedback">Por favor ingrese un nombre válido</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="apellido" name="apellido" required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                <label for="apellido">
                                    <i class="bi bi-person me-1"></i>Apellidos
                                </label>
                                <div class="invalid-feedback">Por favor ingrese apellidos válidos</div>
                            </div>
                        </div>

                        <!-- Información Académica -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-select" id="carrera" name="carrera" required>
                                    <option value="">Seleccione una carrera</option>
                                    <option value="ISC">Ing. en Sistemas Computacionales</option>
                                    <option value="IEM">Ing. Electromecánica</option>
                                    <option value="IGE">Ing. en Gestión Empresarial</option>
                                    <option value="II">Ing. Industrial</option>
                                </select>
                                <label for="carrera">
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
                                </select>
                                <label for="periodo">
                                    <i class="bi bi-calendar3 me-1"></i>Periodo
                                </label>
                                <div class="invalid-feedback">Por favor seleccione un periodo</div>
                            </div>
                        </div>

                        <!-- Información de Pago -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="descuento" name="descuento" min="0" max="100" value="0" required>
                                <label for="descuento">
                                    <i class="bi bi-percent me-1"></i>Descuento (%)
                                </label>
                                <div class="invalid-feedback">El descuento debe estar entre 0 y 100</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="total" readonly style="background-color: #f8f9fa;">
                                <label for="total">
                                    <i class="bi bi-currency-dollar me-1"></i>Total a Pagar
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
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-primary" form="formRegistrar">
                    <i class="bi bi-check-circle me-1"></i>Guardar Pago
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calcular total automáticamente en el modal de registro
    function calcularTotalRegistro() {
        const descuento = parseFloat(document.getElementById('descuento').value) || 0;
        const precioBase = 3200;
        const total = precioBase - (precioBase * descuento / 100);
        document.getElementById('total').value = '$' + total.toFixed(2) + ' MXN';
    }

    // Evento para recalcular cuando cambie el descuento
    const descuentoInput = document.getElementById('descuento');
    if (descuentoInput) {
        descuentoInput.addEventListener('input', calcularTotalRegistro);
        // Calcular total inicial
        calcularTotalRegistro();
    }

    // Manejar envío del formulario de registro
    const formRegistrar = document.getElementById('formRegistrar');
    if (formRegistrar) {
        formRegistrar.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (this.checkValidity()) {
                const formData = new FormData(this);
                
                // Mostrar indicador de carga
                const submitBtn = document.querySelector('button[form="formRegistrar"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Guardando...';
                submitBtn.disabled = true;
                
                fetch('private/procesos/planeacion/gestion_pagos/procesar_registrar.php', {
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
                            bootstrap.Modal.getInstance(document.getElementById('modalRegistrar')).hide();
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
    const modalRegistrar = document.getElementById('modalRegistrar');
    if (modalRegistrar) {
        modalRegistrar.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('formRegistrar');
            if (form) {
                form.reset();
                form.classList.remove('was-validated');
                // Recalcular total después del reset
                calcularTotalRegistro();
            }
            // Limpiar alertas
            const alerts = this.querySelectorAll('.alert:not(.alert-info)');
            alerts.forEach(alert => alert.remove());
        });
    }
});
</script>