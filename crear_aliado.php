<?php
require "Conexion.php"; 

$message = '';

// Comprobar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturamos los datos del formulario
    $nombre_centro = $_POST['nombre_centro'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $horario_atencion = $_POST['horario_atencion'];
    $especialidades = $_POST['especialidades'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    



    try {
        // Preparar la consulta SQL para insertar el nuevo aliado
        $stmt = $conn->prepare("INSERT INTO centros_medicos (nombre_centro, direccion, telefono, correo_electronico, horario_atencion, especialidades, latitud, longitud, fecha_creacion, fecha_actualizacion)
                                VALUES (:nombre_centro, :direccion, :telefono, :correo_electronico, :horario_atencion, :especialidades, :latitud, :longitud, NOW(), NOW())");
        
        // Vinculamos los parámetros del formulario a la consulta SQL
        $stmt->bindParam(':nombre_centro', $nombre_centro);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo_electronico', $correo_electronico);
        $stmt->bindParam(':horario_atencion', $horario_atencion);
        $stmt->bindParam(':especialidades', $especialidades);
        $stmt->bindParam(':latitud', $latitud);
        $stmt->bindParam(':longitud', $longitud);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            $message = 'Aliado creado exitosamente';
        } else {
            $message = 'Hubo un error al crear el aliado';
        }
    } catch (PDOException $e) {
        // Mostramos el error si ocurre
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Aliado</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<header>
    <?php include "Header/headerAdmin.php"; ?>
</header>

<main>
    <h1>Crear Nuevo Aliado</h1>

    <!-- Mostrar mensaje si hay -->
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Formulario para crear aliado -->
    <form action="crear_aliado.php" method="POST">
        <label for="nombre_centro">Nombre del Centro:</label>
        <input type="text" name="nombre_centro" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required><br>

        <label for="correo_electronico">Correo Electrónico:</label>
        <input type="email" name="correo_electronico" required><br>

        <label for="horario_atencion">Horario de Atención:</label>
        <input type="text" name="horario_atencion" required><br>

        <label for="especialidades">Especialidades: (Odontologia, Medicina General)</label>
        <textarea name="especialidades" rows="4" required></textarea><br>

        <label for="latitud">Latitud:</label>
        <input type="text" name="latitud" required><br>

        <label for="longitud">Longitud:</label>
        <input type="text" name="longitud" required><br><br>

        <input type="submit" value="Crear Aliado">
        <a href="adminAliados.php" class="boton">Atrás</a>
    </form>
</main>

<footer>
    <?php include "Footer/footer.php"; ?>
</footer>

</body>
</html>
