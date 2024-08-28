<?php
$servername = "localhost";  // Cambia esto si tu servidor es diferente
$username = "root";    // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$dbname = "fispe"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);}
// else {
//     echo "Conexion Exitosa a la DB";
// }
