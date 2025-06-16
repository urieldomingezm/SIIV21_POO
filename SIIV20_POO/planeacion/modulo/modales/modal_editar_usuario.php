<!-- Modal Editar Información Académica -->
<div class="modal fade" id="modalEditarAcademica" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="modalEditarLabel">
                    <i class="bi bi-pencil-square me-2"></i>Editar Información Académica
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditar" class="needs-validation" novalidate>
                    <input type="hidden" name="id" id="editId">
                    
                    <div class="row g-3">
                        <!-- Información destacada del número de control -->
                        <div class="col-12">
                            <div class="alert alert-primary text-center" role="alert">
                                <h6 class="mb-1"><i class="bi bi-person-badge me-2"></i>Número de Control:</h6>
                                <h4 class="mb-1 fw-bold" id="numeroControl"></h4>
                                <small><strong>Alumno:</strong> <span id="nombreAlumno"></span></small>
                            </div>
                        </div>

                        <!-- Carrera -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-select" id="editCarrera" name="carrera_id" required>
                                    <option value="">Seleccione una carrera</option>
                                    <?php if(isset($carreras) && !empty($carreras)): ?>
                                        <?php foreach($carreras as $carrera): ?>
                                            <option value="<?php echo htmlspecialchars($carrera['carrera_id']); ?>">
                                                <?php echo htmlspecialchars($carrera['carrera_clave'] . ' - ' . $carrera['carrera_nombre_completo']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">INFO - Ingeniería en Informática</option>
                                        <option value="2">CIVIL - Ingeniería Civil</option>
                                        <option value="3">SIST - Ingeniería en Sistemas Computacionales</option>
                                        <option value="4">INDUS - Ingeniería Industrial</option>
                                        <option value="5">EMP - Ingeniería Empresarial</option>
                                        <option value="6">MEC - Ingeniería Mecánica</option>
                                        <option value="7">BIO - Licenciatura en Biología</option>
                                        <option value="8">ELEC - Ingeniería Electrónica</option>
                                        <option value="9">ENER - Ingeniería en Energías Renovables</option>
                                    <?php endif; ?>
                                </select>
                                <label for="editCarrera">Carrera</label>
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
                                <label for="editSemestre">Semestre</label>
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
                                <label for="editPeriodo">Periodo</label>
                                <div class="invalid-feedback">Por favor seleccione un periodo</div>
                            </div>
                        </div>

                        <!-- Promedio -->
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="editPromedio" name="promedio" min="0" max="100" step="0.01" required>
                                <label for="editPromedio">Promedio</label>
                                <div class="invalid-feedback">El promedio debe estar entre 0 y 100</div>
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