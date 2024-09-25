<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: inicio.php');
    exit();
}

require 'Conexion.php'; // Asegúrate de que 'Conexion.php' esté configurado para usar PDO

// Obtener los datos actuales del usuario
$email = $_SESSION['email'];
$sql = 'SELECT Nombre, Apellido, Edad, Genero, email FROM users WHERE email = :email';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <!-- Inicio del header -->
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
                <a href="contacto.php">Contacto</a>
                <a href="actualizacion.php">Actualizar Cuenta</a>
                <a href="salir.php">Cerrar Sesión</a>
            </nav>
        </div>
    </header>
    <!-- Fin del header -->

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

        <?php if (!empty($message)): ?>
        <div class="sms"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
    </div>
    
    <!-- Pie de Página -->
    <?php include "Footer/footer.php"; ?>
</body>
</html>

