<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";
require_once "../../controladores/productos.controlador.php";
require_once "../../modelos/productos.modelo.php";
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fa fa-hamburger"></i> Kiosko de Pedido Manual</h1>
  </section>


          <!-- PRODUCTO -->
        <div class="form-group">
          <label for="producto"><i class="fa fa-cutlery"></i> Producto a consumir</label>
          <select id="producto" class="form-control input-lg">
            <option value="">Seleccione un producto</option>
            <?php
            $productos = ControladorProductos::ctrMostrarProductos(null, null, "id");
            foreach ($productos as $prod) {
              echo '<option data-stock="' . $prod["stock"] . '" value="' . $prod["id"] . '">' . $prod["descripcion"] . '</option>';
            }
            ?>
          </select>
        </div>

  <section class="content">
    <div class="box box-primary">
      <div class="box-body">

        <!-- CLIENTE -->
        <div class="form-group">
          <label><i class="fa fa-user"></i> Código Cliente</label>
          <input type="text" id="codigoCliente" class="form-control input-lg" placeholder="Código del cliente">
        </div>

        <div id="infoCliente" class="well well-sm" style="display:none;"></div>

        <button class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#modalAgregarCliente">
          <i class="fa fa-plus-circle"></i> Registrar nuevo cliente
        </button>

        <!-- MODAL CLIENTE -->
        <div id="modalAgregarCliente" class="modal fade" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <form id="formNuevoCliente" method="POST">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h4 class="modal-title">Agregar nuevo cliente</h4>
                </div>
                <div class="modal-body">
                  <input type="text" name="nuevoCliente" class="form-control" placeholder="Nombre" required>
                  <input type="number" name="nuevoDocumentoId" class="form-control" placeholder="DNI" required>
                  <input type="text" name="nuevoCodigo" class="form-control" placeholder="Código (manual)">
                  <input type="email" name="nuevoEmail" class="form-control" placeholder="Correo">
                  <input type="text" name="nuevoTelefono" class="form-control" placeholder="Teléfono">
                  <input type="text" name="nuevaDireccion" class="form-control" placeholder="Dirección">
                  <input type="date" name="nuevaFechaNacimiento" class="form-control" placeholder="Nacimiento">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- TIPO DE MENÚ -->
        <div class="form-group">
          <label><i class="fa fa-list"></i> Tipo de Menú</label><br>
          <button id="btnConSopa" class="btn btn-info">Con Sopa</button>
          <button id="btnSinSopa" class="btn btn-warning">Sin Sopa</button>
        </div>

        <!-- SOPA -->
        <div class="form-group" id="grupoSopa" style="display:none;">
          <label><i class="fa fa-tint"></i> Elija su Sopa</label><br>
          <?php
          $productos = ControladorProductos::ctrMostrarProductos(null, null, "id");
          foreach ($productos as $prod) {
            if (stripos($prod["descripcion"], "sopa") !== false && $prod["stock"] > 0) {
              echo "<button class='btn btn-outline-primary btnSopa' data-id='{$prod["id"]}'>{$prod["descripcion"]}</button> ";
            }
          }
          ?>
        </div>

        <!-- SEGUNDO -->
        <div class="form-group" id="grupoSegundo" style="display:none;">
          <label><i class="fa fa-drumstick-bite"></i> Elija su Segundo</label><br>
          <?php
          foreach ($productos as $prod) {
            if (stripos($prod["descripcion"], "sopa") === false && $prod["stock"] > 0) {
              echo "<button class='btn btn-outline-success btnSegundo' data-id='{$prod["id"]}'>{$prod["descripcion"]}</button> ";
            }
          }
          ?>
        </div>

        <!-- CANTIDAD -->
        <div class="form-group">
          <label><i class="fa fa-sort-numeric-asc"></i> Cantidad</label>
          <input type="number" id="cantidad" class="form-control" min="1" value="1">
        </div>

        <!-- PAGO -->
        <div class="form-group">
          <label><i class="fa fa-credit-card"></i> Método de Pago</label>
          <select id="metodoPago" class="form-control input-lg">
            <option value="">-- Seleccione --</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Yape">Yape</option>
            <option value="Plin">Plin</option>
          </select>
        </div>

        <div id="extraPago"></div>

        <!-- RESUMEN -->
        <div class="panel panel-default">
          <div class="panel-heading">Resumen de Pedido</div>
          <div class="panel-body" id="resumenVenta">
            <p class="text-muted">Aquí aparecerá el detalle del pedido.</p>
          </div>
        </div>

        <button id="btnGenerarVenta" class="btn btn-success btn-lg btn-block" disabled>
          <i class="fa fa-check"></i> Confirmar Pedido
        </button>
      </div>
    </div>
  </section>
</div>

<script>
let menuTipo = '';
let idCliente = null;
let idSopa = null;
let idSegundo = null;
let cantidad = 1;
let total = 0;

function mostrarResumen() {
  if (!idCliente || !idSegundo || (menuTipo === 'con_sopa' && !idSopa)) {
    $("#resumenVenta").html("<p class='text-muted'>Complete todos los pasos.</p>");
    $("#btnGenerarVenta").prop("disabled", true);
    return;
  }

  const metodo = $("#metodoPago").val();
  const monto = parseFloat($("#montoPago").val()) || 0;
  const productos = [];

  let resumen = "";

  if (menuTipo === 'con_sopa') {
    productos.push(idSopa);
    resumen += `<p><strong>Sopa:</strong> ${$(`.btnSopa[data-id=${idSopa}]`).text()}</p>`;
  }

  productos.push(idSegundo);
  resumen += `<p><strong>Segundo:</strong> ${$(`.btnSegundo[data-id=${idSegundo}]`).text()}</p>`;
  resumen += `<p><strong>Cantidad:</strong> ${cantidad}</p>`;

  // Suponiendo precio fijo por ahora
  const precioUnit = 8;
  total = cantidad * precioUnit;
  resumen += `<p><strong>Total:</strong> S/ ${total.toFixed(2)}</p>`;
  resumen += `<p><strong>Método:</strong> ${metodo}</p>`;

  if (metodo === 'Efectivo') {
    if (monto < total) {
      resumen += `<div class="alert alert-danger">Monto insuficiente.</div>`;
      $("#btnGenerarVenta").prop("disabled", true);
    } else {
      resumen += `<p><strong>Pago:</strong> S/ ${monto}</p>`;
      resumen += `<p><strong>Vuelto:</strong> S/ ${(monto - total).toFixed(2)}</p>`;
      $("#btnGenerarVenta").prop("disabled", false);
    }
  } else if (metodo === 'Yape' || metodo === 'Plin') {
    resumen += `<p><strong>Escanee el QR para pagar.</strong></p>`;
    $("#btnGenerarVenta").prop("disabled", true); // se activará cuando lo confirmes
  }

  $("#resumenVenta").html(resumen);
}

$("#codigoCliente").on("change", function () {
  const codigo = $(this).val().trim();
  if (!codigo) return;
  $.post("ajax/buscarCliente.ajax.php", { codigo }, function (res) {
    if (res && res.id) {
      idCliente = res.id;
      $("#infoCliente").html(`<div class='alert alert-success'>Bienvenido: <strong>${res.nombre}</strong></div>`).fadeIn();
    } else {
      idCliente = null;
      $("#infoCliente").html("<div class='alert alert-warning'>Cliente no encontrado.</div>").fadeIn();
    }
    mostrarResumen();
  }, "json");
});

$("#btnConSopa").on("click", function () {
  menuTipo = "con_sopa";
  $("#grupoSopa").show();
  $("#grupoSegundo").show();
  mostrarResumen();
});

$("#btnSinSopa").on("click", function () {
  menuTipo = "sin_sopa";
  idSopa = null;
  $("#grupoSopa").hide();
  $("#grupoSegundo").show();
  mostrarResumen();
});

$(".btnSopa").on("click", function () {
  $(".btnSopa").removeClass("btn-primary").addClass("btn-outline-primary");
  $(this).addClass("btn-primary");
  idSopa = $(this).data("id");
  mostrarResumen();
});

$(".btnSegundo").on("click", function () {
  $(".btnSegundo").removeClass("btn-success").addClass("btn-outline-success");
  $(this).addClass("btn-success");
  idSegundo = $(this).data("id");
  mostrarResumen();
});

$("#cantidad").on("input", function () {
  cantidad = parseInt($(this).val()) || 1;
  mostrarResumen();
});

$("#metodoPago").on("change", function () {
  const metodo = $(this).val();
  let html = '';
  if (metodo === "Efectivo") {
    html = `<div class="form-group">
              <label>Monto entregado</label>
              <input type="number" id="montoPago" class="form-control" min="0">
            </div>`;
  } else if (metodo === "Yape" || metodo === "Plin") {
    const qrImg = metodo === "Yape" ? "vistas/img/qr_yape.png" : "vistas/img/qr_plin.png";
    html = `<div class="text-center">
              <img src="${qrImg}" class="img-responsive" style="max-width:150px;">
              <p>Escanee con ${metodo}</p>
            </div>`;
  }
  $("#extraPago").html(html);

  $("#montoPago").on("input", function () {
    mostrarResumen();
  });

  mostrarResumen();
});

$("#formNuevoCliente").on("submit", function (e) {
  e.preventDefault();
  $.ajax({
    url: "ajax/agregarCliente.ajax.php",
    method: "POST",
    data: $(this).serialize(),
    dataType: "json",
    success: function (res) {
      if (res.id) {
        $("#codigoCliente").val(res.codigo).trigger("change");
        $('#modalAgregarCliente').modal('hide');
        swal("Listo!", "Cliente guardado con éxito", "success");
      } else {
        swal("Error", "No se pudo guardar", "error");
      }
    }
  });
});

$("#btnGenerarVenta").on("click", function () {
  const metodo = $("#metodoPago").val();
  const monto = parseFloat($("#montoPago").val()) || 0;

  const productos = [];
  if (menuTipo === 'con_sopa') productos.push(idSopa);
  productos.push(idSegundo);

  $.ajax({
    url: "ajax/ventasCliente.ajax.php",
    method: "POST",
    dataType: "json",
    data: {
      idCliente,
      productos,
      cantidad,
      metodoPago: metodo,
      montoPago: monto
    },
    success: function (res) {
      if (res.respuesta === "ok") {
        swal("Venta Exitosa", "Gracias por su compra", "success").then(() => {
          location.reload();
        });
      } else {
        swal("Error", "No se pudo registrar la venta", "error");
      }
    },
    error: function () {
      swal("Error", "Problema de conexión", "error");
    }
  });
});

</script>