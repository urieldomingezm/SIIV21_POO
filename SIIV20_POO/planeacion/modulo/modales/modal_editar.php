<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="modalEditarLabel">
                    <i class="bi bi-pencil-square me-2"></i>Editar Pago
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditar" class="needs-validation" novalidate>
                    <input type="hidden" name="id">
                    
                    <div class="row g-3">
                        <!-- Información del Alumno -->
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Nombre:</strong> <span id="editNombreCompleto"></span><br>
                                        <strong>No. Control:</strong> <span id="editNumeroControl"></span><br>
                                        <strong>Carrera:</strong> <span id="editCarrera"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Semestre:</strong> <span id="editSemestre"></span><br>
                                        <strong>Periodo:</strong> <span id="editPeriodo"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Descuento -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="editDescuento" name="descuento" min="0" max="100" required>
                                <label for="editDescuento">Descuento (%)</label>
                                <div class="invalid-feedback">El descuento debe estar entre 0 y 100</div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="editTotal" name="total" readonly>
                                <label for="editTotal">Total a Pagar</label>
                            </div>
                        </div>

                        <!-- Estado de Pago -->
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="checkPagado" name="pagado">
                                <label class="form-check-label" for="checkPagado">Marcar como pagado</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-warning" form="formEditar">
                   Actualizar
                </button>
            </div>
        </div>
    </div>
</div>