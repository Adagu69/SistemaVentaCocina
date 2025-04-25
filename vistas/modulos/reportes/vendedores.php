<?php

$item = null;
$valor = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

$arrayVendedores = array();
$arraylistaVendedores = array();
$sumaTotalVendedores = array();

if (!empty($ventas) && !empty($usuarios)) {
foreach ($ventas as $key => $valueVentas) {
  foreach ($usuarios as $key => $valueUsuarios) {

    if ($valueUsuarios["id"] == $valueVentas["id_vendedor"]) {

      // Capturamos los vendedores o clientes
      $nombre = $valueUsuarios["nombre"];

      // Guardamos el nombre
      array_push($arrayVendedores, $nombre);

      // Sumamos los netos acumulando por nombre
      if (!isset($sumaTotalVendedores[$nombre])) {
        $sumaTotalVendedores[$nombre] = 0;
      }

      $sumaTotalVendedores[$nombre] += $valueVentas["neto"];
    }
  }
}
}

// Evitamos repetir nombres
$noRepetirNombres = array_unique($arrayVendedores);

// Armamos los datos para el gráfico de forma segura
$dataPoints = [];
foreach ($noRepetirNombres as $value) {
  $dataPoints[] = [
    'y' => $value,
    'a' => $sumaTotalVendedores[$value]
  ];
}
?>


<!--=====================================
VENDEDORES
======================================-->

<div class="box box-success">
	
	<div class="box-header with-border">
    
    	<h3 class="box-title">Vendedores</h3>
  
  	</div>

  	<div class="box-body">
  		
		<div class="chart-responsive">
			
			<div class="chart" id="bar-chart1" style="height: 300px;"></div>

		</div>

  	</div>

</div>

<script>
	
//BAR CHART
var bar = new Morris.Bar({
  element: 'bar-chart1',
  resize: true,
  data: <?php echo json_encode($dataPoints, JSON_UNESCAPED_UNICODE); ?>,
  barColors: ['#0af'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['Ventas'],
  preUnits: '$',
  hideHover: 'auto'
});

</script>