<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

if (isset($_POST["codigo"])) {
    $valor = $_POST["codigo"];

      // Primero intenta por código_barra
    $cliente = ControladorClientes::ctrMostrarClientes("codigo_barra", $valor);

    // Si no encuentra, intenta por código manual
    if (!$cliente) {
        $cliente = ControladorClientes::ctrMostrarClientes("codigo", $valor);
    }

    echo json_encode($cliente);
}