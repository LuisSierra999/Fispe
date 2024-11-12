<?php
session_start();
require 'Conexion.php';

$message = ""; // Variable para almacenar mensajes

// Verificar si el user_id está en la sesión
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Obtener el user_id desde la sesión

    // Procesar el formulario al enviar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_medicamento = $_POST['nombre_medicamento'];
        $dosis = $_POST['dosis'];
        $frecuencia = $_POST['frecuencia'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        // Insertar el medicamento en la base de datos
        $sql = "INSERT INTO medicamentos (user_id, nombre_medicamento, dosis, frecuencia, fecha_inicio, fecha_fin) VALUES (:user_id, :nombre_medicamento, :dosis, :frecuencia, :fecha_inicio, :fecha_fin)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':nombre_medicamento', $nombre_medicamento);
        $stmt->bindParam(':dosis', $dosis);
        $stmt->bindParam(':frecuencia', $frecuencia);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);

        if ($stmt->execute()) {
            $message = "Medicamento registrado exitosamente.";
        } else {
            $message = "Error al registrar el medicamento.";
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
    <title>Registrar Medicamento</title>
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

    <!-- Formulario de registro de medicamento -->
    <form action="crear_medicamento.php" method="POST">
        <label for="nombre_medicamento">Nombre del Medicamento:</label>
        <input type="text" name="nombre_medicamento" id="nombre_medicamento" required>

        <label for="dosis">Dosis:</label>
        <input type="text" name="dosis" id="dosis" required>

        <label for="frecuencia">Frecuencia:</label>
        <input type="text" name="frecuencia" id="frecuencia" required>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin">

        <button type="submit">Registrar Medicamento</button>
    </form>
</main>

<!--Pie de Página-->
<?php include "Footer/footer.php"; ?>

</body>
</html>
