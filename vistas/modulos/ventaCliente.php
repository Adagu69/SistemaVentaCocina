<?php
// ventaCliente.php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<style>
  .btn.active {
    box-shadow: 0 0 10px #007bff;
    font-weight: bold;
  }
</style>


<div id="loader-overlay" style="
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(255, 255, 255, 0.7) url('vistas/img/productos/01/Loader.gif') no-repeat center center;
    background-size: 80px;">
</div>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fa fa-cart-plus"></i> Venta Rápida</h1>
  </section>

  <section class="content">

    <div class="row">

      <!-- 🔹 COLUMNA IZQUIERDA - DATOS Y CONTROL -->
      <div class="col-md-5">

        <div class="box box-primary">
          <div class="box-body">
            <!-- CLIENTE -->
            <div class="form-group">
              <label>Seleccionar Cliente</label>
              <div class="input-group">
                <select id="clienteManual" class="form-control input-lg">
                  <option value="">-- Seleccione un cliente --</option>
                  <?php
                  $clientes = ControladorClientes::ctrMostrarClientes(null, null);
                  foreach ($clientes as $cliente) {
                    echo '<option value="' . $cliente["id"] . '">' . $cliente["nombre"] . '</option>';
                  }
                  ?>
                </select>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalAgregarCliente">
                    <i class="fa fa-plus"></i>
                  </button>
                </span>
              </div>
            </div>


            <!-- MODAL CLIENTE -->
            <div id="modalAgregarCliente" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg">
                <form id="formNuevoCliente" method="POST">
                  <div class="modal-content">
                    <div class="modal-header bg-primary">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Agregar nuevo cliente</h4>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nuevoCliente" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Documento</label>
                        <input type="number" name="nuevoDocumentoId" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Código</label>
                        <input type="text" name="nuevoCodigo" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="nuevoEmail" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="nuevoTelefono" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="nuevaDireccion" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Fecha de nacimiento</label>
                        <input type="date" name="nuevaFechaNacimiento" class="form-control">
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Guardar cliente</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- OPCIONAL: Escaneo de código -->
            <div class="form-group">
              <label><i class="fa fa-barcode"></i> Escanear Código de Cliente</label>
              <input type="text" id="codigoCliente" placeholder="Escanee o digite su código" class="form-control input-lg">
            </div>

            <!-- NUEVO CLIENTE -->
            <div id="formNuevoCliente" style="display: none;">
              <div class="form-group">
                <label>Nombre del Cliente</label>
                <input type="text" id="nombreNuevoCliente" class="form-control input-lg" placeholder="Ingrese nombre">
              </div>
              <div class="form-group">
                <label>Correo / Teléfono (opcional)</label>
                <input type="text" id="contactoNuevoCliente" class="form-control input-lg" placeholder="Ingrese contacto">
              </div>
              <button type="button" class="btn btn-info btn-block" id="btnGuardarNuevoCliente"><i class="fa fa-save"></i> Guardar Cliente</button>
            </div>

            <!-- Info -->
            <div id="infoCliente" class="well well-sm" style="display:none;"></div>

            <!-- MÉTODO DE PAGO -->
            <div class="form-group">
              <label for="metodoPago"><i class="fa fa-credit-card"></i> Método de Pago</label>
              <select id="metodoPago" class="form-control input-lg">
                <option value="">Seleccione un método</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Yape">Yape</option>
                <option value="Plin">Plin</option>
                <option value="Cuenta">Cuenta (Descuento en salario)</option>
              </select>
              <!-- NUEVO: Campo para monto o QR -->
              <div id="extraPago"></div>

              <!-- MONTO A PAGAR -->
              <div class="form-group" id="grupoMonto" style="display:none">
                <label for="montoPago"><i class="fa fa-money"></i> Monto con el que paga</label>
                <input type="number" id="montoPago" class="form-control input-lg" min="0" placeholder="Ingrese el monto">
              </div>

              <!-- QR DINÁMICO -->
              <div class="form-group" id="qrPago" style="display:none">
                <label><i class="fa fa-qrcode"></i> Escanee el código para pagar</label>
                <img id="imagenQR" src="" alt="QR" class="img-responsive" style="max-width:200px;">
              </div>

              <div class="text-right" style="margin-bottom: 10px;">
  <button id="btnVaciarCarrito" class="btn btn-danger">
    <i class="fa fa-trash"></i> Vaciar Carrito
  </button>
</div>
<!-- RESUMEN -->
<div id="resumenVenta">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Imagen</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th><b>Stock</b></th>
        <th>Subtotal</th>
        <th>Eliminar</th>
      </tr>
    </thead>
    <tbody id="carritoBody">
      <!-- Productos agregados aparecerán aquí -->
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5" class="text-right"><strong>Total a pagar:</strong></td>
        <td colspan="2" id="totalPagar">S/ 0.00</td>
      </tr>
    </tfoot>
  </table>
</div>

              <button id="btnGenerarVenta" class="btn btn-success btn-lg btn-block" disabled>
                <i class="fa fa-check"></i> Generar Venta
              </button>

              

            </div>

          </div>

        </div>
      </div>

        


<!-- 🔸 COLUMNA DERECHA - PRODUCTOS DISPONIBLES -->
<div class="col-md-7">
  <div class="box box-warning">
    <div class="box-header with-border text-center">
      <h4 class="box-title"><i class="fa fa-cutlery"></i> Selecciona el tipo de menú</h4>
    </div>

    <div class="box-body">

      <?php
      // Cargar productos desde el controlador
      $productos = ControladorProductos::ctrMostrarProductos(null, null, "id");

           // Configura tus IDs reales
      $idDesayuno = 17;
      $idAlmuerzo = 18;
      ?>

      <div class="form-group">
  <input type="text" id="inputBuscarProducto" class="form-control" placeholder="🔎 Buscar producto...">
</div>

     <!-- 🔘 Botones Desayuno / Almuerzo -->
      <div class="text-center" style="margin-bottom:20px;">
        <button id="btnMostrarDesayuno" class="btn btn-primary btn-lg"><i class="fa fa-coffee"></i> Desayuno</button>
        <button id="btnMostrarAlmuerzo" class="btn btn-success btn-lg"><i class="fa fa-utensils"></i> Almuerzo</button>
      </div>

 
      <!-- 🌅 DESAYUNO -->
      <div id="productosDesayuno" style="display:none;">
        <h4 class="text-info text-center">Desayuno disponible</h4>
        <div class="row">
          <?php
          foreach ($productos as $prod) {
            if ($prod["id_categoria"] == $idDesayuno) {
              echo '
              <div class="col-sm-4 text-center" style="margin-bottom:20px;">
                <img src="' . $prod["imagen"] . '" class="img-thumbnail" style="width:100px;height:100px;">
                <p><strong>' . $prod["descripcion"] . '</strong></p>
                <p>S/ ' . number_format($prod["precio_venta"], 2) . '</p>
                <button class="btn btn-info btnAgregarProductoDirecto" 
                        data-id="' . $prod["id"] . '" 
                        data-nombre="' . $prod["descripcion"] . '" 
                        data-precio="' . $prod["precio_venta"] . '" 
                        data-stock="' . $prod["stock"] . '">
                  <i class="fa fa-plus"></i> Agregar
                </button>
              </div>';
            }
          }
          ?>
        </div>
      </div>

       <!-- 🍽️ ALMUERZO -->
      <div id="productosAlmuerzo" style="display:none;">
        <h4 class="text-success text-center">Almuerzo disponible</h4>

        <div class="text-center" style="margin-bottom: 15px;">
          <button id="btnMostrarConSopa" class="btn btn-info"><i class="fa fa-tint"></i> Con Sopa</button>
          <button id="btnMostrarSinSopa" class="btn btn-warning"><i class="fa fa-drumstick-bite"></i> Sin Sopa</button>
        </div>

<!-- 🍲 SOPA -->
<div id="grupoSopa" class="row" style="display:none;">
  <?php
  foreach ($productos as $prod) {
    if ($prod["id_categoria"] == $idAlmuerzo && $prod["es_sopa"] == 1 && $prod["stock"] > 0) {
      $id = $prod["id"];
      $nombre = htmlspecialchars($prod["descripcion"]);
      $precio = number_format($prod["precio_venta"], 2);
      $stock = $prod["stock"];
      $imagen = $prod["imagen"];

      echo <<<HTML
      <div class="col-sm-4 text-center" style="margin-bottom:20px;">
        <img src="$imagen" class="img-thumbnail" style="width:100px;height:100px;">
        <p><strong>$nombre</strong></p>
        <p>S/ $precio</p>
        <button class="btn btn-primary btnAgregarProductoDirecto"
                data-id="$id"
                data-nombre="$nombre"
                data-precio="{$prod['precio_venta']}"
                data-stock="$stock">
          <i class="fa fa-plus"></i> Agregar
        </button>
      </div>
HTML;
    }
  }
  ?>
</div>


<!-- 🍛 SEGUNDO -->
<div id="grupoSegundo" class="row" style="display:none;">
  <?php
  foreach ($productos as $prod) {
    if ($prod["id_categoria"] == $idAlmuerzo && $prod["es_sopa"] == 0 && $prod["stock"] > 0) {
      $id = $prod["id"];
      $nombre = htmlspecialchars($prod["descripcion"]);
      $precio = number_format($prod["precio_venta"], 2);
      $stock = $prod["stock"];
      $imagen = $prod["imagen"];

      echo <<<HTML
      <div class="col-sm-4 text-center" style="margin-bottom:20px;">
        <img src="$imagen" class="img-thumbnail" style="width:100px;height:100px;">
        <p><strong>$nombre</strong></p>
        <p>S/ $precio</p>
        <button class="btn btn-success btnAgregarProductoDirecto"
                data-id="$id"
                data-nombre="$nombre"
                data-precio="{$prod['precio_venta']}"
                data-stock="$stock">
          <i class="fa fa-plus"></i> Agregar
        </button>
      </div>
HTML;
    }
  }
  ?>
</div>
      </div>
    </div>
  </div>
</div>
    </div>
    
        </div>
<script>

  function mostrarLoader() {
  $("#loader-overlay").fadeIn(100);
}

function ocultarLoader() {
  $("#loader-overlay").fadeOut(100);
}


  let stockOriginal = 0;
  let totalAPagar = 0;


  //FUNCION ACTUALIZARRESUMEN

 function actualizarResumen(prod, cantidad, metodo, montoPago = 0) {
  const precio = parseFloat(prod.precio_venta);
  const subtotal = precio * cantidad;
  const restante = stockOriginal - cantidad;
  totalAPagar = subtotal;

  let resumen = `
    <div class="row">
      <div class="col-xs-4">
        <img src="${prod.imagen}" class="img-responsive img-thumbnail" style="max-width:100px">
      </div>
      <div class="col-xs-8">
        <p><strong>Producto:</strong> ${prod.descripcion}</p>
        <p><strong>Cantidad:</strong> ${cantidad}</p>
        <p><strong>Precio unitario:</strong> S/ ${precio.toFixed(2)}</p>
        <p><strong>Subtotal:</strong> S/ ${subtotal.toFixed(2)}</p>
        <p><strong>Stock restante:</strong> ${restante}</p>
        <p><strong>Método de pago:</strong> ${metodo || "Pendiente"}</p>
  `;

  if (metodo === 'Efectivo') {
    const vuelto = montoPago - subtotal;
    if (vuelto >= 0) {
      resumen += `<p><strong>Monto entregado:</strong> S/ ${montoPago.toFixed(2)}</p>`;
      resumen += `<p><strong>Vuelto:</strong> S/ ${vuelto.toFixed(2)}</p>`;
    } else {
      resumen += `<div class='alert alert-danger'>El monto ingresado es insuficiente</div>`;
    }
  } else if (metodo === 'Yape' || metodo === 'Plin') {
    resumen += `<p><strong>Pago confirmado vía:</strong> ${metodo}</p>`;
  } else if (metodo === 'Cuenta') {
    resumen += `<p><strong>Se cargará a la cuenta del cliente.</strong></p>`;
  }

  if (restante < 0) {
    resumen += `<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> Stock insuficiente</div>`;
  }

  resumen += `</div></div>`;
  $("#resumenVenta").html(resumen);
}

  //FUNCION ACTUALIZARBOTON
function actualizarBoton() {
  const idCliente = $("#codigoCliente").data("id") || $("#clienteManual").val();
  const metodoPago = $("#metodoPago").val();
  const montoPago = parseFloat($("#montoPago").val()) || 0;

  const hayProductos = carrito.length > 0;
  const stockSuficiente = carrito.every(item => item.cantidad > 0 && item.cantidad <= item.stock);

  // Validar paso a paso según el nuevo flujo

  // Paso 1: ¿cliente seleccionado?
  if (!idCliente) {
    $("#btnGenerarVenta").prop("disabled", true);
    return;
  }

  // Paso 2: ¿hay productos?
  if (!hayProductos || !stockSuficiente) {
    $("#btnGenerarVenta").prop("disabled", true);
    return;
  }

  // Paso 3: método de pago
  const pagoValido = metodoPago && (
    (metodoPago === 'Efectivo' && montoPago >= totalAPagar) ||
    metodoPago === 'Yape' ||
    metodoPago === 'Plin' ||
    metodoPago === 'Cuenta'
  );

  if (!pagoValido) {
    $("#btnGenerarVenta").prop("disabled", true);
    return;
  }

  // ✅ Todo válido
  $("#btnGenerarVenta").prop("disabled", false);
}


 // Interacciones menú
$("#btnMostrarDesayuno").click(function () {
  $(this).addClass("active");
  $("#btnMostrarAlmuerzo").removeClass("active");
  $("#productosDesayuno").show();
  $("#productosAlmuerzo, #grupoSopa, #grupoSegundo").hide();
});

$("#btnMostrarAlmuerzo").click(function () {
  $(this).addClass("active");
  $("#btnMostrarDesayuno").removeClass("active");
  $("#productosAlmuerzo").show();
  $("#productosDesayuno").hide();
  $("#grupoSopa").hide();
  $("#grupoSegundo").hide();
});

$("#btnMostrarConSopa").click(function () {
  $("#grupoSopa").slideDown();
  $("#grupoSegundo").slideDown();
});

$("#btnMostrarSinSopa").click(function () {
  $("#grupoSopa").slideUp();
  $("#grupoSegundo").slideDown();
});





let carrito = [];

function renderizarCarrito() {
  const tbody = $("#carritoBody");
  tbody.empty();
  let total = 0;

  carrito.forEach((item, index) => {
    const subtotal = item.precio * item.cantidad;
    total += subtotal;
    const restante = item.stock - item.cantidad;

    tbody.append(`
      <tr>
        <td><img src="${item.imagen || 'vistas/img/productos/default/anonymous.png'}" width="60" class="img-thumbnail"></td>
        <td>${item.nombre}</td>
        <td>${item.cantidad}</td>
        <td>S/ ${item.precio.toFixed(2)}</td>
        <td><span class="label label-${restante >= 0 ? 'info' : 'danger'}">${restante} disponibles</span></td>
        <td>S/ ${subtotal.toFixed(2)}</td>
        <td><button class="btn btn-danger btnEliminarItem" data-index="${index}">
          <i class="fa fa-times"></i></button>
        </td>
      </tr>
    `);
  });

  totalAPagar = total;
  $("#totalPagar").text("S/ " + total.toFixed(2));
  actualizarBoton();
}

// 🛒 Agregar producto
// ⚠️ BLOQUEAR SELECCIÓN DE PRODUCTOS SIN CLIENTE
$(document).on("click", ".btnAgregarProductoDirecto", function () {
  const idCliente = $("#codigoCliente").data("id") || $("#clienteManual").val();
  if (!idCliente) {
    swal({
      type: "warning",
      title: "Primero selecciona un cliente",
      confirmButtonText: "Entendido"
    });
    return;
  }

  const idProd = $(this).data("id");
  const nombre = $(this).data("nombre");
  const precio = parseFloat($(this).data("precio"));
  const stock = parseInt($(this).data("stock"));

  if (!idProd || !precio || !stock) {
    alert("Producto inválido o sin ID.");
    return;
  }

  const cantidad = 1;
  const existente = carrito.find(p => p.id === idProd);

  if (existente) {
    const nuevaCantidad = existente.cantidad + 1;
    if (nuevaCantidad <= stock) {
      existente.cantidad = nuevaCantidad;
    } else {
      alert("Stock insuficiente para agregar más unidades.");
      return;
    }
  } else {
    carrito.push({
      id: idProd,
      nombre: nombre,
      imagen: "",
      precio: precio,
      cantidad: cantidad,
      stock: stock
    });
  }

  renderizarCarrito();
});

// 🗑️ Eliminar producto del carrito
$(document).on("click", ".btnEliminarItem", function () {
  const index = $(this).data("index");
  carrito.splice(index, 1);
  renderizarCarrito();
});




// 🧠 Buscar cliente por código manual (input)
$("#codigoCliente").on("change", function () {
  const codigo = $(this).val().trim();
  if (!codigo) return;

  $.ajax({
    url: "ajax/buscarCliente.ajax.php",
    method: "POST",
    data: { codigo },
    dataType: "json",
    success: function (cliente) {
      if (cliente && cliente.id) {
        $("#codigoCliente").data("id", cliente.id);
        $("#clienteManual").val(cliente.id); // sincrónico con select
        $("#infoCliente").html(`
          <div class='alert alert-info'>
            <i class='fa fa-user'></i> Bienvenido, <strong>${cliente.nombre}</strong>
          </div>
        `).fadeIn();
      } else {
        $("#codigoCliente").removeData("id");
        $("#clienteManual").val(""); // limpia el select
        $("#infoCliente").html(`
          <div class='alert alert-warning'>
            Cliente no encontrado. Verifique o regístrese.
          </div>
        `).fadeIn();
      }
      actualizarBoton();
    },
    error: function (xhr) {
      console.error(xhr.responseText);
      alert("Error al buscar el cliente.");
    }
  });
});

// 🔄 Selección manual en el select dropdown
$("#clienteManual").on("change", function () {
  const selectedId = $(this).val();

  if (!selectedId) {
    $("#codigoCliente").removeData("id").val(""); // limpia input
    $("#infoCliente").hide();
    actualizarBoton();
    return;
  }

  mostrarLoader();

  // Buscar cliente por ID (igual que el código)
  $.ajax({
    url: "ajax/buscarCliente.ajax.php",
    method: "POST",
    data: { codigo: selectedId },
    dataType: "json",
    success: function (cliente) {
      if (cliente && cliente.id) {
        $("#codigoCliente").data("id", cliente.id).val(cliente.codigo || "");
        $("#infoCliente").html(`
          <div class='alert alert-info'>
            <i class='fa fa-user'></i> Cliente: <strong>${cliente.nombre}</strong>
          </div>
        `).fadeIn();
      } else {
        $("#codigoCliente").removeData("id").val("");
        $("#infoCliente").html(`
          <div class='alert alert-warning'>
            Cliente no encontrado. Verifique o regístrese.
          </div>
        `).fadeIn();
      }
      actualizarBoton();
    },
     complete: function () {
      ocultarLoader(); // ✅ FINAL
    },
    error: function (xhr) {
      console.error(xhr.responseText);
      alert("Error al obtener el cliente.");
      ocultarLoader();
    }
  });
});



  $("#formNuevoCliente").on("submit", function (e) {
  e.preventDefault();

  $.ajax({
    url: "ajax/agregarCliente.ajax.php",
    method: "POST",
    data: $(this).serialize(),
    dataType: "json",
    success: function (res) {
      if (res === "ok") {
        $.ajax({
          url: "ajax/obtenerClientes.ajax.php",
          method: "POST",
          dataType: "json",
          success: function (clientes) {
            let opciones = '<option value="">-- Seleccione un cliente --</option>';
            clientes.forEach(c => {
              opciones += `<option value="${c.id}">${c.nombre}</option>`;
            });

            $("#clienteManual").html(opciones);

            const nuevoCliente = clientes[clientes.length - 1];
            $("#clienteManual").val(nuevoCliente.id).trigger("change");

            $('#modalAgregarCliente').modal('hide');
            $("#formNuevoCliente")[0].reset();

            swal({
              type: "success",
              title: "Cliente guardado correctamente",
              confirmButtonText: "Continuar"
            });
          }
        });
      } else {
        swal({
          type: "error",
          title: "Error",
          text: "No se pudo guardar el cliente.",
          confirmButtonText: "Cerrar"
        });
      }
    },
    error: function (xhr) {
      console.error(xhr.responseText);
      swal({
        type: "error",
        title: "Error de servidor",
        text: "Ocurrió un error inesperado.",
        confirmButtonText: "Cerrar"
      });
    }
  });
});


  // Guardar nuevo cliente
$("#btnGuardarNuevoCliente").on("click", function () {
  const nombre = $("#nombreNuevoCliente").val().trim();
  const contacto = $("#contactoNuevoCliente").val().trim();

  if (!nombre) {
    alert("El nombre es obligatorio.");
    return;
  }

  $.ajax({
    url: "ajax/agregarCliente.ajax.php",
    method: "POST",
    data: { nombre, contacto },
    dataType: "json",
    success: function (res) {
      if (res.id) {
        $("#infoCliente").html(`
          <div class='alert alert-success'>
            <i class='fa fa-check'></i> Cliente agregado: <strong>${res.nombre}</strong>
          </div>
        `).fadeIn();

        $("#codigoCliente").data("id", res.id);
        $("#formNuevoCliente").slideUp();
        actualizarBoton();
      } else {
        alert("No se pudo guardar el cliente.");
      }
    }
  });
});

// METODO DE PAGO
$("#metodoPago").on("change", function () {
  const metodo = $(this).val();

  if (carrito.length === 0) {
    swal({
      type: "warning",
      title: "Primero agrega productos al carrito",
      confirmButtonText: "Entendido"
    });
    $(this).val(""); // reset
    $("#extraPago").html("");
    return;
  }

  // ⬇️ el resto continúa como ya está
  let html = '';
  if (metodo === "Efectivo") {
    html = `
      <div class='form-group'>
        <label><i class='fa fa-money'></i> Monto con el que va a cancelar</label>
        <input type='number' id='montoPago' class='form-control input-lg' min='0' step='any'>
      </div>`;
  } else if (metodo === "Yape" || metodo === "Plin") {
    const imgSrc = metodo === "Yape" ? "vistas/img/qr_yape.png" : "vistas/img/qr_plin.png";
    html = `
      <div class='text-center'>
        <p><strong>Escanea el QR con ${metodo}:</strong></p>
        <img src='${imgSrc}' alt='QR ${metodo}' style='max-width:200px;'>
      </div>`;
  }

  $("#extraPago").html(html);

  if (metodo === "Efectivo") {
    $("#montoPago").on("input", actualizarBoton);
  }

  actualizarBoton();
});

// BOTON GENERAR VENTA
$("#btnGenerarVenta").on("click", function () {
  const idCliente = $("#codigoCliente").data("id") || $("#clienteManual").val();
  const metodoPago = $("#metodoPago").val();
  const montoPago = parseFloat($("#montoPago").val()) || 0;

  // 🔢 Cálculo de total dinámico
  const total = totalAPagar || carrito.reduce((acc, item) => acc + (item.precio * item.cantidad), 0);

  // ⚠️ Verificar datos obligatorios
  if (!idCliente || !metodoPago || carrito.length === 0) {
    return swal({
      type: "warning",
      title: "Faltan datos",
      text: "Completa toda la información y añade al menos un producto.",
      confirmButtonText: "Cerrar"
    });
  }

  // ✅ Validación dinámica según método
  const pagoValido = metodoPago && (
    (metodoPago === 'Efectivo' && montoPago >= total) ||
    metodoPago === 'Yape' ||
    metodoPago === 'Plin' ||
    metodoPago === 'Cuenta'
  );

  if (!pagoValido) {
    return swal({
      type: "warning",
      title: "Pago inválido",
      text: "Verifica el monto entregado o elige un método válido.",
      confirmButtonText: "Corregir"
    });
  }

  // 🔄 Preparar botón
  $("#btnGenerarVenta")
    .html('<i class="fa fa-spinner fa-spin"></i> Procesando...')
    .prop("disabled", true);

  // 📡 Enviar AJAX
  $.ajax({
    url: "ajax/ventasCliente.ajax.php",
    method: "POST",
    data: {
      idCliente: idCliente,
      metodoPago: metodoPago,
      montoPago: montoPago,
      carrito: JSON.stringify(carrito)
    },
    dataType: "json",
    success: function (res) {
      if (res.respuesta === "ok") {
        // 🧾 Abrir ticket
        window.open("extensiones/tcpdf/pdf/ticket.php?codigo=" + res.codigo, "_blank");

        // 🎉 Confirmación
        swal({
          type: "success",
          title: "Venta generada correctamente",
          confirmButtonText: "Cerrar"
        }).then(() => location.reload());
      } else {
        swal({
          type: "error",
          title: "Error",
          text: res.mensaje || "No se pudo completar la venta",
          confirmButtonText: "Cerrar"
        });
        $("#btnGenerarVenta").html("Generar Venta").prop("disabled", false);
      }
    },
    error: function (xhr) {
      console.error(xhr.responseText);
      swal({
        type: "error",
        title: "Error del servidor",
        text: "No se pudo generar la venta. Intenta nuevamente.",
        confirmButtonText: "Cerrar"
      });
      $("#btnGenerarVenta").html("Generar Venta").prop("disabled", false);
    }
  });
});


$("#btnVaciarCarrito").on("click", function () {
  if (carrito.length === 0) {
    swal("Carrito vacío", "No hay productos para eliminar", "info");
    return;
  }

  swal({
    title: "¿Vaciar carrito?",
    text: "Todos los productos serán eliminados",
    icon: "warning",
    buttons: ["Cancelar", "Sí, vaciar"],
    dangerMode: true
  }).then((confirmado) => {
    if (confirmado) {
      carrito = [];
      renderizarCarrito();
    }
  });
});

$("#inputBuscarProducto").on("keyup", function () {
  const termino = $(this).val().toLowerCase().trim();

  $(".box-body .row .col-sm-4").each(function () {
    const nombre = $(this).find("p strong").text().toLowerCase();

    if (nombre.includes(termino)) {
      $(this).fadeIn();
    } else {
      $(this).fadeOut();
    }
  });
});
</script>