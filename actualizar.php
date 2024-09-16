

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>

    <script src="https://kit.fontawesome.com/bf528d3bda.js" crossorigin="anonymous"></script>
</head>
<body>
            <!-- Inicio del header -->
            <?php include "Header/headerLogin.php"; ?>
             <!-- fin del header -->
  

    <?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: inicio.php');
    exit();
}

require 'Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $Nombre = $conn->real_escape_string($_POST['Nombre']);
        $Apellido = $conn->real_escape_string($_POST['Apellido']);
        $Edad = $conn->real_escape_string($_POST['Edad']);
        $Genero = $conn->real_escape_string($_POST['Genero']);
        $email = $conn->real_escape_string($_POST['email']);

        // Actualizar la contraseña solo si se ha introducido una nueva
        if (!empty($_POST['password']) && $_POST['password'] === $_POST['confirm_password']) {
            $password = $conn->real_escape_string($_POST['password']);
            $sql = "UPDATE users SET Nombre='$Nombre', Apellido='$Apellido', Edad='$Edad', Genero='$Genero', email='$email', password='$password' WHERE email='{$_SESSION['email']}'";
        } else {
            $sql = "UPDATE users SET Nombre='$Nombre', Apellido='$Apellido', Edad='$Edad', Genero='$Genero', email='$email' WHERE email='{$_SESSION['email']}'";
        }

        if ($conn->query($sql) === TRUE) {
            $_SESSION['email'] = $email; // Actualizar la sesión con el nuevo email si se ha cambiado
            echo "<p class='success'>Datos actualizados exitosamente</p>";
        } else {
            echo "<p class='error'>Error actualizando datos: " . $conn->error . "</p>";
        }
    } elseif (isset($_POST['delete'])) {
        // Eliminar la cuenta del usuario
        $delete_sql = "DELETE FROM users WHERE email='{$_SESSION['email']}'";

        if ($conn->query($delete_sql) === TRUE) {
            session_destroy(); // Terminar la sesión
            header('Location: inicio.php'); // Redirigir al inicio de sesión
            exit();
        } else {
            echo "<p class='error'>Error al eliminar la cuenta: " . $conn->error . "</p>";
        }
    }

    $conn->close();
}
?>

    </body>

    <!-- Inicio del Footer -->

    <?php
        include "Footer/footer.php";

    ?>
</body>

</html>