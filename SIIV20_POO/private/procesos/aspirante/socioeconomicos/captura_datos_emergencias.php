<?php
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    header('Content-Type: application/json');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['form_type']) || $_POST['form_type'] !== 'emergenciaForm') {
        throw new Exception('Invalid request');
    }

    if (!isset($_SESSION['aspirante_curp'])) {
        throw new Exception('No hay sesión activa de aspirante');
    }

    $required_fields = [
        'tipo_sangre',
        'contactoEmergencia',
        'callenumeroemergencia',
        'coloniaLocalidademergencia',
        'codigo_postal_emergencia',
        'estado_emergencia'
    ];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("El campo $field es requerido");
        }
    }

    $query = "UPDATE aspirantes_socioeconomicos SET
        personal_tipo_sangre = :tipo_sangre,
        emergencia_contacto = :contacto,
        emergencia_direccion = :direccion,
        emergencia_colonia = :colonia,
        emergencia_codigo_postal = :codigo_postal,
        emergencia_estado = :estado,
        actualizacion_fecha = NOW()
        WHERE personal_curp = :curp";

    $stmt = $conn->prepare($query);
    
    $params = [
        ':tipo_sangre' => $_POST['tipo_sangre'],
        ':contacto' => strtoupper($_POST['contactoEmergencia']),
        ':direccion' => strtoupper($_POST['callenumeroemergencia']),
        ':colonia' => strtoupper($_POST['coloniaLocalidademergencia']),
        ':codigo_postal' => $_POST['codigo_postal_emergencia'],
        ':estado' => strtoupper($_POST['estado_emergencia']),
        ':curp' => $_SESSION['aspirante_curp']
    ];

    if ($stmt->execute($params)) {
        ob_end_clean();
        echo json_encode([
            'status' => 'success',
            'message' => 'Datos de emergencia guardados correctamente'
        ]);
        exit;
    } else {
        throw new Exception('Error al guardar en la base de datos');
    }
} catch (Exception $e) {
    http_response_code(500);
    ob_end_clean();
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    exit;
}