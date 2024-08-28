<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: inicio.php');
    exit();
}

require 'Conexion.php';

// Obtener los datos actuales del usuario
$email = $_SESSION['email'];
$stmt = $conn->prepare('SELECT Nombre, Apellido, Edad, Genero, email FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Datos</title>
    <link rel="stylesheet" href="css/actualizacion.css">
    <script src="https://kit.fontawesome.com/bf528d3bda.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="wrapper">
            <div class="logo">Bienvenidos a FISPE</div>
            <img src="img/logo.png" alt="Logo Fispe" width="100"/> 
            <nav>
                <a href="Bienvenida.php">Bienvenida</a>
                <a href="quienesSomos.php">¿Quiénes Somos?</a>
                <a href="aliados.php">Aliados en Salud</a>
                <a href="fispe.php">Ficha de Seguimiento</a>
                <a href="contacto.php">Contacto</a>
                <a href="actualizacion.php">Actualizar Cuenta</a>
                <a href="salir.php">Cerrar Cesion</a>
            </nav>
        </div>
    </header>

    <div class="contenido">
        <form method="post" action="actualizar.php">
            <label for="Nombre">Nombre:</label><br>
            <input class="field" type="text" name="Nombre" value="<?php echo htmlspecialchars($user['Nombre']); ?>" required><br>

            <label for="Apellido">Apellido:</label><br>
            <input class="field" type="text" name="Apellido" value="<?php echo htmlspecialchars($user['Apellido']); ?>" required><br>

            <label for="Edad">Edad:</label><br>
            <input class="field" type="text" name="Edad" value="<?php echo htmlspecialchars($user['Edad']); ?>" required><br>

            <label for="Genero">Género:</label><br>
            <input class="field" type="text" name="Genero" value="<?php echo htmlspecialchars($user['Genero']); ?>" required><br>

            <label for="email">Email:</label><br>
            <input class="field" type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

            <label for="new_password">Nueva Contraseña:</label><br>
            <input class="field" type="password" name="new_password"><br>

            <label for="confirm_password">Confirmar Nueva Contraseña:</label><br>
            <input class="field" type="password" name="confirm_password"><br>

            <input class="submit" type="submit" name="update" value="Actualizar Datos">
            <input class="submit delete" type="submit" name="delete" value="Eliminar Cuenta">
        </form>

        <?php if(!empty($message)): ?>
        <div class="sms"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
    </div>
    
    <!-- Pie de Página -->
    <footer class="pie_pagina">
        <div class="grupo_1">
            <div class="box">
                <figure>
                    <img src="img/logo.png" alt="logo">
                </figure>
            </div>
            <div class="box">
                <h2>SOBRE NOSOTROS</h2>
                <a href="doc/terminosycondiciones.pdf">Términos y Condiciones</a><br>
                <a href="doc/privacidad.pdf">Políticas de Privacidad y Almacenamiento de Datos</a>
            </div>
            <div class="box">
                <h2>SÍGUENOS</h2>
                <div class="red_social">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-instagram"></a>
                    <a href="#" class="fa fa-youtube"></a>
                </div>
            </div>
        </div>
        <div class="grupo_2">
            <small>&copy;2024 <b>-Fispe-</b> Todos los Derechos Reservados.</small>
        </div>
    </footer>
</body>
</html>
