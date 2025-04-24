<?php
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    header('Content-Type: application/json');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['form_type']) || $_POST['form_type'] !== 'domicilioForm') {
        throw new Exception('Tipo de formulario inválido');
    }

    if (!isset($_SESSION['aspirante_curp'])) {
        throw new Exception('Sesión no iniciada o expirada');
    }

    // Validación de campos requeridos
    $campos_requeridos = [
        'calle' => 'Calle',
        'numero_exterior' => 'Número exterior',
        'codigo_postal' => 'Código postal',
        'colonia' => 'Colonia',
        'estado' => 'Estado',
        'municipio' => 'Municipio'
    ];

    foreach ($campos_requeridos as $campo => $nombre) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            throw new Exception("El campo {$nombre} es obligatorio");
        }
    }

    // Verificar si existe el registro
    $checkQuery = "SELECT id FROM aspirantes_socioeconomicos WHERE personal_curp = :curp LIMIT 1";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->execute([':curp' => $_SESSION['aspirante_curp']]);
    
    if (!$checkStmt->fetch()) {
        throw new Exception('Primero debe completar los datos generales del aspirante');
    }

    // Actualizar registro
    $query = "UPDATE aspirantes_socioeconomicos SET
        direccion_calle = :calle,
        direccion_numero = :numero,
        direccion_codigo_postal = :codigo_postal,
        direccion_colonia = :colonia,
        direccion_estado = :estado,
        direccion_municipio = :municipio,
        actualizacion_fecha = NOW()
        WHERE personal_curp = :curp";

    $stmt = $conn->prepare($query);
    
    $params = [
        ':calle' => strtoupper($_POST['calle']),
        ':numero' => strtoupper($_POST['numero_exterior']),
        ':codigo_postal' => $_POST['codigo_postal'],
        ':colonia' => strtoupper($_POST['colonia']),
        ':estado' => strtoupper($_POST['estado']),
        ':municipio' => strtoupper($_POST['municipio']),
        ':curp' => $_SESSION['aspirante_curp']
    ];

    if ($stmt->execute($params)) {
        ob_end_clean();
        echo json_encode([
            'status' => 'success',
            'message' => 'Datos de domicilio guardados correctamente'
        ]);
        exit;
    } else {
        throw new Exception('Error al actualizar los datos de domicilio');
    }

} catch (PDOException $e) {
    error_log('Error PDO: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de base de datos'
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    exit;
}