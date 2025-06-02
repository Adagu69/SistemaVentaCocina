<?php
// ventaCliente.php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

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
        <!-- AQUÍ TODO TU FORMULARIO -->
        <!-- CLIENTE, TIPO DE MENÚ, SOPA, SEGUNDO, PAGO, RESUMEN, BOTÓN GENERAR -->
        <!-- Mueve aquí todo lo que ya tienes desde 'Seleccionar Cliente' hasta el botón Generar -->
      </div>
    </div>

  </div>

  <!-- 🔸 COLUMNA DERECHA - PRODUCTOS DISPONIBLES -->
  <div class="col-md-7">

    <div class="box box-warning">
      <div class="box-header with-border">
        <h4 class="box-title"><i class="fa fa-cutlery"></i> Productos disponibles</h4>
      </div>
      <div class="box-body">
        <div class="row">
          <?php
          $productos = ControladorProductos::ctrMostrarProductos(null, null, "id");
          foreach ($productos as $prod) {
            echo '
              <div class="col-sm-4 text-center" style="margin-bottom:20px;">
                <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail" style="width:100px;height:100px;">
                <p><strong>' . $prod["descripcion"] . '</strong></p>
                <p>S/ ' . number_format($prod["precio_venta"], 2) . '</p>
                <button class="btn btn-success btnAgregarProductoDirecto" 
                        data-id="' . $prod["id"] . '" 
                        data-nombre="' . $prod["descripcion"] . '" 
                        data-precio="' . $prod["precio_venta"] . '" 
                        data-stock="' . $prod["stock"] . '">
                  <i class="fa fa-plus"></i> Agregar
                </button>
              </div>';
          }
          ?>
        </div>
      </div>
    </div>

  </div>

</div>


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
          <label for="cantidad"><i class="fa fa-sort-numeric-asc"></i> Cantidad a consumir</label>
          <input type="number" id="cantidad" class="form-control input-lg" min="1" placeholder="Ingrese cantidad">
        </div>

        <!-- MÉTODO DE PAGO -->
        <div class="form-group">
          <label for="metodoPago"><i class="fa fa-credit-card"></i> Método de Pago</label>
          <select id="metodoPago" class="form-control input-lg">
            <option value="">Seleccione un método</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Yape">Yape</option>
            <option value="Plin">Plin</option>
          </select>
        </div>

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

        <!-- RESUMEN -->
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Resumen de Compra</strong></div>
          <div class="panel-body" id="resumenVenta">
            <p class="text-muted">Aquí aparecerá el detalle del producto seleccionado.</p>
          </div>
        </div>

        <button id="btnGenerarVenta" class="btn btn-success btn-lg btn-block" disabled>
          <i class="fa fa-check"></i> Generar Venta
        </button>

      </div>
    </div>

  </section>

</div>


<script>
  let stockOriginal = 0;
  let totalAPagar = 0;
  

//FUNCION ACTUALIZARRESUMEN
  function actualizarResumen(prod, cantidad, metodo, montoPago = 0) {
    const precio = parseFloat(prod.precio_venta);
    const subtotal = precio * cantidad;
    const restante = stockOriginal - cantidad;
    totalAPagar = subtotal;

    let resumen = `
    <p><strong>Producto:</strong> ${prod.descripcion}</p>
    <p><strong>Cantidad:</strong> ${cantidad}</p>
    <p><strong>Precio unitario:</strong> S/ ${precio.toFixed(2)}</p>
    <p><strong>Subtotal:</strong> S/ ${subtotal.toFixed(2)}</p>
    <p><strong>Stock restante:</strong> ${restante}</p>
    <p><strong>Método de pago:</strong> ${metodo}</p>`;

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
    }

    if (restante < 0) {
      resumen += `<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> Stock insuficiente</div>`;
    }

    $("#resumenVenta").html(resumen);
  }

  //FUNCION ACTUALIZARBOTON
  function actualizarBoton() {
    const idCliente = $("#codigoCliente").data("id");
    const idProducto = $("#producto").val();
    const cantidad = parseInt($("#cantidad").val());
    const metodoPago = $("#metodoPago").val();
    const montoPago = parseFloat($("#montoPago").val()) || 0;

    const stockSuficiente = !isNaN(cantidad) && cantidad > 0 && stockOriginal >= cantidad;
    const pagoValido = metodoPago && ((metodoPago === 'Efectivo' && montoPago >= totalAPagar) || metodoPago === 'Yape' || metodoPago === 'Plin');

    if (idCliente && idProducto && cantidad && metodoPago && stockSuficiente && pagoValido) {
      $("#btnGenerarVenta").prop("disabled", false);
    } else {
      $("#btnGenerarVenta").prop("disabled", true);
    }
  }




//BUSAR CLIENTE
  $("#codigoCliente").on("change", function() {
    const codigo = $(this).val().trim();
    if (codigo !== "") {
      $.ajax({
        url: "ajax/buscarCliente.ajax.php",
        method: "POST",
        data: {
          codigo: codigo
        },
        dataType: "json",
        success: function(cliente) {
          if (cliente && cliente.id) {
            $("#infoCliente").html("<div class='alert alert-info'><i class='fa fa-user'></i> Bienvenido, <strong>" + cliente.nombre + "</strong></div>").fadeIn();
            $("#codigoCliente").data("id", cliente.id);
          } else {
            $("#infoCliente").html("<div class='alert alert-warning'>Cliente no encontrado. Por favor, verifique o regístrese.</div>").fadeIn();
            $("#codigoCliente").removeData("id");
          }
          actualizarBoton();
        },
        error: function(xhr) {
          console.error(xhr.responseText);
          alert("Error al buscar el cliente.");
        }
      });
    }
  });

  // Selección manual
  $("#clienteManual").on("change", function() {
    const selectedId = $(this).val();
    if (selectedId) {
      // Guardamos el id del cliente manual
      $("#codigoCliente").data("id", selectedId);
      $("#infoCliente").html("<div class='alert alert-info'><i class='fa fa-user'></i> Cliente seleccionado manualmente.</div>").fadeIn();


      // Buscar cliente por ID
      $.ajax({
        url: "ajax/buscarCliente.ajax.php",
        method: "POST",
        data: {
          codigo: codigo
        },
        dataType: "json",
        success: function(cliente) {
          if (cliente && cliente.id) {
            $("#infoCliente").html("<div class='alert alert-info'><i class='fa fa-user'></i> Cliente: <strong>" + cliente.nombre + "</strong></div>").fadeIn();
            $("#codigoCliente").data("id", cliente.id);
          } else {
            $("#infoCliente").html("<div class='alert alert-warning'>Cliente no encontrado. Por favor, verifique o regístrese.</div>").fadeIn();
            $("#codigoCliente").removeData("id");
          }
          actualizarBoton();
        },
        error: function(xhr) {
          console.error(xhr.responseText);
          alert("Error al buscar el cliente.");
        }
      });
    } else {
      // Si no hay selección
      $("#codigoCliente").removeData("id");
      $("#infoCliente").hide();
      actualizarBoton();
    }
  });



  $("#formNuevoCliente").on("submit", function(e) {
    e.preventDefault();

    $.ajax({
      url: "ajax/agregarCliente.ajax.php",
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        if (res === "ok") {

          // Obtener clientes actualizados
          $.ajax({
            url: "ajax/obtenerClientes.ajax.php",
            method: "POST",
            dataType: "json",
            success: function(clientes) {

              let opciones = '<option value="">-- Seleccione un cliente --</option>';
              clientes.forEach(function(cliente) {
                opciones += `<option value="${cliente.id}">${cliente.nombre}</option>`;
              });

              // Actualizar el select manual
              $("#clienteManual").html(opciones);

              // Seleccionar automáticamente al último agregado
              const nuevoCliente = clientes[clientes.length - 1];
              $("#clienteManual").val(nuevoCliente.id).trigger("change");

              // Cerrar modal
              $('#modalAgregarCliente').modal('hide');

              // Limpiar campos del formulario
              $("#formNuevoCliente")[0].reset();

              // Mostrar mensaje de éxito
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
      error: function(xhr) {
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
  $("#btnGuardarNuevoCliente").on("click", function() {
    const nombre = $("#nombreNuevoCliente").val().trim();
    const contacto = $("#contactoNuevoCliente").val().trim();

    if (nombre === "") {
      alert("El nombre es obligatorio.");
      return;
    }

    $.ajax({
      url: "ajax/agregarCliente.ajax.php",
      method: "POST",
      data: {
        nombre: nombre,
        contacto: contacto
      },
      dataType: "json",
      success: function(res) {
        if (res.id) {
          $("#infoCliente").html("<div class='alert alert-success'><i class='fa fa-check'></i> Cliente agregado: <strong>" + res.nombre + "</strong></div>").fadeIn();
          $("#codigoCliente").data("id", res.id);
          $("#formNuevoCliente").slideUp();
          actualizarBoton();
        } else {
          alert("No se pudo guardar el cliente.");
        }
      }
    });
  });

  $("#producto").on("change", function() {
    const idProd = $(this).val();
    if (idProd) {
      $.ajax({
        url: "ajax/obtenerProducto.ajax.php",
        method: "POST",
        data: {
          id: idProd
        },
        dataType: "json",
        success: function(prod) {
          if (prod) {
            stockOriginal = parseInt(prod.stock);
            $("#producto option:selected").data("precio", prod.precio_venta);
            actualizarResumen(prod, 0, "");
            actualizarBoton();
          }
        },
        error: function() {
          alert("Error al obtener el producto.");
        }
      });
    }
  });


  $("#cantidad").on("input", function() {
    const cantidad = parseInt($(this).val());
    const idProd = $("#producto").val();
    const metodo = $("#metodoPago").val();
    const montoPago = parseFloat($("#montoPago").val()) || 0;

    if (idProd && !isNaN(cantidad) && cantidad > 0) {
      $.ajax({
        url: "ajax/obtenerProducto.ajax.php",
        method: "POST",
        data: {
          id: idProd
        },
        dataType: "json",
        success: function(prod) {
          if (prod) {
            stockOriginal = parseInt(prod.stock);
            actualizarResumen(prod, cantidad, metodo, montoPago);
            actualizarBoton();
          }
        }
      });
    }
  });

  $("#metodoPago").on("change", function() {
    const metodo = $(this).val();
    let html = '';
    if (metodo === "Efectivo") {
      html = `<div class='form-group'>
              <label><i class='fa fa-money'></i> Monto con el que va a cancelar</label>
              <input type='number' id='montoPago' class='form-control input-lg' min='0' step='any'>
            </div>`;
    } else if (metodo === "Yape" || metodo === "Plin") {
      const imgSrc = metodo === "Yape" ? "vistas/img/qr_yape.png" : "vistas/img/qr_plin.png";
      html = `<div class='text-center'>
              <p><strong>Escanea el QR con ${metodo}:</strong></p>
              <img src='${imgSrc}' alt='QR ${metodo}' style='max-width:200px;'>
            </div>`;
    }
    $("#extraPago").html(html);
    $("#montoPago").on("input", function() {
      const cantidad = parseInt($("#cantidad").val());
      const idProd = $("#producto").val();
      const monto = parseFloat($(this).val());

      if (idProd && cantidad) {
        $.ajax({
          url: "ajax/obtenerProducto.ajax.php",
          method: "POST",
          data: {
            id: idProd
          },
          dataType: "json",
          success: function(prod) {
            actualizarResumen(prod, cantidad, metodo, monto);
            actualizarBoton();
          }
        });
      }
    });
    actualizarBoton();
  });


  $("#btnGenerarVenta").on("click", function() {
    const idCliente = $("#codigoCliente").data("id");
    const idProducto = $("#producto").val();
    const cantidad = $("#cantidad").val();
    const metodoPago = $("#metodoPago").val();
    const montoPago = $("#montoPago").val() || 0;

    if (!idCliente || !idProducto || !cantidad || !metodoPago ||
      (metodoPago === "Efectivo" && montoPago < totalAPagar)) {
      swal({
        type: "warning",
        title: "Faltan datos",
        text: "Verifica que todos los campos estén completos y el monto sea suficiente.",
        confirmButtonText: "Cerrar"
      });
      return;
    }

          // 🔥 SPINNER Y BLOQUEO DE BOTÓN
  $("#btnGenerarVenta").html('<i class="fa fa-spinner fa-spin"></i> Procesando...');
  $("#btnGenerarVenta").prop("disabled", true);

  // ⚡ ENVÍO AJAX
    $.ajax({
      url: "ajax/ventasCliente.ajax.php",
      method: "POST",
      dataType: "json",
      data: {
        idCliente: idCliente,
        idProducto: idProducto,
        cantidad: cantidad,
        metodoPago: metodoPago,
        montoPago: montoPago
      },
     success: function(res) {
  console.log("RESPUESTA:", res);
  if (res.respuesta && res.respuesta.toLowerCase() === "ok") {
    swal({
      type: "success",
      title: "Venta registrada correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result) {
      if (result.value) {
        // Limpiar formulario
        $("#codigoCliente").val("").removeData("id");
        $("#producto").val("");
        $("#cantidad").val("");
        $("#metodoPago").val("");
        $("#montoPago").val("");
        $("#infoCliente").html("").hide();
        $("#resumenVenta").html(`<p class="text-muted">Aquí aparecerá el detalle del producto seleccionado.</p>`);
        $("#extraPago").html("");
        $("#btnGenerarVenta").prop("disabled", true);
        // 👇 RESTAURAR BOTÓN
        $("#btnGenerarVenta").html('<i class="fa fa-check"></i> Generar Venta');
      }
    });
  } else {
    swal({
      type: "error",
      title: "Error",
      text: "Ocurrió un error al registrar la venta: " + JSON.stringify(res),
      confirmButtonText: "Cerrar"
    });
    // 👇 RESTAURAR BOTÓN
    $("#btnGenerarVenta").html('<i class="fa fa-check"></i> Generar Venta');
    $("#btnGenerarVenta").prop("disabled", false);
  }
},
error: function(xhr) {
  swal({
    type: "error",
    title: "Error de conexión",
    text: "No se pudo procesar la venta.",
    confirmButtonText: "Cerrar"
  });
  console.error("ERROR EN LA VENTA:", xhr.responseText);
  // 👇 RESTAURAR BOTÓN
  $("#btnGenerarVenta").html('<i class="fa fa-check"></i> Generar Venta');
  $("#btnGenerarVenta").prop("disabled", false);
}
    });
  });
</script>