<?php
// modelos/ventasCliente.modelo.php

require_once "conexion.php";

class ModeloVentasCliente {

    public static function mdlIngresarVentaCliente($tabla, $datos) {
    $stmt = Conexion::conectar()->prepare(
        "INSERT INTO $tabla (codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago, monto_pago)
         VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago, :monto_pago)"
    );
       $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
    $stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
    $stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
    $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
    $stmt->bindParam(":impuesto", $datos["impuesto"]);
    $stmt->bindParam(":neto", $datos["neto"]);
    $stmt->bindParam(":total", $datos["total"]);
    $stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
    $stmt->bindParam(":monto_pago", $datos["monto_pago"]);
      
        if($stmt->execute()) return "ok";
        else return "error";
    
      }
      
}
?>