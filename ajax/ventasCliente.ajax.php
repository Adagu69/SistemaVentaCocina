<?php
require_once "../controladores/ventasCliente.controlador.php";
require_once "../modelos/ventasCliente.modelo.php";

// Si tu controlador utiliza otros modelos (por ejemplo, productos, clientes), agrégalos también:
require_once "../modelos/productos.modelo.php";
require_once "../modelos/clientes.modelo.php";

class AjaxVentasCliente {

    /*=============================================
    GENERAR VENTA DESDE LA VISTA ventaCliente.php
    =============================================*/
    public function ajaxGenerarVentaCliente(){

        // Llamamos al método del controlador que procesa la venta
        $respuesta = ControladorVentasCliente::ctrGenerarVentaCliente();
        echo json_encode(["respuesta" => "ok"]);
    }
}

/*===========================================
COMPROBAR SI SE RECIBIERON DATOS POR POST
=============================================*/
if(isset($_POST["idCliente"]) && 
   isset($_POST["idProducto"]) && 
   isset($_POST["cantidad"]) && 
   isset($_POST["metodoPago"])){

    $_POST["montoPago"] = $_POST["montoPago"] ?? 0;

    $generarVenta = new AjaxVentasCliente();
    $generarVenta->ajaxGenerarVentaCliente();

}else{
    echo "error_data"; 
    // Retorna error si faltan datos requeridos.
}