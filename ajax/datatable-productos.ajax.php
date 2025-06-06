<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";


class TablaProductos{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaProductos(){

		$item = null;
    	$valor = null;
    	$orden = "id";

  		$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);	

  		if(count($productos) == 0){

  			echo '{"data": []}';

		  	return;
  		}
		
  		$datosJson = '{
  "data": [';

for ($i = 0; $i < count($productos); $i++) {

  // Imagen
  $imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";

  // Categoría
  $item = "id";
  $valor = $productos[$i]["id_categoria"];
  $categoria = ControladorCategorias::ctrMostrarCategorias($item, $valor);
  $categoriaNombre = $categoria["categoria"];

  // Stock
  $stockColor = "success";
  if ($productos[$i]["stock"] <= 10) $stockColor = "danger";
  else if ($productos[$i]["stock"] <= 15) $stockColor = "warning";
  $stock = "<button class='btn btn-".$stockColor."'>".$productos[$i]["stock"]."</button>";

  // ¿Es Sopa?
  $sopaLabel = $productos[$i]["es_sopa"] == 1 
    ? "<span class='label label-info'>Sí</span>" 
    : "<span class='label label-default'>No</span>";

  // Acciones
  if ($_GET["perfilOculto"] == "Especial") {
    $botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button></div>";
  } else {
    $botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='".$productos[$i]["id"]."' codigo='".$productos[$i]["codigo"]."' imagen='".$productos[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>";
  }

  $datosJson .= '[
    "'.($i+1).'",
    "'.$imagen.'",
    "'.$productos[$i]["codigo"].'",
    "'.$productos[$i]["descripcion"].'",
    "'.$categoriaNombre.'",
    "'.$stock.'",
    "'.$productos[$i]["precio_compra"].'",
    "'.$productos[$i]["precio_venta"].'",
    "'.$sopaLabel.'",
    "'.$productos[$i]["fecha"].'",
    "'.$botones.'"
  ],';

}

$datosJson = rtrim($datosJson, ','); // remove last comma
$datosJson .= ']}';

echo $datosJson;

	}



}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarProductos = new TablaProductos();
$activarProductos -> mostrarTablaProductos();

