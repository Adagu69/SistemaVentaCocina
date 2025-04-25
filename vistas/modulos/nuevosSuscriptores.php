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
      
      Nuevos suscriptores
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar nuevos suscriptores</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           <th style="width:200px">Nombre Cliente</th>
           <th>Correo</th>
           <th>Fecha de Registro</th>
         </tr> 

        </thead>

        <tbody>

        <?php
        	require('nuevaConexion.php');
	        $mostrarSuscriptores = "SELECT suscripcion.nombreSuscriptor, suscripcion.correoSuscriptor, suscripcion.fechaSuscripcion FROM suscripcion";
	        $datosSuscriptores = mysqli_query($conn,$mostrarSuscriptores);
	        if(mysqli_num_rows($datosSuscriptores) > 0){
	          while ($rowSuscriptores=mysqli_fetch_array($datosSuscriptores)) {
	          	echo'<tr>
	          			<td>'.$rowSuscriptores["nombreSuscriptor"].'</td>
	          			<td>'.$rowSuscriptores["correoSuscriptor"].'</td>
	          			<td>'.$rowSuscriptores["fechaSuscripcion"].'</td>';
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
