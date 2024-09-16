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
             <!-- fin del header -->
    <br>
    <div class="label">    
        <form action="/formulario" method="POST">
            <label for="nombre">Nombre</label>
            <input class="field" type="text" id="nombre" name="nombre" placeholder="Nombre y Apellido"/>
            <br>
            <label for="e-mail">e-mail</label>
            <input class="field" type="email" id="e-mail" name="e-mail" placeholder="fispe@fispe.com"/>
            <br>
            <label for="comentario">Comentario</label>
            <textarea class="field" cols="45" rows="5" id="comentario" placeholder="Ingrese Comentario" name="comentario"></textarea>
            <br>
            <button class="submit" type="submit">Enviar</button>
        </form>
    </div>  
    <br>
    <br>
    <br>
    <br>
<!--Pie de Página-->
            <?php
               include "Footer/footer.php";

           ?>
</body>

</html>