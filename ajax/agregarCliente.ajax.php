<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

if(isset($_POST["nuevoCliente"])) {
  echo ControladorClientes::ctrCrearClienteAjax();
}