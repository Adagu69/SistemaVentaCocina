<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

if(isset($_POST["id"])){

    $item = "id";
    $valor = $_POST["id"];
    $orden = "id";

    $producto = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

    if ($producto) {
        echo json_encode([
            "id" => $producto["id"],
            "descripcion" => $producto["descripcion"],
            "precio_venta" => $producto["precio_venta"],
            "stock" => $producto["stock"],
            "imagen" => $producto["imagen"],
            "es_sopa" => $producto["es_sopa"],
            "id_categoria" => $producto["id_categoria"]
        ]);
    } else {
        echo json_encode(null);
    }

}