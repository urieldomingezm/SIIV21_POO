<?php
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    header('Content-Type: application/json');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['form_type']) || $_POST['form_type'] !== 'preparatoriaForm') {
        throw new Exception('Tipo de formulario inválido');
    }

    if (!isset($_SESSION['aspirante_curp'])) {
        throw new Exception('Sesión no iniciada o expirada');
    }

    // Validación más robusta de campos
    $campos_requeridos = [
        'estado_prepa_procedencia' => 'Estado de procedencia',
        'municipio_procedencia_prepa' => 'Municipio de procedencia',
        'escuela_procedencia' => 'Escuela de procedencia',
        'fecha_egreso_procedencia' => 'Fecha de egreso',
        'promedio_general_procedencia' => 'Promedio general'
    ];

    foreach ($campos_requeridos as $campo => $nombre) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            throw new Exception("El campo {$nombre} es obligatorio");
        }
    }

    // Verificar primero si existe el registro
    $checkQuery = "SELECT id FROM aspirantes_socioeconomicos WHERE personal_curp = :curp LIMIT 1";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->execute([':curp' => $_SESSION['aspirante_curp']]);
    
    if (!$checkStmt->fetch()) {
        throw new Exception('Primero debe completar los datos generales del aspirante');
    }

    // Actualizar registro existente
    $query = "UPDATE aspirantes_socioeconomicos SET
        procedencia_estado = :estado,
        procedencia_municipio = :municipio,
        procedencia_escuela = :escuela,
        procedencia_fecha_egreso = :fecha_egreso,
        procedencia_promedio = :promedio,
        actualizacion_fecha = NOW()
        WHERE personal_curp = :curp";

    $stmt = $conn->prepare($query);
    
    $params = [
        ':estado' => strtoupper($_POST['estado_prepa_procedencia']),
        ':municipio' => strtoupper($_POST['municipio_procedencia_prepa']),
        ':escuela' => strtoupper($_POST['escuela_procedencia']),
        ':fecha_egreso' => $_POST['fecha_egreso_procedencia'],
        ':promedio' => (float)$_POST['promedio_general_procedencia'],
        ':curp' => $_SESSION['aspirante_curp']
    ];

    if ($stmt->execute($params)) {
        ob_end_clean();
        echo json_encode([
            'status' => 'success',
            'message' => 'Datos de preparatoria guardados correctamente',
            'updated_rows' => $stmt->rowCount() // Para depuración
        ]);
        exit;
    } else {
        throw new Exception('Error al actualizar los datos');
    }

} catch (PDOException $e) {
    error_log('Error PDO: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de base de datos',
        'debug' => $e->getMessage() // Solo para desarrollo
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
?>