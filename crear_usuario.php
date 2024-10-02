<?php
require "Conexion.php"; // Asegúrate de que el archivo de conexión esté presente

$message = '';

// Comprobamos si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturamos los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $genero = $_POST['genero'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash de la contraseña
    $role_id = $_POST['role_id']; // Rol del usuario

    try {
        // Preparar la consulta SQL para insertar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO users (nombre, apellido, email, edad, genero, password, fecha, role_id)
                                VALUES (:nombre, :apellido, :email, :edad, :genero, :password, NOW(), :role_id)");
        
        // Vinculamos los parámetros del formulario a la consulta SQL
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role_id', $role_id);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            $message = 'Usuario creado exitosamente';
        } else {
            $message = 'Hubo un error al crear el usuario';
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
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<header>
    <?php include "Header/headerAdmin.php"; ?>
</header>

<main>
    <h1>Crear Nuevo Usuario</h1>

    <!-- Mostrar mensaje si hay -->
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Formulario para crear usuario -->
    <form action="crear_usuario.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="edad">Edad:</label>
        <input type="number" name="edad" min="1" required><br>

        <label for="genero">Género:</label>
        <select name="genero" required>
            <option value="Hombre">Hombre</option>
            <option value="Mujer">Mujer</option>
        
        </select><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>

        <label for="role_id">Rol:</label>
        <select name="role_id">
            <option value="2">Cliente</option>
            <option value="1">Administrador</option>
        </select><br><br>

        <input type="submit" value="Crear Usuario">
        <a href="admin.php" class="boton">Atrás</a>
        <!-- <button onclick="history.back()">Atrás</button> -->
    </form>
</main>

<footer>
    <?php include "Footer/footer.php"; ?>
</footer>

</body>
</html>
