<div class="row g-3">
    <div class="col-12 col-sm-6 col-md-2">
        <label for="tipoSangre" class="form-label">Tipo de sangre</label>
        <select class="form-select form-select-sm" id="tipoSangre" name="tipo_sangre" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="Nose">No sé</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione su tipo de sangre</div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="contactoEmergencia" class="form-label">Contacto de Emergencia</label>
        <input type="text" class="form-control form-control-sm"
            id="contactoEmergencia"
            name="contactoEmergencia"
            pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
            minlength="3"
            maxlength="100"
            required>
        <div class="invalid-feedback">Por favor ingrese un nombre válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <label for="calleNumeroEmergencia" class="form-label">Calle y número</label>
        <input type="text" class="form-control form-control-sm"
            id="calleNumeroEmergencia"
            name="callenumeroemergencia"
            minlength="5"
            maxlength="100"
            required>
        <div class="invalid-feedback">Por favor ingrese una dirección válida</div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <label for="coloniaEmergencia" class="form-label">Colonia</label>
        <input type="text" class="form-control form-control-sm"
            id="coloniaEmergencia"
            name="coloniaLocalidademergencia"
            minlength="3"
            maxlength="50"
            required>
        <div class="invalid-feedback">Por favor ingrese una colonia válida</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="codigoPostalEmergencia" class="form-label">Código Postal</label>
        <input type="text" class="form-control form-control-sm"
            id="codigoPostalEmergencia"
            name="codigo_postal_emergencia"
            pattern="[0-9]{5}"
            maxlength="5"
            required>
        <div class="invalid-feedback">Ingrese un código postal válido (5 dígitos)</div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="estadoEmergencia" class="form-label">Estado</label>
        <select class="form-select form-select-sm" id="estadoEmergencia" name="estado_emergencia" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="Tamaulipas">Tamaulipas</option>
            <option value="Aguascalientes">Aguascalientes</option>
            <!-- Add other states as needed -->
        </select>
        <div class="invalid-feedback">Por favor seleccione un estado</div>
    </div>
</div>