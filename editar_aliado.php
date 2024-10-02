<?php
require "Conexion.php"; // Conexión a la base de datos

$message = '';

// Verificar si se ha enviado el ID del centro médico a editar
if (isset($_GET['id'])) {
    $centro_id = $_GET['id'];

    // Obtener los datos del centro médico con ese ID
    $stmt = $conn->prepare('SELECT * FROM centros_medicos WHERE centro_id = :centro_id');
    $stmt->bindParam(':centro_id', $centro_id);
    $stmt->execute();
    $centro = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el centro médico
    if (!$centro) {
        $message = 'Centro médico no encontrado';
    }
}

// Actualizar los datos del centro médico cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_centro = $_POST['nombre_centro'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $horario_atencion = $_POST['horario_atencion'];
    $especialidades = $_POST['especialidades'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    try {
        // Preparar la consulta SQL para actualizar el centro médico
        $stmt = $conn->prepare("UPDATE centros_medicos SET 
            nombre_centro = :nombre_centro, 
            direccion = :direccion, 
            telefono = :telefono, 
            correo_electronico = :correo_electronico, 
            horario_atencion = :horario_atencion, 
            especialidades = :especialidades, 
            latitud = :latitud, 
            longitud = :longitud, 
            fecha_actualizacion = NOW()
            WHERE centro_id = :centro_id");

        // Vincular los parámetros del formulario a la consulta SQL
        $stmt->bindParam(':nombre_centro', $nombre_centro);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo_electronico', $correo_electronico);
        $stmt->bindParam(':horario_atencion', $horario_atencion);
        $stmt->bindParam(':especialidades', $especialidades);
        $stmt->bindParam(':latitud', $latitud);
        $stmt->bindParam(':longitud', $longitud);
        $stmt->bindParam(':centro_id', $centro_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $message = 'Centro médico actualizado exitosamente';
            // Refrescar los datos del centro médico después de la actualización
            $stmt = $conn->prepare('SELECT * FROM centros_medicos WHERE centro_id = :centro_id');
            $stmt->bindParam(':centro_id', $centro_id);
            $stmt->execute();
            $centro = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $message = 'Error al actualizar el centro médico';
        }
    } catch (PDOException $e) {
        // Mostrar el error si ocurre
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Centro Médico</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<header>
    <?php include "Header/headerAdmin.php"; ?>
</header>

<main>
    <h1>Editar Centro Médico</h1>

    <!-- Mostrar mensaje si hay -->
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Comprobar si se ha encontrado el centro médico -->
    <?php if (!empty($centro)): ?>
        <!-- Formulario de edición de centro médico -->
        <form action="editar_aliado.php?id=<?php echo $centro['centro_id']; ?>" method="POST">
            <label for="nombre_centro">Nombre del Centro:</label>
            <input type="text" name="nombre_centro" value="<?php echo $centro['nombre_centro']; ?>" required><br>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" value="<?php echo $centro['direccion']; ?>" required><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo $centro['telefono']; ?>" required><br>

            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" name="correo_electronico" value="<?php echo $centro['correo_electronico']; ?>" required><br>

            <label for="horario_atencion">Horario de Atención:</label>
            <input type="text" name="horario_atencion" value="<?php echo $centro['horario_atencion']; ?>" required><br>

            <label for="especialidades">Especialidades:</label>
            <textarea name="especialidades" rows="4" required><?php echo $centro['especialidades']; ?></textarea><br>

            <label for="latitud">Latitud:</label>
            <input type="text" name="latitud" value="<?php echo $centro['latitud']; ?>" required><br>

            <label for="longitud">Longitud:</label>
            <input type="text" name="longitud" value="<?php echo $centro['longitud']; ?>" required><br><br>

            <input type="submit" value="Actualizar Centro Médico">
            <a href="adminAliados.php" class="boton">Atrás</a>
        </form>
    <?php else: ?>
        <p>No se encontró el centro médico</p>
    <?php endif; ?>

</main>

<footer>
    <?php include "Footer/footer.php"; ?>
</footer>

</body>
</html>
