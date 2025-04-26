<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'alumno_login') {
    try {
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            throw new Exception('Token de seguridad inválido');
        }

        if (empty($_POST['alumno_numero_control']) || empty($_POST['alumno_password'])) {
            throw new Exception('Número de control y NIP son requeridos');
        }

        $numero_control = trim($_POST['alumno_numero_control']);
        $password = $_POST['alumno_password'];

        $query = "SELECT alumno_id, alumno_numero_control, alumno_password, alumno_rol 
                 FROM alumnos 
                 WHERE alumno_numero_control = :numero_control";
        $stmt = $conn->prepare($query);
        $stmt->execute(array(':numero_control' => $numero_control));
        $alumno = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$alumno) {
            throw new Exception('Número de control o NIP incorrectos');
        }

        if (!password_verify($password, $alumno['alumno_password'])) {
            throw new Exception('Número de control o NIP incorrectos');
        }

        $update_query = "UPDATE alumnos SET alumno_ultimo_acceso = NOW() WHERE alumno_id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->execute(array(':id' => $alumno['alumno_id']));

        $_SESSION['user_id'] = $alumno['alumno_id'];
        $_SESSION['numero_control'] = $alumno['alumno_numero_control'];
        $_SESSION['user_type'] = 'alumno';
        $_SESSION['rol'] = $alumno['alumno_rol'];

        $response = array(
            'status' => 'success',
            'title' => '¡Inicio de Sesión Exitoso!',
            'message' => 'Redireccionando al panel de alumno...',
            'icon' => 'success',
            'redirect' => '/modulo/'
        );
        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'title' => 'Error de Inicio de Sesión',
            'message' => htmlspecialchars($e->getMessage()),
            'icon' => 'error'
        );
        echo json_encode($response);
        exit;
    }
}
?>