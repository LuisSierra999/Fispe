<?php
// Verificar que el formulario se ha enviado con el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = htmlspecialchars(trim($_POST['e-mail']));
    $comentario = htmlspecialchars(trim($_POST['comentario']));
    
    // Validación básica de los campos
    if (!empty($nombre) && !empty($email) && !empty($comentario) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Asunto del correo
        $asunto = "Nueva Sugerencia - " . $nombre;
        
        // Destinatario
        $destinatario = "support@fispe.online";
        
        // Cuerpo del correo
        $mensaje = "Nombre: $nombre\n";
        $mensaje .= "Email: $email\n\n";
        $mensaje .= "Comentario:\n$comentario\n";
        
        // Cabeceras del correo
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Enviar el correo
        if (mail($destinatario, $asunto, $mensaje, $headers)) {
            echo "<p>Correo enviado exitosamente. ¡Gracias por Contactarnos!</p>";
        } else {
            echo "<p>Error al enviar el correo. Por favor, inténtelo de nuevo.</p>";
        }
    } else {
        echo "<p>Por favor completa todos los campos correctamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="css/contacto.css">
    <script src="https://kit.fontawesome.com/bf528d3bda.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Inicio del header -->
    <?php include "Header/headerLogin.php"; ?>
    <!-- Fin del header -->

    <br>
    <div class="label">    
        <!-- Formulario de contacto con la ruta corregida -->
        <form action="contacto.php" method="POST">
            <label for="nombre">Nombre</label>
            <input class="field" type="text" id="nombre" name="nombre" placeholder="Nombre y Apellido" required />
            <br>
            <label for="e-mail">e-mail</label>
            <input class="field" type="email" id="e-mail" name="e-mail" placeholder="fispe@fispe.com" required />
            <br>
            <label for="comentario">Comentario</label>
            <textarea class="field" cols="45" rows="5" id="comentario" placeholder="Ingrese Comentario" name="comentario" required></textarea>
            <br>
            <button class="submit" type="submit">Enviar</button>
        </form>
    </div>  
    <br>
    <br>
    <br>
    <br>

    <!-- Pie de página -->
    <?php include "Footer/footer.php"; ?>
</body>
</html>
