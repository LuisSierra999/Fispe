<?php
session_start();
require "Conexion.php"; // Conexión a la base de datos

// Verificar si el usuario tiene permisos de administrador
if (!isset($_SESSION['email']) || $_SESSION['role_id'] != 1) {
    // Si no es administrador, redirigir a la página de inicio
    header("Location: Bienvenida.php");
    exit();
}

// Obtener todos los aliados
try {
    $stmt = $conn->query("SELECT * FROM centros_medicos");
    $aliados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los aliados: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Aliados</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<header>
    <?php include "Header/headerAdmin.php"; ?> <!-- Encabezado común -->
</header>

<main>
    <h1>Administrar Aliados</h1>

    <!-- Botón para crear un nuevo aliado -->
    <div>
        <a href="crear_aliado.php" class="btn btn-primary" style="margin-bottom: 20px;">Crear Nuevo Aliado</a>
    </div>

    <!-- Tabla de aliados -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Centro</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Horario de Atención</th>
                <th>Especialidades</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Fecha Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aliados as $aliado): ?>
                <tr>
                    <td><?php echo $aliado['centro_id']; ?></td>
                    <td><?php echo $aliado['nombre_centro']; ?></td>
                    <td><?php echo $aliado['direccion']; ?></td>
                    <td><?php echo $aliado['telefono']; ?></td>
                    <td><?php echo $aliado['correo_electronico']; ?></td>
                    <td><?php echo $aliado['horario_atencion']; ?></td>
                    <td><?php echo $aliado['especialidades']; ?></td>
                    <td><?php echo $aliado['latitud']; ?></td>
                    <td><?php echo $aliado['longitud']; ?></td>
                    <td><?php echo $aliado['fecha_creacion']; ?></td>
                    <td class="actions">
                        <!-- Botones de acción (editar y eliminar) -->
                        <a href="editar_aliado.php?id=<?php echo $aliado['centro_id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="eliminar_aliado.php?id=<?php echo $aliado['centro_id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este aliado?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<!--Pie de Página-->
<footer>
    <?php include "Footer/footer.php"; ?>
</footer>

</body>
</html>
