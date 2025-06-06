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
       public function ajaxGenerarVentaCliente() {

        if (
            isset($_POST["idCliente"]) &&
            isset($_POST["metodoPago"]) &&
            isset($_POST["carrito"])
        ) {
            $idCliente = $_POST["idCliente"];
            $metodo = $_POST["metodoPago"];
            $monto = $_POST["montoPago"] ?? 0;
            $carrito = json_decode($_POST["carrito"], true);

            $respuesta = ControladorVentasCliente::ctrGenerarVentaCliente($idCliente, $metodo, $monto, $carrito);

            echo json_encode($respuesta);
        } else {
            echo json_encode(["respuesta" => "error", "mensaje" => "Datos incompletos"]);
        }
    }
}



/*===========================================
COMPROBAR SI SE RECIBIERON DATOS POR POST
=============================================*/
$generar = new AjaxVentasCliente();
$generar->ajaxGenerarVentaCliente();

