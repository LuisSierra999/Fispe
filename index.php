<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/headerLogin.css">
    <script src="https://kit.fontawesome.com/bf528d3bda.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="wrapper">
            <img src="img/logo.png">
            <div class="logo">Bienvenidos a FISPE</div>
            <nav>
                <a href="Registro.php">Regístrate Aquí</a>
                <a href="inicio.php">Inicio de Sesión</a>
            </nav>
        </div>    
    </header>
        <section class="contenido wrapper">
            <article class="post">
                <h2>¿Qué es FISPE?</h2>
                    <p>FISPE es una ficha de seguimiento en salud que permite llevar un registro detallado desde sus primeros
                    días hasta su vida adulta. Esto facilita el seguimiento y la detección temprana de problemas de salud y
                    tendencias a lo largo del tiempo. Además, proporciona un historial médico detallado, lo que es esencial
                    para los médicos y profesionales de la salud al tomar decisiones sobre tratamientos y diagnósticos. Esto
                    evita la repetición de pruebas y procedimientos, lo que a su vez puede reducir costos y mejorar la
                    calidad de la atención.</p>
                <img src="img/aliadosalud.png"/>
                <img src="img/medi2.jpg"/>
            </article>
            <br>
            <article class="post">
                <h2>Convenios con importantes EPS y IPS de la región</h2>
                <p>Una herramienta de ayuda para el personal de salud, brindando información relevante del paciente.</p>
                <img src="img/medi1.jpg"/>
                <img src="img/controles.jpg"/>
            </article>
            <br>
            <article class="post">
                <h2>Nuestros Principales Aliados</h2>
                <p>Todos en búsqueda del bienestar de nuestros abuelos y niños.</p>
                <img src="img/sura.png" width="150px" alt="SURA" title="SURA" /> &nbsp &nbsp &nbsp
                <img src="img/comfama.png" width="150px" alt="COMFAMA" title="COMFAMA" /> &nbsp &nbsp  &nbsp
                <img src="img/clinicaMedellin.png" width="150px" alt="CLÍNICA MEDELLÍN"
                    title="CLÍNICA MEDELLÍN" /> 
        </section>
    <br>
<!--Pie de Página-->
    <?php
        include "Footer/footer.php";

    ?>
</body>

</html>