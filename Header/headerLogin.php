<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'Conexion.php'; // Asegúrate de que 'Conexion.php' esté configurado para usar PDO y que $conn esté definido

// Obtener los datos actuales del usuario
    $email = $_SESSION['email'];
    $sql = 'SELECT Nombre FROM users WHERE email = :email';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar que se obtuvo el usuario
if (!$user) {
    echo 'Usuario no encontrado.';
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido <?php echo htmlspecialchars($user['Nombre']); ?></title>
    <link rel="stylesheet" href="css/headerLogin.css">
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="logo">
                Bienvenido <?php echo htmlspecialchars($user['Nombre']); ?>
            </div>
            <img src="img/logo.png" alt="Logo Fispe" width="100"/> 
            <nav>
                <a href="Bienvenida.php">Bienvenida</a>
                <a href="quienesSomos.php">¿Quiénes Somos?</a>
                <a href="aliados.php">Aliados en Salud</a>
                <a href="fispe.php">Ficha de Seguimiento</a>
                <!-- <a href="contacto.php">Contacto</a> -->
                <a href="actualizacion.php">Actualizar Cuenta</a>
                <a href="salir.php">Cerrar Sesión</a>
            </nav>
        </div>
    </header>
</body>
</html>



