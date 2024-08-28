<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Fispe</title>
  <link rel="stylesheet" href="css/Registro.css">
  <script src="https://kit.fontawesome.com/bf528d3bda.js" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <div class="wrapper">
        <div class="logo">Registro</div>
        <img src="img/logo.png">
        <nav>
            <a href="Registro.php">Regístrate Aquí</a>
            <a href="inicio.php">Inicio de Sesión</a>
        </nav>
    </div>    
</header>
  <div class="contenido">
    <figure>
      <img class="image" src="https://images.ctfassets.net/86mn0qn5b7d0/4fZbVqfHvEeCgrjtyMitpr/d7f369da6da311f5757001ad97c0db6f/iStock-1385436395.jpg?fm=jpg&fl=progressive&q=50&w=1200" alt="atención1">
      <img class="image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoSK1wndnFNyvGLcbOB_MBuFluqTG1TpWXbXV2rx0jPA&s" alt="atención2">
      <img class="image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGlEGTYzJVw8aPFJuQVyOp2Ck3JOqgkaRarW3hziGsVg&s" alt="atención3">
    </figure>
  </div>
    <div class="label" >
      <form action="Registro.php" method="post">
        <label for="Nombre">Nombre</label>
        <input class="field" type="text" name= "Nombre" placeholder="Nombre" required>
        <label for="Apellido">Apellido</label>
        <input class="field" type="text" name= "Apellido" placeholder="Apellido" required>
        <label for="email">E-Mail </label>
        <input class="field" type="email" name= "email" placeholder="juanita.perez@gmail.com" required>
        <label for="Edad">Edad </label>
        <input class="field" type="number" name= "Edad" placeholder="48" min="0" max="99" required><br>
        <input class="inline" type="radio" value="Hombre" name= "Genero" required>
        <label for="Hombre">Hombre</label>
        <input class="inline" type="radio"  value="Mujer" name= "Genero">
        <label for="Mujer">Mujer</label><br>
        <label for="password">Contraseña:</label>
        <input class="field" type="password"  name="password" placeholder="Contraseña" required>
        <label for="confirm_password">Confirmar Contraseña:</label>
        <input class="field" type="password" id="confirm_password" name="confirm_password" placeholder="Confirma la Contraseña" required><br>
        <input class="inline" type="checkbox" id="Términos" name= "Términos" required> 
        <label for="Términos" required>Términos y Condiciones </label><a target="_blank" href="doc/terminosycondiciones.pdf"> Ver </a><br>
        <input class="inline" type="checkbox" id="Políticas" name= "Políticas" required> 
        <label for="Políticas" required>Políticas Privacidad</label> <a target="_blank" href="doc/privacidad.pdf">Ver</a><br> 
        <input class="submit" type="submit" value="Registrarse">
     </form>
    </div>


    <?php

include 'Conexion.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recibir datos del formulario
  $Nombre = $conn->real_escape_string($_POST['Nombre']);
  $Apellido = $conn->real_escape_string($_POST['Apellido']);
  $email = $conn->real_escape_string($_POST['email']);
  $Edad = $conn->real_escape_string($_POST['Edad']);
  $Genero = $conn->real_escape_string($_POST['Genero']);
  $password = $conn->real_escape_string($_POST['password']); 


  // Verificar si las contraseñas coinciden
  if ($_POST['password'] !== $_POST['confirm_password']) {
      die("Las contraseñas no coinciden.");
  }

 // Insertar en la base de datos
 $sql = "INSERT INTO users (Nombre, Apellido, email, Edad, Genero, password) 
 VALUES ('$Nombre', '$Apellido', '$email', '$Edad', '$Genero', '$password')";

if ($conn->query($sql) === TRUE) {
echo "<div class='sms'>Registro exitoso </div>";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar conexión
$conn->close();
}
?>


  <!--Pie de Página-->
  <footer class="pie_pagina">
    <div class="grupo_1">
        <div class="box">
            <figure>
                <img src="img/logo.png" alt="logo">
            </figure>
        </div>
        <div class="box">
            <h2>SOBRE NOSOTROS</h2>
              <a href="doc/terminosycondiciones.pdf">Términos y Condiciones</a><br>
              <a href="doc/privacidad.pdf">Políticas de Privacidad y Almacenamiento de Datos</a>
        </div>
        <div class="box">
            <h2>SÍGUENOS</h2>
            <div class="red_social">
                <a href="#"class="fa fa-facebook"></a>
                <a href="#"class="fa fa-instagram"></a>
                <a href="#"class="fa fa-youtube"></a>
            </div>
        </div>
    </div>
    <div class="grupo_2">
        <small>&copy;2024 <b>-Fispe-</b>Todos los Derechos Reservados.</small>
    </div>
</footer>
</body>

</html>