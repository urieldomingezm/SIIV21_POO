<div class="row g-3">
    <div class="col-12 col-sm-6 col-md-4">
        <label for="entidadProcedencia" class="form-label">Entidad federativa</label>
        <select class="form-select form-select-sm" id="entidadProcedencia" name="estado_prepa_procedencia" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="Tamaulipas">Tamaulipas</option>
            <option value="Zacatecas">Zacatecas</option>
        </select>
        <div class="invalid-feedback">
            Por favor seleccione una entidad federativa
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="municipioProcedencia" class="form-label">Municipio</label>
        <input type="text" class="form-control form-control-sm"
            id="municipioProcedencia"
            name="municipio_procedencia_prepa"
            pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
            minlength="3"
            maxlength="50"
            required>
        <div class="invalid-feedback">
            Por favor ingrese un municipio válido
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-4">
        <label for="escuelaProcedencia" class="form-label">Escuela</label>
        <input type="text" class="form-control form-control-sm"
            id="escuelaProcedencia"
            name="escuela_procedencia"
            pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ0-9\s\.,]+"
            minlength="3"
            maxlength="100"
            required>
        <div class="invalid-feedback">
            Por favor ingrese el nombre de la escuela
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="fechaEgreso" class="form-label">Fecha de egreso</label>
        <input type="date" class="form-control form-control-sm"
            id="fechaEgreso"
            name="fecha_egreso_procedencia"
            value="2020-01-01"
            max="<?php echo date('Y-m-d'); ?>"
            min="<?php echo date('Y-m-d', strtotime('-10 years')); ?>"
            required>
        <div class="invalid-feedback">
            Por favor seleccione una fecha válida
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="promedioGeneral" class="form-label">Promedio general</label>
        <input type="number" class="form-control form-control-sm"
            id="promedioGeneral"
            name="promedio_general_procedencia"
            min="6"
            max="10"
            step="0.01"
            style="width: 80px; text-align: center;"
            required>
        <div class="invalid-feedback">
            Por favor ingrese un promedio válido (6-10)
        </div>
    </div>
</div>