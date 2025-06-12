<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $idCliente = $_POST["idCliente"];
  $metodoPago = $_POST["metodoPago"] ?? "Efectivo";
  $montoPago = $_POST["montoPago"] ?? 0;
  $carrito = json_decode($_POST["carrito"], true);

  if (!$idCliente || empty($carrito)) {
    echo json_encode(["respuesta" => "error", "mensaje" => "Faltan datos de cliente o carrito."]);
    exit;
  }

  $codigo = time(); // simple timestamp como código único
  $total = 0;
  $productos = [];

  foreach ($carrito as $item) {
    $subtotal = $item["precio"] * $item["cantidad"];
    $total += $subtotal;
    $productos[] = [
      "id" => $item["id"],
      "descripcion" => $item["nombre"],
      "cantidad" => $item["cantidad"],
      "precio" => $item["precio"],
      "total" => $subtotal,
      "stock" => $item["stock"]
    ];
  }


  $datosVenta = [
    "codigo" => $codigo,
    "id_cliente" => $idCliente,
    "id_vendedor" => 0,
    "productos" => json_encode($productos),
    "impuesto" => 0,
    "neto" => $total,
    "total" => $total,
    "metodo_pago" => $metodoPago,
    "monto_pago" => $montoPago
  ];

   $respuesta = ControladorVentas::ctrCrearVentaRapida($datosVenta);

  echo json_encode([
    "respuesta" => $respuesta,
    "codigo" => $codigo
  ]);
}