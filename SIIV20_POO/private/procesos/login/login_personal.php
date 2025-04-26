<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'personal_login') {
    try {
        if (empty($_POST['personal_usuario']) || empty($_POST['personal_password'])) {
            throw new Exception('Usuario y contraseña son requeridos');
        }

        $usuario = trim($_POST['personal_usuario']);
        $password = $_POST['personal_password'];

        $query = "SELECT personal_id, personal_usuario, personal_password, personal_rol, personal_activo 
                 FROM personal 
                 WHERE personal_usuario = :usuario";
        $stmt = $conn->prepare($query);
        $stmt->execute(array(':usuario' => $usuario));
        $personal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$personal) {
            throw new Exception('Usuario o contraseña incorrectos');
        }

        if (!$personal['personal_activo']) {
            throw new Exception('Usuario inactivo. Contacte al administrador.');
        }

        if (!password_verify($password, $personal['personal_password'])) {
            throw new Exception('Usuario o contraseña incorrectos');
        }

        $update_query = "UPDATE personal SET personal_ultimo_acceso = NOW() WHERE personal_id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->execute(array(':id' => $personal['personal_id']));

        $_SESSION['user_id'] = $personal['personal_id'];
        $_SESSION['personal_usuario'] = $personal['personal_usuario'];
        $_SESSION['user_type'] = 'personal';
        $_SESSION['rol'] = $personal['personal_rol'];

        $response = array(
            'status' => 'success',
            'title' => '¡Inicio de Sesión Exitoso!',
            'message' => 'Redireccionando al panel de personal...',
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