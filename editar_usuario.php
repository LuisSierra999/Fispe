<?php
require "Conexion.php"; // Conexión a la base de datos

$message = '';

// Verificar si se ha enviado el ID del usuario
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Obtener los datos del usuario con ese ID
    $stmt = $conn->prepare('SELECT * FROM users WHERE user_id = :user_id');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el usuario
    if (!$usuario) {
        $message = 'Usuario no encontrado';
    }
}

// Actualizar los datos del usuario cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $genero = $_POST['genero'];
    $role_id = $_POST['role_id']; // Rol del usuario

    // Actualizar la contraseña solo si el campo no está vacío
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash de la nueva contraseña
    } else {
        $password = $usuario['password']; // Mantener la contraseña existente
    }

    try {
        // Preparar la consulta SQL para actualizar el usuario
        $stmt = $conn->prepare("UPDATE users SET 
            nombre = :nombre, 
            apellido = :apellido, 
            email = :email, 
            edad = :edad, 
            genero = :genero, 
            password = :password, 
            role_id = :role_id 
            WHERE user_id = :user_id");

        // Vinculamos los parámetros del formulario a la consulta SQL
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':user_id', $user_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $message = 'Usuario actualizado exitosamente';
            // Refrescar los datos del usuario después de la actualización
            $stmt = $conn->prepare('SELECT * FROM users WHERE user_id = :user_id');
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $message = 'Error al actualizar el usuario';
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
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<header>
    <?php include "Header/headerAdmin.php"; ?>
</header>

<main>
    <h1>Editar Usuario</h1>

    <!-- Mostrar mensaje si hay -->
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Comprobar si se ha encontrado el usuario -->
    <?php if (!empty($usuario)): ?>
        <!-- Formulario de edición de usuario -->
        <form action="editar_usuario.php?id=<?php echo $usuario['user_id']; ?>" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" value="<?php echo $usuario['apellido']; ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required><br>

            <label for="edad">Edad:</label>
            <input type="number" name="edad" value="<?php echo $usuario['edad']; ?>" min="1" required><br>

            <label for="genero">Género:</label>
            <select name="genero" required>
                <option value="Hombre" <?php if ($usuario['genero'] == 'Hombre') echo 'selected'; ?>>Hombre</option>
                <option value="Mujer" <?php if ($usuario['genero'] == 'Mujer') echo 'selected'; ?>>Mujer</option>
  
            </select><br>

            <label for="password">Contraseña (dejar en blanco para mantener la actual):</label>
            <input type="password" name="password" placeholder="Nueva contraseña"><br>

            <label for="role_id">Rol:</label>
            <select name="role_id">
                <option value="2" <?php if ($usuario['role_id'] == 2) echo 'selected'; ?>>Cliente</option>
                <option value="1" <?php if ($usuario['role_id'] == 1) echo 'selected'; ?>>Administrador</option>
            </select><br><br>

            <input type="submit" value="Actualizar Usuario">
            <a href="adminUser.php" class="boton">Atras</a>
        </form>
    <?php else: ?>
        <p>No se encontró el usuario</p>
    <?php endif; ?>

</main>

<footer>
    <?php include "Footer/footer.php"; ?>
</footer>

</body>
</html>
