<?php
$servername = "localhost";  // Servidor
$username = "root";    // Usuario DB
$password = ""; // Contraseña DB
$dbname = "fispe"; // Nombre DB

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Establecer el modo de error de PDO para que lance excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Conexión exitosa a la base de datos"; // SMS prueba de conexión
} catch (PDOException $e) {
    // Si ocurre un error, lo capturamos y mostramos el mensaje
    die("Conexión fallida: " . $e->getMessage());
}
?>
