<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/fispe.css">
    <title>FISPE</title>

    <script src="https://kit.fontawesome.com/bf528d3bda.js" crossorigin="anonymous"></script>
</head>
<body>
           <!-- Inicio del header -->
                <?php include "Header/headerLogin.php"; ?>
             <!-- fin del header -->
    <section class="contenido wrapper">
        <article class="post">
            <h1>Controles Médicos</h1>
            <p>Ingresa datos importantes durante la consulta médica</p>

            <a href="crear_control_medico.php">
            <img src="img/control_medico.png" alt="Descipcion" ></a>
        </article>
        <br>
        <article class="post">
            <h2>Vacunas</h2>
            <p>Un archivo histórico con fechas y nombres de la aplicación</p>
            <a href="crear_vacuna.php">
            <img src="img/vacunas.png" alt="Descipcion" ></a>
            <br>
        </article>
        <article class="post">
            <h2>Medicamentos</h2>
            <p>Registro detallado del medicamento, inicio del tratamiento, recordatorios</p>
            <a href="crear_medicamento.php">
            <img src="img/medicamentos.png"/> </a>

            <br>
        </article>
        <article class="post">
            <h2>¡Un Archivo para Compartir!</h2>
            <p>Comparte con tus familiares y Médicos tratantes informes detallados (históricos)</p>
            <a href="generar_pdf.php"><img src="img/descargar.png"/></a>

            <br>
            <!-- <img src="img/curva.png"/> -->
        </article>
    </section>
    <br>
   <!--Pie de Página-->
   <?php
               include "Footer/footer.php";

           ?>
</body>

</html>

generar_pdf.php