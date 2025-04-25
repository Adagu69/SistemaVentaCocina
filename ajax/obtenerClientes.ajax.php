<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

$clientes = ControladorClientes::ctrMostrarClientes(null, null);
echo json_encode($clientes);