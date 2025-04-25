<?php

class ControladorVentasCliente {

    public static function ctrGenerarVentaCliente() {

        if(isset($_POST["idCliente"]) && isset($_POST["idProducto"]) && isset($_POST["cantidad"]) && isset($_POST["metodoPago"])) {
      
          $idCliente  = intval($_POST["idCliente"]);
          $idProducto = intval($_POST["idProducto"]);
          $cantidad   = intval($_POST["cantidad"]);
          $metodoPago = trim($_POST["metodoPago"]);
          $montoPago  = isset($_POST["montoPago"]) ? floatval($_POST["montoPago"]) : 0;
      
          $producto = ModeloProductos::mdlMostrarProductos("productos", "id", $idProducto, "id");
      
          if(!$producto) return "error_product";
          if($producto["stock"] < $cantidad) return "error_stock";
      
          $precio = floatval($producto["precio_venta"]);
          $total  = $precio * $cantidad;
          $codigo = time();
      
          $listaProducto = array(
            array(
              "id" => $producto["id"],
              "descripcion" => $producto["descripcion"],
              "cantidad" => $cantidad,
              "precio" => $precio,
              "total" => $total,
              "stock" => $producto["stock"] - $cantidad
            )
          );
      
          $datosVenta = array(
            "codigo"       => $codigo,
            "id_cliente"   => $idCliente,
            "id_vendedor"  => 0, // venta autogestionada
            "productos"    => json_encode($listaProducto),
            "impuesto"     => 0,
            "neto"         => $total,
            "total"        => $total,
            "metodo_pago"  => $metodoPago,
            "monto_pago"   => $montoPago // nuevo campo para guardar el efectivo entregado
          );
      
          $respuesta = ModeloVentasCliente::mdlIngresarVentaCliente("ventas", $datosVenta);
      
          if($respuesta === "ok"){
            ModeloProductos::mdlActualizarProducto("productos", "stock", $producto["stock"] - $cantidad, $idProducto);
      
            $cliente = ModeloClientes::mdlMostrarClientes("clientes", "id", $idCliente);
            $nuevasCompras = $cliente["compras"] + $cantidad;
            ModeloClientes::mdlActualizarCliente("clientes", "compras", $nuevasCompras, $idCliente);
      
            return "ok";
          } else {
            return "error";
          }
        } else {
          return "error_data";
        }
      }
      
}
?>