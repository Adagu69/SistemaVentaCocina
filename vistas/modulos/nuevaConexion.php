<?php  
$servername = "localhost";
$database = "sis_inventario";
$username = "root";
$password = "852456";
$port = "3306"; // Puerto MySQL personalizado
// Crear CONEXION
$conn = mysqli_connect($servername, $username, $password, $database,$port);
// Revisar CONEXION
if (!$conn) {
    die("Conexion fallida: " . mysqli_connect_error());
}
?>