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
                                <label for="numero_control">Número de Control</label>
                                <div class="invalid-feedback">Por favor ingrese un número de control válido (8 dígitos)</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                <label for="nombre">Nombre(s)</label>
                                <div class="invalid-feedback">Por favor ingrese un nombre válido</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="apellido" name="apellido" required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                <label for="apellido">Apellidos</label>
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
                                <label for="carrera">Carrera</label>
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
                                <label for="semestre">Semestre</label>
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
                                <label for="periodo">Periodo</label>
                                <div class="invalid-feedback">Por favor seleccione un periodo</div>
                            </div>
                        </div>

                        <!-- Información de Pago -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="descuento" name="descuento" min="0" max="100" value="0" required>
                                <label for="descuento">Descuento (%)</label>
                                <div class="invalid-feedback">El descuento debe estar entre 0 y 100</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="total" readonly>
                                <label for="total">Total a Pagar</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-primary" form="formRegistrar">
                    <i class="bi bi-save me-2"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>