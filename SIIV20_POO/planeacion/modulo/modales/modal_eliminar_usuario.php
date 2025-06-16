<!-- Modal Eliminar Información Académica -->
<div class="modal fade" id="modalEliminarAcademica" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalEliminarLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <h5 class="text-center mb-3">¿Está seguro que desea eliminar este registro académico?</h5>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    Esta acción no se puede deshacer.
                </div>
                <div class="d-none">
                    <input type="hidden" id="eliminarId" value="">
                </div>
                
                <!-- Información destacada del número de control -->
                <div class="alert alert-info text-center mb-3">
                    <h6 class="mb-1"><i class="bi bi-person-badge me-2"></i>Número de Control:</h6>
                    <h4 class="mb-0 fw-bold" id="eliminarNumero"></h4>
                </div>
                
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>Alumno:</dt>
                                <dd id="eliminarNombre"></dd>
                                <dt>Carrera:</dt>
                                <dd id="eliminarCarrera"></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Semestre:</dt>
                                <dd id="eliminarSemestre"></dd>
                                <dt>Periodo:</dt>
                                <dd id="eliminarPeriodo"></dd>
                                <dt>Promedio:</dt>
                                <dd id="eliminarPromedio"></dd>
                            </dl>
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