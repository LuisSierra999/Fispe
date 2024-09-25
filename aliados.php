<?php
require 'Conexion.php'; // Asegúrate de que la conexión a la base de datos esté funcionando correctamente

// Obtener los filtros seleccionados por el usuario
$convenio = isset($_GET['convenio']) ? $_GET['convenio'] : '';
$horario = isset($_GET['horario']) ? $_GET['horario'] : '';
$especialidad = isset($_GET['especialidad']) ? $_GET['especialidad'] : '';

// Construir la consulta SQL dinámicamente
$sql = 'SELECT * FROM centros_medicos WHERE 1=1';

// Filtrar por convenio, ignorar si se selecciona "Todos"
if ($convenio != '' && $convenio != 'Todos') {
    $sql .= ' AND nombre_centro LIKE :convenio';
}
// Filtrar por horario, ignorar si se selecciona "Todos"
if ($horario != '' && $horario != 'Todos') {
    $sql .= ' AND horario_atencion LIKE :horario';
}
// Filtrar por especialidad, ignorar si se selecciona "Todos"
if ($especialidad != '' && $especialidad != 'Todas') {
    $sql .= ' AND especialidades LIKE :especialidad';
}

$stmt = $conn->prepare($sql);

// Asignar valores a los parámetros si se filtró por ellos
if ($convenio != '' && $convenio != 'Todos') {
    $convenio = "%$convenio%"; // Uso % para búsquedas parciales con LIKE
    $stmt->bindParam(':convenio', $convenio);
}
if ($horario != '' && $horario != 'Todos') {
    $horario = "%$horario%"; // Uso % para búsquedas parciales con LIKE
    $stmt->bindParam(':horario', $horario);
}
if ($especialidad != '' && $especialidad != 'Todas') {
    $especialidad = "%$especialidad%"; // Uso % para búsquedas parciales con LIKE
    $stmt->bindParam(':especialidad', $especialidad);
}

$stmt->execute();
$centros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aliados</title>
    <link rel="stylesheet" href="css/aliados.css">
</head>
<body>

    <!-- Inicio del header -->
    <?php include "Header/headerLogin.php"; ?>
    <!-- fin del header -->

    <section class="contenido wrapper">
        <form method="GET" action="Aliados.php">
            <label for="convenio">Convenio:</label>
            <select name="convenio">
                <option value="Todos">Todos</option>
                <option value="Sura EPS">EPS Sura</option>
                <option value="Clinica Medellin">Clínica Medellín</option>
                <option value="Comfama">Comfama</option>
            </select>

            <label for="horario">Horario:</label>
            <select name="horario">
                <option value="Todos">Todos</option>
                <option value="24 horas">24 horas</option>
                <option value="Lunes a Viernes">Lunes a Viernes</option>
                <option value="Lunes a Sabado">Lunes a Sábado</option>
                <option value="Lunes a Domingo">Lunes a Domingo</option>
            </select>

            <label for="especialidad">Especialidad:</label>
            <select name="especialidad">
            <option value="">Todas</option>
                <option value="Cardiología">Cardiología</option>
                <option value="Pediatría">Pediatría</option>
                <option value="Cirugía">Cirugía</option>
                <option value="Neurología">Neurología</option>
                <option value="Dermatología">Dermatología</option>
                <option value="Medicina General">Medicina General</option>
                <option value="Oncología">Oncología</option>
                <option value="Urgencias">Urgencias</option>
                <option value="Ginecología">Ginecología</option>
                <option value="Salud Preventiva">Salud Preventiva</option>
                <option value="Odontología">Odontología</option>
                <option value="Laboratorios">Laboratorios</option>
                <!-- Agrega más especialidades según tu base de datos -->
            </select>

            <button type="submit">Filtrar</button>
        </form>

        <!-- Mostrar la tabla con los centros médicos filtrados -->
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Horario de Atención</th>
                    <th>Especialidades</th>
                    <th>Cómo llegar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($centros)): ?>
                    <?php foreach ($centros as $centro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($centro['nombre_centro']); ?></td>
                            <td><?php echo htmlspecialchars($centro['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($centro['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($centro['horario_atencion']); ?></td>
                            <td><?php echo htmlspecialchars($centro['especialidades']); ?></td>
                            <td>
                                <?php if (!empty($centro['latitud']) && !empty($centro['longitud'])): ?>
                                    <a href="https://www.google.com/maps?q=<?php echo $centro['latitud']; ?>,<?php echo $centro['longitud']; ?>" target="_blank">Ver</a>
                                <?php else: ?>
                                    <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($centro['direccion']); ?>" target="_blank">Ver</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No se encontraron centros médicos que coincidan con los filtros seleccionados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br>
        <br>
    </section>

    <!-- Pie de Página -->
    <?php include "Footer/footer.php"; ?>

</body>
</html>
