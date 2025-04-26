<?php
// 🧠 Mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 📦 Conexión
$host = "localhost";
$usuario = "root";
$password = "852456";
$nombreBD = "sis_inventario";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$nombreBD;charset=utf8", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

// 📋 Consultar datos de auditoría
$sql = "SELECT fecha_movimiento, ventas_movidas, estado FROM auditoria_movimientos ORDER BY fecha_movimiento ASC";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$auditorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Preparar datos para Chart.js
$fechas = [];
$ventasMovidas = [];
$estados = [];

foreach ($auditorias as $auditoria) {
    $fechas[] = date('d-m-Y', strtotime($auditoria['fecha_movimiento']));
    $ventasMovidas[] = $auditoria['ventas_movidas'];
    $estados[] = $auditoria['estado'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Auditoría</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="text-center mb-4">
    <a href="controladores/descargar_auditoria.controlador.php?reporteAuditoria=auditoria_ventas" class="btn btn-success">
        📥 Descargar Auditoría en Excel
    </a>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-5">📈 Dashboard de Movimientos de Ventas</h1>

    <div class="row">

        <div class="col-md-12 mb-5">
            <canvas id="ventasMovidasChart"></canvas>
        </div>

        <div class="col-md-12">
            <canvas id="estadoMovimientosChart"></canvas>
        </div>

    </div>
</div>

<script>
// 📊 Datos enviados desde PHP
const fechas = <?php echo json_encode($fechas); ?>;
const ventasMovidas = <?php echo json_encode($ventasMovidas); ?>;
const estados = <?php echo json_encode($estados); ?>;

// 📈 Gráfico de Ventas Movidas por Fecha
const ctx1 = document.getElementById('ventasMovidasChart').getContext('2d');
const ventasChart = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: fechas,
        datasets: [{
            label: 'Ventas Movidas',
            data: ventasMovidas,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 📊 Gráfico de Estados de Movimiento
const exitosos = estados.filter(e => e === 'Exitoso').length;
const sinMovimientos = estados.filter(e => e !== 'Exitoso').length;

const ctx2 = document.getElementById('estadoMovimientosChart').getContext('2d');
const estadoChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Exitosos', 'Sin Movimientos'],
        datasets: [{
            label: 'Estados de Movimiento',
            data: [exitosos, sinMovimientos],
            backgroundColor: [
                'rgba(40, 167, 69, 0.7)',
                'rgba(255, 193, 7, 0.7)'
            ],
            borderColor: [
                'rgba(40, 167, 69, 1)',
                'rgba(255, 193, 7, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});
</script>

</body>
</html>
