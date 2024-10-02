<?php
 $mensaje = "Bienvenido a la ventana emergente de cita médica.";
 $fecha = date("d/m/Y");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cita Medica</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <div>
        <h1>Agrega un control Medico</h1>
        <form method="POST" action="guardar_control_medico.php">
                <TD>Presión Arterial</TD>
                <input type="text" name="presion" placeholder="Presión Arterial">
                <TD>Talla</TD>
                <input type="text" name="talla" placeholder="Talla">
                <TD>Peso</TD>
                <input type="text" name="peso" placeholder="Peso">
                <TD>Glicemia</TD>
                <input type="text" name="glicemia" placeholder="Glicemia">
                <button type="submit">Agregar Datos</button>
            </form>
    </div>
</body>
</html>