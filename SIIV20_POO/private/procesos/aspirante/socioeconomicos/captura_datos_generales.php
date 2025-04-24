<?php
// Add output buffering at the very top
ob_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');
$database = new Database();
$conn = $database->getConnection();

// Set headers before any output
header('Content-Type: application/json');

session_start();

try {
    if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['form_type']) || $_POST['form_type'] !== 'datosGeneralesForm') {
        throw new Exception('Invalid request');
    }

    if (!isset($_SESSION['aspirante_curp'])) {
        throw new Exception('No hay sesión activa de aspirante');
    }

    $required_fields = [
        'apellido_paterno', 'apellido_materno', 'nombre',
        'fecha_nacimiento', 'genero', 'curp',
        'nacionalidad_alumno', 'telefono_alumno', 'correo_electronico_alumno'
    ];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("El campo $field es requerido");
        }
    }

    $query = "INSERT INTO aspirantes_socioeconomicos (
        personal_apellido_paterno, personal_apellido_materno, personal_nombre,
        personal_fecha_nacimiento, personal_genero, personal_curp,
        personal_nacionalidad, personal_telefono, personal_correo,
        registro_fecha, actualizacion_fecha
    ) VALUES (
        :apellido_paterno, :apellido_materno, :nombre,
        :fecha_nacimiento, :genero, :curp,
        :nacionalidad, :telefono, :correo,
        NOW(), NOW()
    ) ON DUPLICATE KEY UPDATE
        personal_apellido_paterno = VALUES(personal_apellido_paterno),
        personal_apellido_materno = VALUES(personal_apellido_materno),
        personal_nombre = VALUES(personal_nombre),
        personal_fecha_nacimiento = VALUES(personal_fecha_nacimiento),
        personal_genero = VALUES(personal_genero),
        personal_nacionalidad = VALUES(personal_nacionalidad),
        personal_telefono = VALUES(personal_telefono),
        personal_correo = VALUES(personal_correo),
        actualizacion_fecha = NOW()";

    $stmt = $conn->prepare($query);
    
    $params = [
        ':apellido_paterno' => strtoupper($_POST['apellido_paterno']),
        ':apellido_materno' => strtoupper($_POST['apellido_materno']),
        ':nombre' => strtoupper($_POST['nombre']),
        ':fecha_nacimiento' => $_POST['fecha_nacimiento'],
        ':genero' => $_POST['genero'],
        ':curp' => $_SESSION['aspirante_curp'],
        ':nacionalidad' => $_POST['nacionalidad_alumno'],
        ':telefono' => $_POST['telefono_alumno'],
        ':correo' => strtolower($_POST['correo_electronico_alumno'])
    ];

    // After successful database update
    if ($stmt->execute($params)) {
        // Store completion in session
        $_SESSION['form_datosGenerales_completed'] = true;
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Datos generales guardados correctamente'
        ]);
    }
    else {
        throw new Exception('Error al guardar en la base de datos');
    }
} catch (Exception $e) {
    http_response_code(500);
    // Clear any previous output
    ob_clean();
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    exit;
}

// Clean the buffer and send JSON
ob_end_clean();
echo json_encode([
    'status' => 'success',
    'message' => 'Datos generales guardados correctamente'
]);
exit;
?>