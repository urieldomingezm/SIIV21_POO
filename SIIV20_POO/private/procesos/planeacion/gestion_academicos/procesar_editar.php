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

// Incluir la clase de edición
require_once('academico_editar.php');

try {
    // Validar que se recibió el ID
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('ID de registro académico requerido');
    }

    $registro_id = (int)$_POST['id'];
    
    // Preparar datos para actualizar
    $datos = [];
    
    // Solo incluir campos que se enviaron
    if (isset($_POST['carrera_id']) && !empty(trim($_POST['carrera_id']))) {
        $carrerasValidas = ['ISC', 'IEM', 'IGE', 'II', 'IC', 'IM', 'IE', 'LA', 'LC'];
        if (!in_array(trim($_POST['carrera_id']), $carrerasValidas)) {
            throw new Exception('Carrera no válida');
        }
        $datos['carrera_id'] = trim($_POST['carrera_id']);
    }
    
    if (isset($_POST['semestre']) && !empty($_POST['semestre'])) {
        $semestre = (int)$_POST['semestre'];
        if ($semestre < 1 || $semestre > 12) {
            throw new Exception('El semestre debe estar entre 1 y 12');
        }
        $datos['semestre'] = $semestre;
    }
    
    if (isset($_POST['periodo']) && !empty(trim($_POST['periodo']))) {
        $periodosValidos = ['ENE-JUN', 'AGO-DIC', 'ENE-MAY', 'SEP-DIC', 'FEB-JUN', 'JUL-NOV'];
        if (!in_array(trim($_POST['periodo']), $periodosValidos)) {
            throw new Exception('Periodo no válido');
        }
        $datos['periodo'] = trim($_POST['periodo']);
    }
    
    if (isset($_POST['promedio']) && $_POST['promedio'] !== '') {
        $promedio = (float)$_POST['promedio'];
        if ($promedio < 0 || $promedio > 100) {
            throw new Exception('El promedio debe estar entre 0 y 100');
        }
        $datos['promedio'] = $promedio;
    }

    if (empty($datos)) {
        throw new Exception('No se proporcionaron datos para actualizar');
    }

    // Crear instancia de la clase editora
    $academicoEditar = new AcademicoEditar();
    
    // Ejecutar la edición
    $resultado = $academicoEditar->editarAcademico($registro_id, $datos);
    
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