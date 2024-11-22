<?php
// Establece las variables de conexión a la base de datos
$host = 'localhost'; // o 127.0.0.1
$dbname = 'my_sql_db';  // Asegúrate de que este es el nombre correcto de tu base de datos
$username = 'root';
$password = '';  // Contraseña para el usuario 'root', si hay una

try {
    // Crea un nuevo objeto PDO y pasa las variables de conexión
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Establece el modo de error de PDO a excepción para manejar los errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Maneja la excepción si la conexión falla
    die("No se pudo conectar a la base de datos $dbname :" . $e->getMessage());
}
?>

