<?php
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    header('Content-Type: application/json');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['form_type']) || $_POST['form_type'] !== 'socioeconomicoForm') {
        throw new Exception('Invalid request');
    }

    if (!isset($_SESSION['aspirante_curp'])) {
        throw new Exception('No hay sesión activa de aspirante');
    }

    // Validate required fields
    $required_fields = [
        'vivesconquien',
        'personas_en_casa',
        'dependes',
        'vivienda',
        'numero_cuartos',
        'dependientes',
        'ingreso_padre',
        'ingreso_madre',
        'ingreso_hermanos',
        'ingresos_propios'
    ];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("El campo $field es requerido");
        }
    }

    // Check if record exists
    $checkQuery = "SELECT id FROM aspirantes_socioeconomicos WHERE personal_curp = :curp LIMIT 1";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->execute([':curp' => $_SESSION['aspirante_curp']]);
    
    if (!$checkStmt->fetch()) {
        throw new Exception('Primero debe completar los datos generales del aspirante');
    }

    // Update record
    $query = "UPDATE aspirantes_socioeconomicos SET
        familiar_vive_con = :vive_con,
        familiar_personas_casa = :personas_casa,
        familiar_dependencia = :dependencia,
        familiar_tipo_vivienda = :tipo_vivienda,
        familiar_numero_cuartos = :numero_cuartos,
        familiar_dependientes = :dependientes,
        ingresos_padre = :ingreso_padre,
        ingresos_madre = :ingreso_madre,
        ingresos_hermanos = :ingreso_hermanos,
        ingresos_propios = :ingresos_propios,
        ingresos_total = :ingresos_totales,
        actualizacion_fecha = NOW()
        WHERE personal_curp = :curp";

    $stmt = $conn->prepare($query);
    
    $params = [
        ':vive_con' => $_POST['vivesconquien'],
        ':personas_casa' => $_POST['personas_en_casa'],
        ':dependencia' => $_POST['dependes'],
        ':tipo_vivienda' => $_POST['vivienda'],
        ':numero_cuartos' => $_POST['numero_cuartos'],
        ':dependientes' => (int)$_POST['dependientes'],
        ':ingreso_padre' => (float)$_POST['ingreso_padre'],
        ':ingreso_madre' => (float)$_POST['ingreso_madre'],
        ':ingreso_hermanos' => (float)$_POST['ingreso_hermanos'],
        ':ingresos_propios' => (float)$_POST['ingresos_propios'],
        ':ingresos_totales' => (float)$_POST['ingresos_totales'],
        ':curp' => $_SESSION['aspirante_curp']
    ];

    if ($stmt->execute($params)) {
        ob_end_clean();
        echo json_encode([
            'status' => 'success',
            'message' => 'Datos socioeconómicos guardados correctamente'
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