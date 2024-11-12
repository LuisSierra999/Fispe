<?php
session_start();
require 'Conexion.php';

$message = ""; // Variable para almacenar mensajes

// Verificar si el user_id está en la sesión
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Obtener el user_id desde la sesión

    // Procesar el formulario al enviar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $presion_arterial = $_POST['presion_arterial'];
        $talla = $_POST['talla'];
        $peso = $_POST['peso'];
        $glicemia = $_POST['glicemia'];
        $fecha_control = $_POST['fecha_control'];
        $observaciones = $_POST['observaciones'];

        // Insertar el control médico en la base de datos
        $sql = "INSERT INTO controles_medicos (user_id, presion_arterial, talla, peso, glicemia, fecha_control, observaciones) VALUES (:user_id, :presion_arterial, :talla, :peso, :glicemia, :fecha_control, :observaciones)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':presion_arterial', $presion_arterial);
        $stmt->bindParam(':talla', $talla);
        $stmt->bindParam(':peso', $peso);
        $stmt->bindParam(':glicemia', $glicemia);
        $stmt->bindParam(':fecha_control', $fecha_control);
        $stmt->bindParam(':observaciones', $observaciones);

        if ($stmt->execute()) {
            $message = "Control médico registrado exitosamente.";
        } else {
            $message = "Error al registrar el control médico.";
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
    <title>Registrar Control Médico</title>
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

    <!-- Formulario de registro de control médico -->
    <form action="crear_control_medico.php" method="POST">
        <label for="presion_arterial">Presión Arterial:</label>
        <input type="text" name="presion_arterial" id="presion_arterial" required>

        <label for="talla">Talla (m):</label>
        <input type="number" step="0.01" name="talla" id="talla" required>

        <label for="peso">Peso (kg):</label>
        <input type="number" step="0.1" name="peso" id="peso" required>

        <label for="glicemia">Glicemia (mg/dL):</label>
        <input type="number" step="0.1" name="glicemia" id="glicemia" required>

        <label for="fecha_control">Fecha de Control:</label>
        <input type="date" name="fecha_control" id="fecha_control" required>

        <label for="observaciones">Observaciones:</label>
        <textarea name="observaciones" id="observaciones" rows="4"></textarea>

        <button type="submit">Registrar Control Médico</button>
    </form>
</main>

<!--Pie de Página-->
<?php include "Footer/footer.php"; ?>

</body>
</html>
