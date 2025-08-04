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

// Incluir la clase de eliminación
require_once('academico_eliminar.php');

try {
    // Validar que se recibió el ID
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('ID de registro académico requerido');
    }

    // Validar tipo de eliminación
    if (!isset($_POST['tipo']) || empty($_POST['tipo'])) {
        throw new Exception('Tipo de eliminación requerido');
    }

    $registro_id = (int)$_POST['id'];
    $tipo = $_POST['tipo'];

    // Validar tipo de eliminación
    if (!in_array($tipo, ['completa', 'suave'])) {
        throw new Exception('Tipo de eliminación no válido');
    }

    // Crear instancia de la clase eliminadora
    $academicoEliminar = new AcademicoEliminar();
    
    // Ejecutar eliminación según el tipo
    if ($tipo === 'suave') {
        $resultado = $academicoEliminar->eliminarAcademicoSoft($registro_id);
    } else {
        $resultado = $academicoEliminar->eliminarAcademico($registro_id);
    }
    
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