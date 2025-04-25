<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

if(isset($_POST["id"])){

    $item = "id";
    $valor = $_POST["id"];
    $orden = "id"; // si tu modelo requiere un orden

    $producto = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

    echo json_encode($producto);

}