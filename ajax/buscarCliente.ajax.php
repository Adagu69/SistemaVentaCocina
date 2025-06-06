<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

if (isset($_POST["codigo"])) {
    $valor = $_POST["codigo"];
    
    if (is_numeric($valor)) {
        // Buscar por ID o código numérico
        $item = "id";
    } else {
        // Buscar por código textual
        $item = "codigo";
    }

    $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);

    echo json_encode($cliente);
}