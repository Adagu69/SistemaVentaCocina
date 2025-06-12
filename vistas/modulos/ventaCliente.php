<?php
// ventaCliente.php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
};
$clientes = ControladorClientes::ctrMostrarClientes(null, null);
$productos = ControladorProductos::ctrMostrarProductos(null, null, "id");
$idAlmuerzo = 18;
$idDesayuno = 17;
?>

<style>
  .btn-menu-tactil {
    font-size: 22px;
    padding: 25px 10px;
    margin-bottom: 10px;
    white-space: normal;
  }

  .btn-menu-tactil span {
    font-weight: bold;
    display: block;
  }

  .box-menu {
    border: 2px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
  }

  .resumen-scroll {
    max-height: 320px;
    overflow-y: auto;
  }

  @media (max-width: 768px) {
    .btn-menu-tactil {
      font-size: 20px;
      padding: 18px;
    }
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fa fa-utensils"></i> Venta Rápida - Cafetería</h1>
  </section>

  <section class="content">
    <div class="row">
      <!-- CLIENTE + CATEGORÍAS -->
      <div class="col-md-4">
        <div class="box box-primary">
          <div class="box-header"><h4>Seleccionar Cliente</h4></div>
          <div class="box-body">
            <select id="clienteManual" class="form-control input-lg">
              <option value="">-- Seleccione --</option>
              <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['nombre'] ?></option>
              <?php endforeach; ?>
            </select>
            <div id="clienteSeleccionadoMsg" class="text-success text-center" style="margin-top:10px; font-weight: bold; display: none;"></div>
            <button class="btn btn-success btn-block btn-lg" data-toggle="modal" data-target="#modalAgregarCliente">
              <i class="fa fa-user-plus"></i> Nuevo Cliente
            </button>
          </div>
        </div>

        <!-- SWITCH ENTRE CATEGORÍAS -->
        <div class="text-center" style="margin-bottom: 10px;">
          <button id="btnDesayuno" class="btn btn-default btn-lg active">🥐 Desayuno</button>
          <button id="btnAlmuerzo" class="btn btn-default btn-lg">🍛 Almuerzo</button>
        </div>

        <!-- MENÚ DESAYUNO -->
        <div id="contenedorDesayuno">
          <div class="box-menu bg-info">
            <h4 class="text-center text-white"><i class="fa fa-money"></i> Desayuno Efectivo</h4>
            <?php foreach ($productos as $p): if ($p["id_categoria"] == $idDesayuno):
              $tipo = "D"; ?>
              <button class="btn btn-primary btn-lg btn-block btn-menu-tactil btnAgregarProductoDirecto"
                      data-id="<?= $p['id'] ?>"
                      data-nombre="<?= $p['descripcion'] ?>"
                      data-precio="<?= $p['precio_venta'] ?>"
                      data-stock="<?= $p['stock'] ?>"
                      data-tipo="<?= $tipo ?>"
                      data-metodo="efectivo">
                <span><?= $tipo ?></span><?= $p['descripcion'] ?><br><small>S/ <?= number_format($p['precio_venta'], 2) ?></small>
              </button>
            <?php endif; endforeach; ?>
          </div>

          <div class="box-menu bg-warning">
            <h4 class="text-center text-dark"><i class="fa fa-credit-card"></i> Desayuno Cuenta</h4>
            <?php foreach ($productos as $p): if ($p["id_categoria"] == $idDesayuno):
              $tipo = "D"; ?>
              <button class="btn btn-warning btn-lg btn-block btn-menu-tactil btnAgregarProductoDirecto"
                      data-id="<?= $p['id'] ?>"
                      data-nombre="<?= $p['descripcion'] ?>"
                      data-precio="<?= $p['precio_venta'] ?>"
                      data-stock="<?= $p['stock'] ?>"
                      data-tipo="<?= $tipo ?>"
                      data-metodo="cuenta">
                <span><?= $tipo ?></span><?= $p['descripcion'] ?><br><small>S/ <?= number_format($p['precio_venta'], 2) ?></small>
              </button>
            <?php endif; endforeach; ?>
          </div>
        </div>

        <!-- MENÚ ALMUERZO -->
        <div id="contenedorAlmuerzo" style="display:none;">
          <div class="box-menu bg-info">
            <h4 class="text-center text-white"><i class="fa fa-money"></i> Almuerzo Efectivo</h4>
            <?php foreach ($productos as $p): if ($p["id_categoria"] == $idAlmuerzo):
              $tipo = $p["es_sopa"] ? "M2" : "M1"; ?>
              <button class="btn btn-primary btn-lg btn-block btn-menu-tactil btnAgregarProductoDirecto"
                      data-id="<?= $p['id'] ?>"
                      data-nombre="<?= $p['descripcion'] ?>"
                      data-precio="<?= $p['precio_venta'] ?>"
                      data-stock="<?= $p['stock'] ?>"
                      data-tipo="<?= $tipo ?>"
                      data-metodo="efectivo">
                <span><?= $tipo ?></span><?= $p['descripcion'] ?><br><small>S/ <?= number_format($p['precio_venta'], 2) ?></small>
              </button>
            <?php endif; endforeach; ?>
          </div>

          <div class="box-menu bg-warning">
            <h4 class="text-center text-dark"><i class="fa fa-credit-card"></i> Almuerzo Cuenta</h4>
            <?php foreach ($productos as $p): if ($p["id_categoria"] == $idAlmuerzo):
              $tipo = $p["es_sopa"] ? "M2" : "M1"; ?>
              <button class="btn btn-warning btn-lg btn-block btn-menu-tactil btnAgregarProductoDirecto"
                      data-id="<?= $p['id'] ?>"
                      data-nombre="<?= $p['descripcion'] ?>"
                      data-precio="<?= $p['precio_venta'] ?>"
                      data-stock="<?= $p['stock'] ?>"
                      data-tipo="<?= $tipo ?>"
                      data-metodo="cuenta">
                <span><?= $tipo ?></span><?= $p['descripcion'] ?><br><small>S/ <?= number_format($p['precio_venta'], 2) ?></small>
              </button>
            <?php endif; endforeach; ?>
          </div>
        </div>
      </div>

      <!-- RESUMEN -->
      <div class="col-md-8">
        <div class="box box-success">
          <div class="box-header"><h4>Resumen</h4></div>
          <div class="box-body resumen-scroll">
            <table class="table table-striped" id="carritoBody">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Tipo</th>
                  <th>Precio</th>
                  <th>Cant</th>
                  <th>Subtotal</th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-xs-6 text-right"><strong>Total:</strong></div>
              <div class="col-xs-6" id="totalPagar">S/ 0.00</div>
            </div>
            <button id="btnGenerarVenta" class="btn btn-primary btn-block btn-lg" disabled>
              <i class="fa fa-check-circle"></i> Generar Venta
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- MODAL CLIENTE -->
<div class="modal fade" id="modalAgregarCliente">
  <div class="modal-dialog">
    <form id="formNuevoCliente" method="POST">
      <div class="modal-content">
        <div class="modal-header bg-primary"><h4 class="modal-title">Agregar Cliente</h4></div>
        <div class="modal-body">
          <input name="nuevoCliente" class="form-control" placeholder="Nombre completo" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
let carrito = [];
let totalAPagar = 0;

// Agregar producto
$(document).on("click", ".btnAgregarProductoDirecto", function () {
  const clienteId = $("#clienteManual").val();

  if (!clienteId) {
    swal({
      type: "warning",
      title: "Cliente no seleccionado",
      text: "Debes seleccionar primero el cliente antes de elegir un menú.",
      confirmButtonText: "Entendido"
    });
    return;
  }

  // ✅ Lógica original si cliente válido
  const id = $(this).data("id");
  const nombre = $(this).data("nombre");
  const precio = parseFloat($(this).data("precio"));
  const stock = parseInt($(this).data("stock"));
  const tipo = $(this).data("tipo");
  const metodo = $(this).data("metodo");

  let item = carrito.find(p => p.id === id);
  if (item) {
    if (item.cantidad < stock) item.cantidad++;
  } else {
    carrito.push({ id, nombre, precio, cantidad: 1, stock, tipo });
  }
  renderizarCarrito();
});

function renderizarCarrito() {
  const body = $("#carritoBody tbody");
  body.empty();
  totalAPagar = 0;

  carrito.forEach((item, i) => {
    let subtotal = item.precio * item.cantidad;
    totalAPagar += subtotal;
    body.append(`
      <tr>
        <td>${item.nombre}</td>
        <td>${item.tipo}</td>
        <td>S/ ${item.precio.toFixed(2)}</td>
        <td>${item.cantidad}</td>
        <td>S/ ${subtotal.toFixed(2)}</td>
        <td><button class="btn btn-danger btnEliminarItem" data-index="${i}">
          <i class="fa fa-times"></i></button></td>
      </tr>
    `);
  });

  $("#totalPagar").text("S/ " + totalAPagar.toFixed(2));
  $("#btnGenerarVenta").prop("disabled", !(carrito.length && $("#clienteManual").val()));
}

// Eliminar item
$(document).on("click", ".btnEliminarItem", function () {
  const i = $(this).data("index");
  carrito.splice(i, 1);
  renderizarCarrito();
});

// Verifica si se puede usar cuenta
$("#clienteManual").on("change", function () {
    const selectedName = $("#clienteManual option:selected").text();

  if ($(this).val()) {
    $("#clienteSeleccionadoMsg")
      .text("✔ Cliente seleccionado: " + selectedName)
      .removeClass("text-danger")
      .addClass("text-success")
      .fadeIn();
  } else {
    $("#clienteSeleccionadoMsg")
      .text("❌ Debe seleccionar un cliente")
      .removeClass("text-success")
      .addClass("text-danger")
      .fadeIn();
  }
 
  renderizarCarrito();
});

// CAMBIO DE CATEGORÍA
$("#btnDesayuno").on("click", function () {
  $("#contenedorDesayuno").show();
  $("#contenedorAlmuerzo").hide();
  $(this).addClass("active");
  $("#btnAlmuerzo").removeClass("active");
});
$("#btnAlmuerzo").on("click", function () {
  $("#contenedorAlmuerzo").show();
  $("#contenedorDesayuno").hide();
  $(this).addClass("active");
  $("#btnDesayuno").removeClass("active");
});

// Guardar cliente
$("#formNuevoCliente").on("submit", function (e) {
  e.preventDefault();
  const nombre = $(this).find("input").val();
  $.post("ajax/agregarCliente.ajax.php", { nombre }, function (res) {
    if (res.id) {
      $("#clienteManual").append(`<option value="${res.id}" selected>${res.nombre}</option>`);
      $("#modalAgregarCliente").modal("hide");
    }
  }, "json");
});

$("#btnGenerarVenta").on("click", function () {
  const idCliente = $("#clienteManual").val();

  if (!idCliente) {
    swal("Cliente no seleccionado", "Seleccione un cliente antes de generar la venta", "warning");
    return;
  }

  if (carrito.length === 0) {
    swal("Sin productos", "Debe agregar productos al carrito", "warning");
    return;
  }

  // Detectar método de pago predominante
  const contieneEfectivo = carrito.some(p => p.metodo === "efectivo");
  const metodoPago = contieneEfectivo ? "Efectivo" : "Cuenta";
  const montoPago = contieneEfectivo ? totalAPagar : 0;

  // Agregar etiqueta tipo_servicio
  const tipoServicio = carrito.some(p => p.categoria === 17) ? "Desayuno" : "Almuerzo"; // ID 17 = desayuno

  // Payload AJAX
  const payload = {
    idCliente: idCliente,
    metodoPago: metodoPago,
    montoPago: montoPago,
    carrito: JSON.stringify(carrito),
    tipo_servicio: tipoServicio
  };

  $("#btnGenerarVenta").html('<i class="fa fa-spinner fa-spin"></i> Procesando...').prop("disabled", true);

  $.ajax({
    url: "ajax/ventasCliente.ajax.php",
    method: "POST",
    data: payload,
    dataType: "json",
    success: function (res) {
      if (res.respuesta === "ok") {
        // 🧾 Abrir ticket TCPDF
        const url = `extensiones/tcpdf/pdf/ticket.php?codigo=${res.codigo}`;
        window.open(url, "_blank");

        swal({
          icon: "success",
          title: "Venta realizada con éxito",
          text: "Código generado: " + res.codigo
        }).then(() => location.reload());
      } else {
        swal("Error", res.mensaje || "No se pudo guardar la venta", "error");
        $("#btnGenerarVenta").html("Generar Venta").prop("disabled", false);
      }
    },
    error: function () {
      swal("Error", "Hubo un problema de comunicación con el servidor", "error");
      $("#btnGenerarVenta").html("Generar Venta").prop("disabled", false);
    }
  });
});

</script>