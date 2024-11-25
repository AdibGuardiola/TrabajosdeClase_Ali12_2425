<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verifica si el usuario ya existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->rowCount() > 0) {
        echo "El nombre de usuario o correo electrónico ya están registrados.";
    } else {
        // Inserta el nuevo usuario
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $password])) {
            $_SESSION['username'] = $username; // Guarda el nombre de usuario en la sesión
            header("Location: ../index.php"); // Redirige a la página de bienvenida
            exit;
        } else {
            echo "Error en el registro.";
        }
    }
}
?>
