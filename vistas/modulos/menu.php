<aside class="main-sidebar">

	 <section class="sidebar">

		<ul class="sidebar-menu">

		<?php
		// Si el usuario es Cliente, se muestra solo la opción de Venta Rápida.
		if($_SESSION["perfil"] == "Cliente"){
			echo '<li class="active">
					<a href="ventaCliente">
					  <i class="fa fa-shopping-cart"></i>
					  <span>Venta Rápida</span>
					</a>
				  </li>';
		} else {
			// Menú para los demás perfiles

		if($_SESSION["perfil"] == "Administrador"){

			echo '<li class="active">

				<a href="inicio">

					<i class="fa fa-home"></i>
					<span>Inicio</span>

				</a>

			</li>

			<li>

				<a href="usuarios">

					<i class="fa fa-user"></i>
					<span>Empleados</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Especial"){

			echo '<li>

				<a href="categorias">

					<i class="fa fa-th"></i>
					<span>Tipos de Banquetes</span>

				</a>

			</li>

			<li>

				<a href="productos">

					<i class="fa fa-product-hunt"></i>
					<span>Inventario</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){

			echo '<li>

				<a href="nuevosSuscriptores">

					<i class="fa fa-users"></i>
					<span>Suscriptores</span>

				</a>

			</li>


			<li>

				<a href="clientes">

					<i class="fa fa-users"></i>
					<span>Clientes</span>

				</a>

			</li>

			<li>

				<a href="ventaCliente">

					<i class="fa fa-users"></i>
					<span>Venta Clientes</span>

				</a>

			</li>

			<li>

				<a href="nuevosContratos">

					<i class="fa fa-users"></i>
					<span>Nuevos Contratos</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){

			echo '<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>
					
					<span>Contratos</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="ventas">
							
							<i class="fa fa-circle-o"></i>
							<span>Administrar contratos</span>

						</a>

					</li>

					<li>

						<a href="crear-venta">
							
							<i class="fa fa-circle-o"></i>
							<span>Crear contrato</span>

						</a>

					</li>';

					if($_SESSION["perfil"] == "Administrador"){

					echo '<li>

						<a href="reportes">
							
							<i class="fa fa-circle-o"></i>
							<span>Reporte de contratos</span>

						</a>

					</li>';

					}

				

				echo '</ul>

			</li>';

		}
		if($_SESSION["perfil"] == "Administrador"){

			echo '<li class="active">

				<a href="http://localhost/phpmyadmin/index.php?route=/database/structure&server=1&db=sis_inventario">

					<i class="fa fa-th"></i>
					<span>Base de datos</span>

				</a>

			</li>';

		}
	}

		?>

		</ul>

	 </section>

</aside>