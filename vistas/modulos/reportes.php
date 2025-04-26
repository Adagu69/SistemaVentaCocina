<?php

if($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

// 🧠 Preparar variables para los gráficos de auditoría

$host = "localhost";
$usuario = "root";
$password = "852456";
$nombreBD = "sis_inventario";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$nombreBD;charset=utf8", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conexion->prepare("SELECT fecha_movimiento, ventas_movidas, estado FROM auditoria_movimientos ORDER BY fecha_movimiento ASC");
    $stmt->execute();
    $auditorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Variables para pasar a Chart.js
    $fechas = [];
    $ventasMovidas = [];
    $estados = [];

    foreach ($auditorias as $auditoria) {
        $fechas[] = date('d-m-Y', strtotime($auditoria['fecha_movimiento']));
        $ventasMovidas[] = (int)$auditoria['ventas_movidas'];
        $estados[] = $auditoria['estado'];
    }

} catch (PDOException $e) {
    $fechas = [];
    $ventasMovidas = [];
    $estados = [];
}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>Reportes de Ventas</h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Reportes de Ventas</li>
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border d-flex justify-content-between align-items-center">

        <div class="input-group">
          <button type="button" class="btn btn-default" id="daterange-btn2">
            <span>
              <i class="fa fa-calendar"></i> 
              <?php
                if(isset($_GET["fechaInicial"])){
                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                }else{
                  echo 'Rango de fecha';
                }
              ?>
            </span>
            <i class="fa fa-caret-down"></i>
          </button>
        </div>

        <!-- Ambos botones en línea -->
        <div class="box-tools pull-right" style="margin-top:5px">
          <!-- Botón Reporte de Ventas -->
  <?php
  if(isset($_GET["fechaInicial"])){
    echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'" style="margin-right:5px;">';
  }else{
    echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte" style="margin-right:5px;">';
  }
  ?>
            <button class="btn btn-success">📥 Reporte Ventas Excel</button>
          </a>

           <!-- Botón Auditoría -->
  <a href="controladores/descargar_auditoria.controlador.php?reporteAuditoria=auditoria_ventas">
    <button class="btn btn-primary" data-toggle="tooltip" title="Descargar auditoría de movimientos en Excel 📄">
      📥 Auditoría Excel
    </button>
  </a>
        </div>

      </div>

      <div class="box-body">

        <div class="row">

          <!-- 📊 Gráfico de Ventas -->
          <div class="col-xs-12">
            <?php include "reportes/grafico-ventas.php"; ?>
          </div>

          <!-- 🛍️ Productos más vendidos -->
          <div class="col-md-6 col-xs-12">
            <?php include "reportes/productos-mas-vendidos.php"; ?>
          </div>

          <!-- 🧑‍💼 Vendedores -->
          <div class="col-md-6 col-xs-12">
            <?php include "reportes/vendedores.php"; ?>
          </div>

          <!-- 👥 Compradores -->
          <div class="col-md-6 col-xs-12">
            <?php include "reportes/compradores.php"; ?>
          </div>

        </div>

      </div>

    </div>

    <!-- 📈 NUEVO: Dashboard Auditoría de Ventas -->

    <div class="box box-primary">

      <div class="box-header with-border">
        <h3 class="box-title">Auditoría de Movimientos de Ventas</h3>
      </div>

      <div class="box-body">

        <div class="row">

          <!-- Gráfico Ventas Movidas -->
          <div class="col-md-6">
            <canvas id="ventasMovidasChart" height="250"></canvas>
          </div>

          <!-- Gráfico Estado Movimientos -->
          <div class="col-md-6">
            <canvas id="estadoMovimientosChart" height="250"></canvas>
          </div>

        </div>

      </div>

    </div>

  </section>

</div>


<!-- Script para cargar Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
<script>
// Variables PHP → JavaScript
const fechas = <?php echo json_encode($fechas); ?>;
const ventasMovidas = <?php echo json_encode($ventasMovidas); ?>;
const estados = <?php echo json_encode($estados); ?>;

// 📈 Gráfico Línea Ventas Movidas
const ctx1 = document.getElementById('ventasMovidasChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: fechas,
        datasets: [{
            label: 'Ventas Movidas',
            data: ventasMovidas,
            backgroundColor: 'rgba(60,141,188,0.2)',
            borderColor: 'rgba(60,141,188,1)',
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

// 📊 Gráfico Torta Estados Movimiento
const exitosos = estados.filter(e => e === 'Exitoso').length;
const sinMovimientos = estados.filter(e => e !== 'Exitoso').length;

const ctx2 = document.getElementById('estadoMovimientosChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Exitosos', 'Sin Movimientos'],
        datasets: [{
            label: 'Estados',
            data: [exitosos, sinMovimientos],
            backgroundColor: ['#28a745', '#ffc107'],
            borderColor: ['#28a745', '#ffc107'],
            borderWidth: 1
        }]
    }
});
</script>
