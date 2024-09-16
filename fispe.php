<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <img src="img/control_medico.png"/>
            <ul>
                <li>Presión Arterial</li>
                <li>Talla</li>
                <li>Peso</li>
                <li>Glicemia</li>
            </ul>
        </article>
        <br>
        <article class="post">
            <h2>Vacunas</h2>
            <p>Un archivo histórico con fechas y nombres de la aplicación</p>
            <img src="img/vacunas.png"/>
            <ul>
                <li>Listado Actulizado de Vacunas</li>
                <li>Recomendación de aplicación (esquema de vacunación)</li>
            </ul>
            <br>
        </article>
        <article class="post">
            <h2>Medicamentos</h2>
            <p>Registro detallado del medicamento, inicio del tratamiento, recordatorios</p>
            <img src="img/medicamentos.png"/>
            <ul>
                <li>Listado Actulizado de Medicamentos</li>
                <!-- <li>Recordatorios de administración de medicamentos</li> -->
            </ul>
            <br>
        </article>
        <article class="post">
            <h2>¡Un Archivo para Compartir!</h2>
            <p>Comparte con tus familiares y Médicos tratantes informes detallados (históricos)</p>
            <img src="img/descargar.png"/>
            <ul>
                <li>Actualizar datos</li>
                <li>Compartir y/o descargar la ficha de seguimiento personal en salud</li>
                <li>Informe con curvas de seguimiento de los diferentes parámetros registrados (Presión Arterial, Glicemia, Talla, Peso, IMC, etc).</li>
            </ul>
            <br>
            <img src="img/curva.png"/>
        </article>
    </section>
    <br>
   <!--Pie de Página-->
   <?php
               include "Footer/footer.php";

           ?>
</body>

</html>