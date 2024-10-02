<?php
session_start();
require "Conexion.php"; // Conexión a la base de datos

$message = '';

// Verificar si el usuario tiene permisos de administrador
if (!isset($_SESSION['email']) || $_SESSION['role_id'] != 1) {
    // Si no es administrador, redirigir a la página de inicio
    header("Location: Bienvenida.php");
    exit();
}

// Verificar si se ha pasado el ID del usuario en la URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Verificar si se ha confirmado la eliminación
    if (isset($_POST['confirmar'])) {
        try {
            // Preparar la consulta SQL para eliminar al usuario
            $stmt = $conn->prepare('DELETE FROM users WHERE user_id = :user_id');
            $stmt->bindParam(':user_id', $user_id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $message = 'Usuario eliminado exitosamente';
                // Redirigir a la página de administración de usuarios
                header("Location: editar_usuario.php");
                exit();
            } else {
                $message = 'Error al eliminar el usuario';
            }
        } catch (PDOException $e) {
            // Mostrar el error si ocurre
            $message = "Error: " . $e->getMessage();
        }
    }
} else {
    // Si no se pasa el ID del usuario, redirigir de nuevo
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="css/admin.css"> <!-- Aquí puedes enlazar tus estilos -->
</head>
<body>

<header>
    <?php include "Header/headerAdmin.php"; ?>
</header>

<main>
    <h1>Eliminar Usuario</h1>

    <!-- Mostrar mensaje si hay -->
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php else: ?>
        <p>¿Estás seguro de que deseas eliminar al usuario ya que se perdera toda la información?</p> <br><br>

        <!-- Formulario de confirmación -->
        <form action="eliminar_usuario.php?id=<?php echo htmlspecialchars($user_id); ?>" method="POST">
            <input type="hidden" name="confirmar" value="true">
            <input type="submit" value="Confirmar Eliminación" class="btn btn-danger">
        </form>

        <!-- Botón de Cancelar -->
        <a href="administrar_usuarios.php" class="btn btn-back">Cancelar</a>
    <?php endif; ?>
</main>

<footer>
    <?php include "Footer/footer.php"; ?>
</footer>

</body>
</html>
