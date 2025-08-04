<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'personal') {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Incluir la clase de registro
require_once('academico_registrar.php');

try {
    // Validar campos requeridos
    $camposRequeridos = ['alumno_id', 'carrera_id', 'semestre', 'periodo', 'promedio'];
    
    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
            throw new Exception("El campo {$campo} es requerido");
        }
    }

    // Preparar datos para registro
    $datos = [
        'alumno_id' => (int)$_POST['alumno_id'],
        'carrera_id' => trim($_POST['carrera_id']),
        'semestre' => (int)$_POST['semestre'],
        'periodo' => trim($_POST['periodo']),
        'promedio' => (float)$_POST['promedio']
    ];

    // Validaciones adicionales
    if ($datos['alumno_id'] <= 0) {
        throw new Exception('ID de alumno no válido');
    }

    if ($datos['semestre'] < 1 || $datos['semestre'] > 12) {
        throw new Exception('El semestre debe estar entre 1 y 12');
    }

    if ($datos['promedio'] < 0 || $datos['promedio'] > 100) {
        throw new Exception('El promedio debe estar entre 0 y 100');
    }

    $carrerasValidas = ['ISC', 'IEM', 'IGE', 'II', 'IC', 'IM', 'IE', 'LA', 'LC'];
    if (!in_array($datos['carrera_id'], $carrerasValidas)) {
        throw new Exception('Carrera no válida');
    }

    $periodosValidos = ['ENE-JUN', 'AGO-DIC', 'ENE-MAY', 'SEP-DIC', 'FEB-JUN', 'JUL-NOV'];
    if (!in_array($datos['periodo'], $periodosValidos)) {
        throw new Exception('Periodo no válido');
    }

    // Crear instancia de la clase registradora
    $academicoRegistrar = new AcademicoRegistrar();
    
    // Ejecutar el registro
    $resultado = $academicoRegistrar->registrarAcademico($datos);
    
    // Devolver respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($resultado);

} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>