<?php
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    header('Content-Type: application/json');
    session_start();

    // Debug: Log received POST data
    error_log('Received POST data: ' . print_r($_POST, true));

    if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['form_type']) || $_POST['form_type'] !== 'padresForm') {
        throw new Exception('Tipo de formulario inválido');
    }

    if (!isset($_SESSION['aspirante_curp'])) {
        throw new Exception('Sesión no iniciada o expirada');
    }

    // Validación de campos requeridos
    $campos_requeridos = [
        'Estadodepadre' => 'Estado del padre',
        'apellido_paterno_padre' => 'Apellido paterno del padre',
        'apellido_materno_padre' => 'Apellido materno del padre',
        'nombre_padre' => 'Nombre del padre',
        'nivelEstudiosPadre' => 'Nivel de estudios del padre',
        'ocupacion_padre' => 'Ocupación del padre',
        'Estadodemadre' => 'Estado de la madre',
        'apellido_paterno_madre' => 'Apellido paterno de la madre',
        'apellido_materno_madre' => 'Apellido materno de la madre',
        'nombre_madre' => 'Nombre de la madre',
        'nivelEstudiosMadre' => 'Nivel de estudios de la madre',
        'ocupacion_madre' => 'Ocupación de la madre'
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

    // Debug: Log the SQL query before execution
    error_log('Executing SQL: ' . $query);
    error_log('With params: ' . print_r($params, true));

    // Actualizar registro
    $query = "UPDATE aspirantes_socioeconomicos SET
        padre_vive = :padre_vive,
        padre_apellido_paterno = :padre_apellido_paterno,
        padre_apellido_materno = :padre_apellido_materno,
        padre_nombre = :padre_nombre,
        padre_estudios = :padre_estudios,
        padre_ocupacion = :padre_ocupacion,
        madre_vive = :madre_vive,
        madre_apellido_paterno = :madre_apellido_paterno,
        madre_apellido_materno = :madre_apellido_materno,
        madre_nombre = :madre_nombre,
        madre_estudios = :madre_estudios,
        madre_ocupacion = :madre_ocupacion,
        actualizacion_fecha = NOW()
        WHERE personal_curp = :curp";

    $stmt = $conn->prepare($query);
    
    $params = [
        ':padre_vive' => $_POST['Estadodepadre'],
        ':padre_apellido_paterno' => strtoupper($_POST['apellido_paterno_padre']),
        ':padre_apellido_materno' => strtoupper($_POST['apellido_materno_padre']),
        ':padre_nombre' => strtoupper($_POST['nombre_padre']),
        ':padre_estudios' => $_POST['nivelEstudiosPadre'],
        ':padre_ocupacion' => $_POST['ocupacion_padre'],
        ':madre_vive' => $_POST['Estadodemadre'],
        ':madre_apellido_paterno' => strtoupper($_POST['apellido_paterno_madre']),
        ':madre_apellido_materno' => strtoupper($_POST['apellido_materno_madre']),
        ':madre_nombre' => strtoupper($_POST['nombre_madre']),
        ':madre_estudios' => $_POST['nivelEstudiosMadre'],
        ':madre_ocupacion' => $_POST['ocupacion_madre'],
        ':curp' => $_SESSION['aspirante_curp']
    ];

    if ($stmt->execute($params)) {
        ob_end_clean();
        echo json_encode([
            'status' => 'success',
            'message' => 'Datos de padres guardados correctamente'
        ]);
        exit;
    } else {
        throw new Exception('Error al actualizar los datos de los padres');
    }

} catch (PDOException $e) {
    error_log('PDO Error: ' . $e->getMessage());
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