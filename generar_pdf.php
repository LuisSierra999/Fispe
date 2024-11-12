<?php
session_start();
require 'Conexion.php';
require 'fpdf.php';

if (!isset($_SESSION['user_id'])) {
    die("Error: No hay un usuario autenticado.");
}

$user_id = $_SESSION['user_id'];

// Consultar información básica del usuario
$stmt = $conn->prepare("SELECT nombre, email FROM users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Error: Usuario no encontrado.");
}

// Consultar vacunas del usuario
$stmt_vacunas = $conn->prepare("SELECT nombre_vacuna, fecha_aplicacion, dosis, notas FROM vacunas WHERE user_id = :user_id");
$stmt_vacunas->bindParam(':user_id', $user_id);
$stmt_vacunas->execute();
$vacunas = $stmt_vacunas->fetchAll(PDO::FETCH_ASSOC);

// Consultar medicamentos del usuario
$stmt_medicamentos = $conn->prepare("SELECT nombre_medicamento, dosis, frecuencia, fecha_inicio, fecha_fin FROM medicamentos WHERE user_id = :user_id");
$stmt_medicamentos->bindParam(':user_id', $user_id);
$stmt_medicamentos->execute();
$medicamentos = $stmt_medicamentos->fetchAll(PDO::FETCH_ASSOC);

// Consultar controles médicos del usuario
$stmt_controles = $conn->prepare("SELECT presion_arterial, talla, peso, glicemia, fecha_control, observaciones FROM controles_medicos WHERE user_id = :user_id");
$stmt_controles->bindParam(':user_id', $user_id);
$stmt_controles->execute();
$controles = $stmt_controles->fetchAll(PDO::FETCH_ASSOC);

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();

// Encabezado del PDF
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Ficha de Seguimiento Personal', 0, 1, 'C');

// Información Básica del Usuario
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Información del Usuario', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Nombre: " . $user['nombre'], 0, 1);
$pdf->Cell(0, 10, "Email: " . $user['email'], 0, 1);
$pdf->Ln(10);

// Sección de Vacunas
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Vacunas', 0, 1);
$pdf->SetFont('Arial', '', 12);
if (count($vacunas) > 0) {
    foreach ($vacunas as $vacuna) {
        $pdf->Cell(0, 10, "Vacuna: " . $vacuna['nombre_vacuna'] . " - Fecha: " . $vacuna['fecha_aplicacion'] . " - Dosis: " . $vacuna['dosis'], 0, 1);
        if (!empty($vacuna['notas'])) {
            $pdf->Cell(0, 10, "Notas: " . $vacuna['notas'], 0, 1);
        }
    }
} else {
    $pdf->Cell(0, 10, "No hay registros de vacunas.", 0, 1);
}
$pdf->Ln(10);

// Sección de Medicamentos
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Medicamentos', 0, 1);
$pdf->SetFont('Arial', '', 12);
if (count($medicamentos) > 0) {
    foreach ($medicamentos as $medicamento) {
        $pdf->Cell(0, 10, "Medicamento: " . $medicamento['nombre_medicamento'] . " - Dosis: " . $medicamento['dosis'] . " - Frecuencia: " . $medicamento['frecuencia'], 0, 1);
        $pdf->Cell(0, 10, "Fecha Inicio: " . $medicamento['fecha_inicio'] . " - Fecha Fin: " . $medicamento['fecha_fin'], 0, 1);
    }
} else {
    $pdf->Cell(0, 10, "No hay registros de medicamentos.", 0, 1);
}
$pdf->Ln(10);

// Sección de Controles Médicos
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Controles Médicos', 0, 1);
$pdf->SetFont('Arial', '', 12);
if (count($controles) > 0) {
    foreach ($controles as $control) {
        $pdf->Cell(0, 10, "Fecha: " . $control['fecha_control'] . " - Presión Arterial: " . $control['presion_arterial'] . " - Talla: " . $control['talla'] . " m - Peso: " . $control['peso'] . " kg", 0, 1);
        $pdf->Cell(0, 10, "Glicemia: " . $control['glicemia'] . " mg/dL", 0, 1);
        if (!empty($control['observaciones'])) {
            $pdf->Cell(0, 10, "Observaciones: " . $control['observaciones'], 0, 1);
        }
        $pdf->Ln(5);
    }
} else {
    $pdf->Cell(0, 10, "No hay registros de controles médicos.", 0, 1);
}

// Salida del PDF
$pdf->Output('D', 'Ficha_Seguimiento_' . $user['nombre'] . '.pdf'); // Descarga directa
?>