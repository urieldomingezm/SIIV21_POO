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
require_once('pago_registrar.php');

try {
    // Validar campos requeridos
    $camposRequeridos = ['numero_control', 'nombre', 'apellido', 'carrera', 'semestre', 'periodo', 'descuento'];
    
    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
            throw new Exception("El campo {$campo} es requerido");
        }
    }

    // Preparar datos para registro
    $datos = [
        'numero_control' => trim($_POST['numero_control']),
        'nombre' => trim($_POST['nombre']),
        'apellido' => trim($_POST['apellido']),
        'carrera' => trim($_POST['carrera']),
        'semestre' => (int)$_POST['semestre'],
        'periodo' => trim($_POST['periodo']),
        'descuento' => (int)$_POST['descuento']
    ];

    // Validaciones adicionales
    if (!preg_match('/^[0-9]{8}$/', $datos['numero_control'])) {
        throw new Exception('El número de control debe tener exactamente 8 dígitos');
    }

    if (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $datos['nombre'])) {
        throw new Exception('El nombre solo puede contener letras y espacios');
    }

    if (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $datos['apellido'])) {
        throw new Exception('Los apellidos solo pueden contener letras y espacios');
    }

    if ($datos['semestre'] < 1 || $datos['semestre'] > 12) {
        throw new Exception('El semestre debe estar entre 1 y 12');
    }

    if ($datos['descuento'] < 0 || $datos['descuento'] > 100) {
        throw new Exception('El descuento debe estar entre 0 y 100');
    }

    if (!in_array($datos['carrera'], ['ISC', 'IEM', 'IGE', 'II'])) {
        throw new Exception('Carrera no válida');
    }

    if (!in_array($datos['periodo'], ['ENE-JUN', 'AGO-DIC'])) {
        throw new Exception('Periodo no válido');
    }

    // Crear instancia de la clase registradora
    $pagoRegistrar = new PagoRegistrar();
    
    // Ejecutar el registro
    $resultado = $pagoRegistrar->registrarPago($datos);
    
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