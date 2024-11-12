<?php
session_start();
require 'Conexion.php';

$message = ""; // Variable para almacenar mensajes

// Verificar si el user_id está en la sesión
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Obtener el user_id desde la sesión

    // Procesar el formulario al enviar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_vacuna = $_POST['nombre_vacuna'];
        $fecha_aplicacion = $_POST['fecha_aplicacion'];
        $observaciones = $_POST['observaciones'];

        // Insertar la vacuna en la base de datos
        $sql = "INSERT INTO vacunas (user_id, nombre_vacuna, fecha_aplicacion, observaciones) VALUES (:user_id, :nombre_vacuna, :fecha_aplicacion, :observaciones)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':nombre_vacuna', $nombre_vacuna);
        $stmt->bindParam(':fecha_aplicacion', $fecha_aplicacion);
        $stmt->bindParam(':observaciones', $observaciones);

        if ($stmt->execute()) {
            $message = "Vacuna registrada exitosamente.";
        } else {
            $message = "Error al registrar la vacuna.";
        }
    }
} else {
    $message = "Error: No se ha establecido el user_id en la sesión.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vacuna</title>
    <link rel="stylesheet" href="css/fispejc.css">
</head>
<body>

<header>
    <?php include "Header/headerLogin.php"; ?>
</header>

<main>
    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Formulario de registro de vacuna -->
    <form action="crear_vacuna.php" method="POST">
        <label for="nombre_vacuna">Nombre de la Vacuna:</label>
        <input type="text" name="nombre_vacuna" id="nombre_vacuna" required>

        <label for="fecha_aplicacion">Fecha de Aplicación:</label>
        <input type="date" name="fecha_aplicacion" id="fecha_aplicacion" required>

        <label for="observaciones">Observaciones:</label>
        <textarea name="observaciones" id="observaciones" rows="4"></textarea>

        <button type="submit">Registrar Vacuna</button>
    </form>
</main>

<!--Pie de Página-->
            <?php
               include "Footer/footer.php";

            ?>

</body>
</html>
