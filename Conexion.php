<?php
$servername = "localhost";  // Servidor
$username = "root";    // Usuario DB
$password = ""; // Contraseña DB
$dbname = "fispe"; // Nombre DB

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);}
// else {
//     echo "Conexion Exitosa a la DB"; // SMS Prueba de Conexion
// }
