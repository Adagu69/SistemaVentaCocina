<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Nuevos contratos por realizar
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar nuevos contratos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           <th style="width:80px">Nombre Cliente</th>
           <th>Correo</th>
           <th>Telefono</th>
           <th>Dirección de envio</th>
           <th>Fecha del evento</th>
           <th>Tipo de evento</th>
           <th>Tipo de banquete</th> 
           <th>Numero de banquetes</th>
           <th>Comentarios</th>
           <th>Fecha de Registro</th>
         </tr> 

        </thead>

        <tbody>

        <?php
        	require('nuevaConexion.php');
	        $mostrarContratos = "SELECT contratos.id, contratos.id_nombre, contratos.id_correo, contratos.id_telefono, contratos.id_direccion, contratos.fechaDelEvento, contratos.tipoDeEvento, contratos.selBanquete, contratos.numeroDeBanquetes, contratos.comentario, contratos.id_fecha FROM contratos";
	        $datosContratos = mysqli_query($conn,$mostrarContratos);
	        if(mysqli_num_rows($datosContratos) > 0){
	          while ($rowContratos=mysqli_fetch_array($datosContratos)) {
	          	echo'<tr>
	          			<td>'.$rowContratos["id_nombre"].'</td>
	          			<td>'.$rowContratos["id_correo"].'</td>
	          			<td>'.$rowContratos["id_telefono"].'</td>
	          			<td>'.$rowContratos["id_direccion"].'</td>
	          			<td>'.$rowContratos["fechaDelEvento"].'</td>
	          			<td>'.$rowContratos["tipoDeEvento"].'</td>
	          			<td>'.$rowContratos["selBanquete"].'</td>
	          			<td>'.$rowContratos["numeroDeBanquetes"].'</td>
	          			<td>'.$rowContratos["comentario"].'</td>
	          			<td>'.$rowContratos["id_fecha"].'</td>';
              echo '</tr>';
            }
          }
        ?>
   
        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>
