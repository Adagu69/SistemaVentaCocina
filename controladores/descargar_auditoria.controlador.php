<?php

/*=============================================
DESCARGAR REPORTE DE AUDITORÍA
=============================================*/

if(isset($_GET["reporteAuditoria"])){

    $tabla = "auditoria_movimientos";

    $conexion = new PDO("mysql:host=localhost;dbname=sis_inventario;charset=utf8", "root", "852456");

    $stmt = $conexion->prepare("SELECT * FROM $tabla ORDER BY fecha_movimiento DESC");

    $stmt->execute();

    $auditorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*=============================================
    CREAMOS EL ARCHIVO EXCEL
    =============================================*/

    $Name = $_GET["reporteAuditoria"].'.xls';

    header('Expires: 0');
    header('Cache-control: private');
    header("Content-type: application/vnd.ms-excel"); 
    header("Cache-Control: cache, must-revalidate"); 
    header('Content-Description: File Transfer');
    header('Last-Modified: '.date('D, d M Y H:i:s'));
    header("Pragma: public"); 
    header('Content-Disposition: attachment; filename="'.$Name.'"');
    header("Content-Transfer-Encoding: binary");

    echo utf8_decode("<table border='1'> 

        <tr> 
        <th style='font-weight:bold;'>#</th> 
        <th style='font-weight:bold;'>Tipo de Movimiento</th>
        <th style='font-weight:bold;'>Fecha de Movimiento</th>
        <th style='font-weight:bold;'>Ventas Movidas</th>
        <th style='font-weight:bold;'>IDs Movidos</th>
        <th style='font-weight:bold;'>Estado</th>
        </tr>");

    foreach ($auditorias as $key => $audit){

        echo utf8_decode("<tr>
            <td>".($key+1)."</td> 
            <td>".$audit["tipo_movimiento"]."</td>
            <td>".$audit["fecha_movimiento"]."</td>
            <td>".$audit["ventas_movidas"]."</td>
            <td>".$audit["ids_movidos"]."</td>
            <td>".$audit["estado"]."</td>  
        </tr>");
    }

    echo "</table>";

}

?>
