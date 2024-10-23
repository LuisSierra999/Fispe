<?php
require "Conexion.php"; // Conexión a la base de datos

$message = '';

// Verificar si se ha pasado el ID del centro médico a eliminar
if (isset($_GET['id'])) {
    $centro_id = $_GET['id'];

    try {
        // Preparar la consulta SQL para eliminar el centro médico
        $stmt = $conn->prepare('DELETE FROM centros_medicos WHERE centro_id = :centro_id');
        $stmt->bindParam(':centro_id', $centro_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $message = 'Centro médico eliminado exitosamente.';
        } else {
            $message = 'Error al intentar eliminar el centro médico.';
        }
    } catch (PDOException $e) {
        // Mostrar el error si ocurre
        $message = "Error: " . $e->getMessage();
    }
} else {
    // Si no se pasa el ID, mostrar un mensaje de error
    $message = 'No se proporcionó un ID válido para eliminar.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Centro Médico</title>
    <link rel="stylesheet" href="css/admin.css"> <!-- Asegúrate de tener los estilos -->
</head>
<body>

<header>
    <?php include "Header/headerAdmin.php"; ?>
</header>

<main>
    <h1>Eliminar Centro Médico</h1>

    <!-- Mostrar mensaje de éxito o error -->
    <p><?php echo $message; ?></p>

    <!-- Botón para volver atrás -->
    <a href="adminAliados.php" class="boton">Volver Atrás</a>
</main>

<footer>
    <?php include "Footer/footer.php"; ?>
</footer>

</body>
</html>