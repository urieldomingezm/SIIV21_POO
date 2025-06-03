<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalEliminarLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-trash text-danger" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-center mb-3">¿Está seguro que desea eliminar este registro de pago?</h5>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    Esta acción no se puede deshacer.
                </div>
                <div class="d-none">
                    <input type="hidden" id="eliminarId" value="">
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>Alumno:</dt>
                                <dd id="eliminarNombre"></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Total:</dt>
                                <dd id="eliminarTotal"></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">
                    <i class="bi bi-trash me-2"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>