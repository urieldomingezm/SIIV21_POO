<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Initialize database connection
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    try {
        // Consulta para obtener usuario y rol
        $query = "SELECT id_usuario, usuario_nombre, usuario_contraseña, rol_id FROM login_alumnos_personal WHERE usuario_nombre = :usuario_nombre AND usuario_contraseña = :password LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':usuario_nombre', $usuario);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Iniciar sesión directamente sin verificar hash
            $_SESSION['USER_ID'] = $user['id_usuario'];
            $_SESSION['ROLE'] = $user['rol_id'];
            $_SESSION['USER'] = $user['usuario_nombre'];

            // Redirigir según el rol usando JavaScript
            if ($user['rol_id'] == 1) {
                echo "<script>window.location.href = '/modulo/alumno/index.php';</script>";
            } elseif ($user['rol_id'] == 2) {
                echo "<script>window.location.href = '/modulo/personal/index.php';</script>";
            } else {
                echo "<script>alert('Rol no identificado.'); window.location.href = '/index.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos.'); window.location.href = '/index.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
