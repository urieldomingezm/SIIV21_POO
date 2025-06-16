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
                <h5 class="text-center mb-3">¿Está seguro que desea eliminar este registro de pago?</h5>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    Esta acción no se puede deshacer.
                </div>
                <div class="d-none">
                    <input type="hidden" id="eliminarId" value="">
                </div>
                <div class="mt-3">
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nombre:</strong> <span id="eliminarNombre"></span><br>
                                <strong>No. Control:</strong> <span id="eliminarNumeroControl"></span><br>
                                <strong>Carrera:</strong> <span id="eliminarCarrera"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Semestre:</strong> <span id="eliminarSemestre"></span><br>
                                <strong>Periodo:</strong> <span id="eliminarPeriodo"></span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Descuento:</strong> <span id="eliminarDescuento"></span>
                            </div>
                            <div class="col-md-4">
                                <strong>Total:</strong> <span id="eliminarTotal"></span>
                            </div>
                            <div class="col-md-4">
                                <strong>Estado:</strong> <span id="eliminarEstado"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                 Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">
                  Eliminar
                </button>
            </div>
        </div>
    </div>
</div>