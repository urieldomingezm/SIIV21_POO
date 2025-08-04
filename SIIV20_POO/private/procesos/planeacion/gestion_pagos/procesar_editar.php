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
require_once('pago_editar.php');

try {
    // Validar que se recibió el ID
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('ID de pago requerido');
    }

    $pago_id = (int)$_POST['id'];
    
    // Preparar datos para actualizar
    $datos = [];
    
    // Solo incluir campos que se enviaron
    if (isset($_POST['descuento'])) {
        $datos['descuento'] = (int)$_POST['descuento'];
    }
    
    if (isset($_POST['realizado'])) {
        $datos['realizado'] = 1; // Si se envía, significa que está marcado
    } else {
        $datos['realizado'] = 0; // Si no se envía, significa que no está marcado
    }

    // Crear instancia de la clase editora
    $pagoEditar = new PagoEditar();
    
    // Ejecutar la edición
    $resultado = $pagoEditar->editarPago($pago_id, $datos);
    
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