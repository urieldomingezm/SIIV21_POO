<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $curp = strtoupper(trim($_POST['aspirante_curp']));
    $nip = $_POST['aspirante_password'];
    $captcha = $_POST['aspirante_captcha'];

    // Validar CURP y NIP en la base de datos
    try {
        $query = "SELECT curp_registrada, password FROM aspirantes_registrados WHERE curp_registrada = :curp LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':curp', $curp);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verificar el NIP
            if (password_verify($nip, $user['password'])) {
                $_SESSION['ASP'] = $curp; 
                // Redirigir sin mostrar mensaje
                header("Location: /SIIV20/modulos/aspirantes/index.php");
                exit();
            } else {
                echo "<script>alert('NIP incorrecto'); window.location.href = '/SIIV20/index.php';</script>";
            }
        } else {
            echo "<script>alert('CURP no encontrado'); window.location.href = '/SIIV20/index.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>