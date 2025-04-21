<div class="row g-3">
    <div class="col-12 col-sm-6 col-md-4">
        <label for="vivesconquien" class="form-label">¿Con quién vives?</label>
        <select class="form-select form-select-sm" id="vivesconquien" name="vivesconquien" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="Vivo solo">Solo</option>
            <option value="vivo con Familiar">Con un familiar</option>
            <option value="Vivo con un amigo">Con un amigo</option>
            <option value="Vivo con mi padres">Con mis padres</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione una opción</div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="personasCasa" class="form-label">Personas en la casa</label>
        <select class="form-select form-select-sm" id="personasCasa" name="personas_en_casa" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="1 persona">1 persona</option>
            <option value="2 personas">2 personas</option>
            <option value="3 personas">3 personas</option>
            <option value="4 personas">4 personas</option>
            <option value="5 personas">5 personas</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione el número de personas</div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="dependenciaEconomica" class="form-label">¿De quién dependes?</label>
        <select class="form-select form-select-sm" id="dependenciaEconomica" name="dependes" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="De mis padres">De mis padres</option>
            <option value="De nadie">De nadie</option>
            <option value="tutor">De un tutor</option>
            <option value="familiar">De un familiar</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione una opción</div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="tipoVivienda" class="form-label">Tipo de vivienda</label>
        <select class="form-select form-select-sm" id="tipoVivienda" name="vivienda" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="De mis padres">De mis padres</option>
            <option value="De nadie">De nadie</option>
            <option value="tutor">De un tutor</option>
            <option value="familiar">De un familiar</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione el tipo de vivienda</div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="cuartosCasa" class="form-label">Nº de cuartos</label>
        <select class="form-select form-select-sm" id="cuartosCasa" name="numero_cuartos" required>
            <option value="" disabled selected>Seleccionar</option>
            <option value="1 cuarto">1 cuarto</option>
            <option value="2 cuartos">2 cuartos</option>
            <option value="3 cuartos">3 cuartos</option>
            <option value="4 cuartos">4 cuartos</option>
            <option value="5 cuartos">5 cuartos</option>
        </select>
        <div class="invalid-feedback">Por favor seleccione el número de cuartos</div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <label for="dependientesEconomicos" class="form-label">Dependientes</label>
        <input type="number" class="form-control form-control-sm"
            id="dependientesEconomicos"
            name="dependientes"
            min="0"
            max="10"
            required>
        <div class="invalid-feedback">Por favor ingrese un número válido</div>
    </div>
</div>

<h4 class="text-center mb-4 mt-5">Ingresos familiares mensuales</h4>
<div class="row g-3">
    <div class="col-12 col-sm-6 col-md-3">
        <label for="ingresosFamiliarespadre" class="form-label">Padre</label>
        <input type="number" class="form-control form-control-sm"
            id="ingresosFamiliarespadre"
            name="ingreso_padre"
            min="0"
            step="100"
            oninput="sumarIngresos()"
            required>
        <div class="invalid-feedback">Por favor ingrese un monto válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <label for="ingresosFamiliaresmadre" class="form-label">Madre</label>
        <input type="number" class="form-control form-control-sm"
            id="ingresosFamiliaresmadre"
            name="ingreso_madre"
            min="0"
            step="100"
            oninput="sumarIngresos()"
            required>
        <div class="invalid-feedback">Por favor ingrese un monto válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="ingresosFamiliareshermanos" class="form-label">Hermanos</label>
        <input type="number" class="form-control form-control-sm"
            id="ingresosFamiliareshermanos"
            name="ingreso_hermanos"
            min="0"
            step="100"
            oninput="sumarIngresos()"
            required>
        <div class="invalid-feedback">Por favor ingrese un monto válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="ingresosPropios" class="form-label">Propios</label>
        <input type="number" class="form-control form-control-sm"
            id="ingresosPropios"
            name="ingresos_propios"
            min="0"
            step="100"
            oninput="sumarIngresos()"
            required>
        <div class="invalid-feedback">Por favor ingrese un monto válido</div>
    </div>

    <div class="col-12 col-sm-6 col-md-2">
        <label for="ingresosTotales" class="form-label">Total</label>
        <input type="number" class="form-control form-control-sm"
            id="ingresosTotales"
            name="ingresos_totales"
            readonly
            style="background-color: #e9ecef;">
    </div>
</div>

<script>
    function sumarIngresos() {
        const padre = Number(document.getElementById('ingresosFamiliarespadre').value) || 0;
        const madre = Number(document.getElementById('ingresosFamiliaresmadre').value) || 0;
        const hermanos = Number(document.getElementById('ingresosFamiliareshermanos').value) || 0;
        const propios = Number(document.getElementById('ingresosPropios').value) || 0;

        const total = padre + madre + hermanos + propios;
        document.getElementById('ingresosTotales').value = total;
    }
</script>