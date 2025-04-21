<!-- Datos del Padre -->
<h4 class="text-center mb-4">Datos del Padre</h4>
<div class="row g-3">
    <div class="col-12 col-sm-6 col-md-2">
        <label for="Estadodepadre" class="form-label">Vive</label>
        <select class="form-select form-select-sm" id="Estadodepadre" name="Estadodepadre" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="Si">Sí</option>
            <option value="No">No</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione una opción</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="apellidoPaternoPadre" class="form-label">Apellido Paterno</label>
        <input type="text" class="form-control form-control-sm"
            id="apellidoPaternoPadre"
            name="apellido_paterno_padre"
            pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
            minlength="2"
            maxlength="50"
            required>
        <div class="invalid-feedback">Por favor ingrese un apellido válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="apellidoMaternoPadre" class="form-label">Apellido Materno</label>
        <input type="text" class="form-control form-control-sm"
            id="apellidoMaternoPadre"
            name="apellido_materno_padre"
            pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
            minlength="2"
            maxlength="50"
            required>
        <div class="invalid-feedback">Por favor ingrese un apellido válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="nombrePadre" class="form-label">Nombre(s)</label>
        <input type="text" class="form-control form-control-sm"
            id="nombrePadre"
            name="nombre_padre"
            pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
            minlength="2"
            maxlength="50"
            required>
        <div class="invalid-feedback">Por favor ingrese un nombre válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="nivelEstudiosPadre" class="form-label">Estudios</label>
        <select class="form-select form-select-sm" id="nivelEstudiosPadre" name="nivelEstudiosPadre" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="PrimariaTerminada">Educación primaria terminada</option>
            <option value="PrimariaNoTerminada">Educación primaria no terminada</option>
            <option value="Secundaria">Educación secundaria</option>
            <option value="SecundariaNoTerminada">Educación secundaria no terminada</option>
            <option value="MediaSuperior">Educación media superior</option>
            <option value="MediaSuperiorNoTerminada">Educación media superior no terminada</option>
            <option value="Superior">Educación superior</option>
            <option value="SuperiorNoTerminada">Educación superior no terminada</option>
            <option value="Posgrado">Posgrado</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione el nivel de estudios</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="ocupacionPadre" class="form-label">Ocupación</label>
        <select class="form-select form-select-sm" id="ocupacionPadre" name="ocupacion_padre" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="empleado">Empleado</option>
            <option value="empresario">Empresario</option>
            <option value="trabajador_independiente">Trabajador independiente</option>
            <option value="jubilado">Jubilado</option>
            <option value="ama de casa">Ama de casa</option>
            <option value="desempleado">Desempleado</option>
            <option value="otro">Otro</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione una ocupación</div>
    </div>
</div>

<!-- Datos de la Madre -->
<h4 class="text-center mb-4 mt-5">Datos de la Madre</h4>
<div class="row g-3">
    <div class="col-12 col-sm-6 col-md-2">
        <label for="Estadodemadre" class="form-label">Vive</label>
        <select class="form-select form-select-sm" id="Estadodemadre" name="Estadodemadre" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="Si">Sí</option>
            <option value="No">No</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione una opción</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="apellidoPaternoMadre" class="form-label">Apellido Paterno</label>
        <input type="text" class="form-control form-control-sm"
            id="apellidoPaternoMadre"
            name="apellido_paterno_madre"
            pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
            minlength="2"
            maxlength="50"
            required>
        <div class="invalid-feedback">Por favor ingrese un apellido válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="apellidoMaternoMadre" class="form-label">Apellido Materno</label>
        <input type="text" class="form-control form-control-sm"
            id="apellidoMaternoMadre"
            name="apellido_materno_madre"
            pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
            minlength="2"
            maxlength="50"
            required>
        <div class="invalid-feedback">Por favor ingrese un apellido válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="nombreMadre" class="form-label">Nombre(s)</label>
        <input type="text" class="form-control form-control-sm"
            id="nombreMadre"
            name="nombre_madre"
            pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
            minlength="2"
            maxlength="50"
            required>
        <div class="invalid-feedback">Por favor ingrese un nombre válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="nivelEstudiosMadre" class="form-label">Estudios</label>
        <select class="form-select form-select-sm" id="nivelEstudiosMadre" name="nivelEstudiosMadre" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="PrimariaTerminada">Educación primaria terminada</option>
            <option value="PrimariaNoTerminada">Educación primaria no terminada</option>
            <option value="Secundaria">Educación secundaria</option>
            <option value="SecundariaNoTerminada">Educación secundaria no terminada</option>
            <option value="MediaSuperior">Educación media superior</option>
            <option value="MediaSuperiorNoTerminada">Educación media superior no terminada</option>
            <option value="Superior">Educación superior</option>
            <option value="SuperiorNoTerminada">Educación superior no terminada</option>
            <option value="Posgrado">Posgrado</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione el nivel de estudios</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="ocupacionMadre" class="form-label">Ocupación</label>
        <select class="form-select form-select-sm" id="ocupacionMadre" name="ocupacion_madre" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="empleado">Empleada</option>
            <option value="empresario">Empresaria</option>
            <option value="trabajador_independiente">Trabajadora independiente</option>
            <option value="jubilado">Jubilada</option>
            <option value="ama de casa">Ama de casa</option>
            <option value="desempleado">Desempleada</option>
            <option value="otro">Otro</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione una ocupación</div>
    </div>
</div>