<?php

class ControladorVentasCliente {

public static function ctrGenerarVentaCliente($idCliente, $metodo, $monto, $carrito) {

    $productosGuardados = [];
    $neto = 0;

    foreach ($carrito as $item) {
        $subtotal = $item["precio"] * $item["cantidad"];
        $neto += $subtotal;

        $productosGuardados[] = [
            "id" => $item["id"],
            "descripcion" => $item["nombre"],
            "cantidad" => $item["cantidad"],
            "precio" => $item["precio"],
            "total" => $subtotal,
            "stock" => $item["stock"] - $item["cantidad"]
        ];

        ModeloProductos::mdlActualizarProducto("productos", "stock", $item["stock"] - $item["cantidad"], $item["id"]);
    }

    $codigo = rand(100000000, 999999999);
    $productosJSON = json_encode($productosGuardados, JSON_UNESCAPED_UNICODE);

    $datos = [
        "codigo"       => $codigo,
        "id_cliente"   => $idCliente,
        "id_vendedor"  => $_SESSION["id"] ?? 0,
        "productos"    => $productosJSON,
        "impuesto"     => 0,
        "neto"         => $neto,
        "total"        => $neto,
        "metodo_pago"  => $metodo,
        "monto_pago"   => $monto
    ];

    $respuesta = ModeloVentasCliente::mdlIngresarVentaCliente("ventas", $datos);

    return ($respuesta === "ok")
        ? ["respuesta" => "ok", "codigo" => $codigo]
        : ["respuesta" => "error", "mensaje" => "No se pudo guardar la venta"];
}
      
}
?>