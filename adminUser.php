<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['email']) || $_SESSION['role_id'] != 1) {
    // Si no es administrador, redirigir a la página de inicio
    header("Location: Bienvenida.php");
    exit();
}

require "Conexion.php"; // Conexión a la base de datos

// Obtener todos los usuarios
try {
    $stmt = $conn->query("SELECT user_id, nombre, apellido, email, role_id FROM users");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los usuarios: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<header>
    <?php include "Header/headerAdmin.php"; ?> <!-- Encabezado común -->
</header>

<main>
    <h1>Administrar Usuarios</h1>

    <!-- Botón para crear un nuevo usuario -->
    <div>
        <a href="crear_usuario.php" class="btn btn-primary" style="margin-bottom: 20px;">Crear Nuevo Usuario</a>
    </div>

    <!-- Tabla de usuarios -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['user_id']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['apellido']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td>
                        <?php
                        if ($usuario['role_id'] == 1) {
                            echo "Administrador";
                        } else {
                            echo "Cliente";
                        }
                        ?>
                    </td>
                    <td>
                        <!-- Botones de acción (editar y eliminar) -->
                        <a href="editar_usuario.php?id=<?php echo $usuario['user_id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="eliminar_usuario.php?id=<?php echo $usuario['user_id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
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