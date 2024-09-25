
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="css/actualizacion.css">
    <script src="https://kit.fontawesome.com/bf528d3bda.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Inicio del header -->
    <header>
        <div class="wrapper">
            <div class="logo">
                Bienvenido             </div>
            <img src="img/logo.png" alt="Logo Fispe" width="100"/> 
            <nav>
                <a href="Bienvenida.php">Bienvenida</a>
                <a href="quienesSomos.php">¿Quiénes Somos?</a>
                <a href="aliados.php">Aliados en Salud</a>
                <a href="fispe.php">Ficha de Seguimiento</a>
                <a href="contacto.php">Contacto</a>
                <a href="actualizacion.php">Actualizar Cuenta</a>
                <a href="salir.php">Cerrar Sesión</a>
            </nav>
        </div>
    </header>
    <!-- Fin del header -->

    <?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('Location: inicio.php');
        exit();
    }

    require 'Conexion.php'; // Asegúrate de que 'Conexion.php' esté configurado para usar PDO

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            if (isset($_POST['update'])) {
                $Nombre = $_POST['Nombre'];
                $Apellido = $_POST['Apellido'];
                $Edad = $_POST['Edad'];
                $Genero = $_POST['Genero'];
                $email = $_POST['email'];

                // Actualizar la contraseña solo si se ha introducido una nueva
                if (!empty($_POST['new_password']) && $_POST['new_password'] === $_POST['confirm_password']) {
                    $hashed_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET Nombre = :Nombre, Apellido = :Apellido, Edad = :Edad, Genero = :Genero, email = :email, password = :password WHERE email = :session_email";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':password', $hashed_password);
                } else {
                    $sql = "UPDATE users SET Nombre = :Nombre, Apellido = :Apellido, Edad = :Edad, Genero = :Genero, email = :email WHERE email = :session_email";
                    $stmt = $conn->prepare($sql);
                }

                $stmt->bindParam(':Nombre', $Nombre);
                $stmt->bindParam(':Apellido', $Apellido);
                $stmt->bindParam(':Edad', $Edad);
                $stmt->bindParam(':Genero', $Genero);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':session_email', $_SESSION['email']);

                if ($stmt->execute()) {
                    $_SESSION['email'] = $email; // Actualizar la sesión con el nuevo email si se ha cambiado
                    echo "<p class='success'>Datos actualizados exitosamente</p>";
                } else {
                    echo "<p class='error'>Error actualizando datos</p>";
                }
            } elseif (isset($_POST['delete'])) {
                // Eliminar la cuenta del usuario
                $delete_sql = "DELETE FROM users WHERE email = :session_email";
                $stmt = $conn->prepare($delete_sql);
                $stmt->bindParam(':session_email', $_SESSION['email']);

                if ($stmt->execute()) {
                    session_destroy(); // Terminar la sesión
                    header('Location: inicio.php'); // Redirigir al inicio de sesión
                    exit();
                } else {
                    echo "<p class='error'>Error al eliminar la cuenta</p>";
                }
            }
        } catch (PDOException $e) {
            echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
        }
    }

    // Cierra la conexión
    $conn = null;
    ?>

    <!-- Inicio del Footer -->
    <?php include "Footer/footer.php"; ?>
</body>

</html>
