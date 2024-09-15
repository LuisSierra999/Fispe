<?php
session_start();

// redirige a la página de bienvenida, si hay Conexion 
if (isset($_SESSION["email"])) {
    header("Location: Bienvenida.php");
    exit();
}

require "Conexion.php"; // conexion DB

$message = "";

if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    // Preparar la consulta SQL utilizando placeholders con mysqli
    $stmt = $conn->prepare("SELECT email, password FROM users WHERE email = ?");
    
    // Vincular parámetros
    $stmt->bind_param("s", $_POST["email"]); // "s" dice qie es un String

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $_POST["password"] === $user["password"]) {  // Comparar contraseñas
        $_SESSION["email"] = $user["email"];  // Asignar el email del usuario a la sesión
        header("Location: Bienvenida.php");  // Redirigir a la página de bienvenida
        exit();
    } else {
        $message = "Por Favor Valida los Datos Ingresados"; // Sms Error
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