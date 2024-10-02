<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['email']) || $_SESSION['role_id'] != 1) {
    // Si no es administrador, redirigir a la página de inicio o mostrar un mensaje de acceso denegado
    header("Location: Bienvenida.php");
    exit();
}

require "Conexion.php"; // Conexión a la DB usando PDO, aquí $conn es la variable correcta

// Estadísticas resumidas
try {
    $totalUsuarios = $conn->query('SELECT COUNT(*) FROM users')->fetchColumn();
    $totalAdmins = $conn->query('SELECT COUNT(*) FROM users WHERE role_id = 1')->fetchColumn();
    $totalClientes = $conn->query('SELECT COUNT(*) FROM users WHERE role_id = 2')->fetchColumn();
} catch (PDOException $e) {
    // Manejar error de base de datos
    echo "Error en la base de datos: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css"> <!-- Enlaza un archivo CSS personalizado si tienes -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Enlazar Chart.js -->
</head>
<body>

<header>
    <?php include "Header/headerAdmin.php"; ?> <!-- Encabezado común para los administradores -->
</header>

<main>

    <div class="dashboard-summary">
        <div class="summary-card">
            <h3>Total Usuarios</h3>
            <p><?php echo $totalUsuarios; ?></p>
        </div>
        <div class="summary-card">
            <h3>Administradores</h3>
            <p><?php echo $totalAdmins; ?></p>
        </div>
        <div class="summary-card">
            <h3>Clientes</h3>
            <p><?php echo $totalClientes; ?></p>
        </div>
    </div>

    <!-- Gráfico usando Chart.js -->
    <canvas id="userChart" style="width: 500px; height: 500px;"></canvas>

    <script>
        var ctx = document.getElementById('userChart').getContext('2d');
        var userChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Clientes', 'Administradores'],
                datasets: [{
                    label: '# de Usuarios',
                    data: [<?php echo $totalClientes; ?>, <?php echo $totalAdmins; ?>],
                    backgroundColor: ['#36A2EB', '#FF6384']
                }]
            },
            options: {
                responsive: false,   // Hacer el gráfico responsivo
                maintainAspectRatio: true,  // Permitir que el gráfico cambie de tamaño según el contenedor
            }
        });
    </script>

</main>

<!--Pie de Página-->
<footer>
    <?php include "Footer/footer.php"; ?> <!-- Pie de página común para todo el sitio -->
</footer>

</body>
</html>

