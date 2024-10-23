<?php
session_start();

// Redirige a la página de bienvenida si ya hay una sesión iniciada
if (isset($_SESSION["email"])) {
    if ($_SESSION["role_id"] == 1) {
        header("Location: admin.php");
    } else {
        header("Location: Bienvenida.php");
    }
    exit();
}

require "Conexion.php"; // Conexión a la DB usando PDO

$message = "";

if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    // Preparar la consulta SQL utilizando placeholders con PDO
    $stmt = $conn->prepare("SELECT email, password, role_id FROM users WHERE email = :email");

    // Vincular el parámetro de email
    $stmt->bindParam(':email', $_POST["email"]);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y si la contraseña es válida
    if ($user && password_verify($_POST["password"], $user["password"])) {
        $_SESSION["email"] = $user["email"];  // Asignar el email del usuario a la sesión
        $_SESSION["role_id"] = $user["role_id"];  // Asignar el rol del usuario a la sesión



        // Redirigir según el rol del usuario
        if ($user["role_id"] == 1) {
            header("Location: admin.php");  // Si es admin, redirigir a admin.php
        } else {
            header("Location: Bienvenida.php");  // Si es cliente, redirigir a Bienvenida.php
        }
        exit();
    } else {
        $message = "Por Favor Valida los Datos Ingresados"; // Mensaje de error
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio Sesión</title>
  <link rel="stylesheet" href="css/inicio.css">
  <script src="https://kit.fontawesome.com/bf528d3bda.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="wrapper">

            <a href="index.php">
              <img src="img/logo.png" alt="logo">
            </a>
            <div class="logo">Inicio de Sesión</div>
            <nav>
                <a href="Registro.php">Regístrate Aquí</a>
            </nav>
        </div>    
    </header>
    <div class="contenedor">
        <figure>
          <img class="img" src="https://images.ctfassets.net/86mn0qn5b7d0/4fZbVqfHvEeCgrjtyMitpr/d7f369da6da311f5757001ad97c0db6f/iStock-1385436395.jpg?fm=jpg&fl=progressive&q=50&w=1200" alt="atención1">
          <img class="img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoSK1wndnFNyvGLcbOB_MBuFluqTG1TpWXbXV2rx0jPA&s" alt="atención2">
          <img class="img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGlEGTYzJVw8aPFJuQVyOp2Ck3JOqgkaRarW3hziGsVg&s" alt="atención3">
    </figure>
        </figure>
    </div>
    <main class="main">
        <div class="container" id="iniciosesion" style="margin-top: 50px;">
            <form action="inicio.php" method="post">
                <label for="email">Correo Electrónico:</label><br>
                <input class="field" type="email" name="email" placeholder="juanita.perez@gmail.com" required><br>
                <label for="login-password">Contraseña:</label><br>
                <input class="field" type="password" name="password" placeholder="Contraseña" required><br>
                <input class="submit" type="submit" value="Iniciar Sesión">
                <a href="recuperar_clave.php" class="submit">¿Olvidaste la clave?</a>
            </form>

            
             <!-- Imprime en Pantalla el mensaje de error -->
            <?php if (!empty($message)): ?>
              <div class="sms">
                <p><?php echo $message; ?></p>
               </div>
            <?php endif; ?>
            
        </div>
    </main>

    <!-- inicio del footer -->

    <?php
               include "Footer/footer.php";

           ?>
</body>
</html>