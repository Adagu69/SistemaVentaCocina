<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

if (isset($_POST["codigo"])) {
    $item = "codigo"; // o "codigo" si así se llama en tu base
    $valor = $_POST["codigo"];

    $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);

    echo json_encode($cliente);
}