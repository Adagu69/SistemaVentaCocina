<?php
// 🧠 Activamos todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 📦 CONFIG
$host = "localhost";
$usuario = "root"; // o backup_user si quieres
$password = "852456"; // contraseña
$nombreBD = "sis_inventario";

// 📂 Carpeta backups
$carpetaBackup = __DIR__ . "/backups/";
if (!file_exists($carpetaBackup)) {
    mkdir($carpetaBackup, 0755, true);
}

// 📆 Nombre del archivo
$fecha = date("Y-m-d_H-i-s");
$archivoRespaldo = $carpetaBackup . "backup_" . $nombreBD . "_" . $fecha . ".sql";

// 📤 Comando usando cmd
$comando = "cmd /c \"C:\\xampp\\mysql\\bin\\mysqldump.exe --user=$usuario --password=$password $nombreBD\"";

echo "🧪 Ejecutando: $comando<br>";

$salida = shell_exec($comando);

// 🔥 Guardar backup
if (!empty($salida)) {
    file_put_contents($archivoRespaldo, $salida);
    echo "✅ Backup creado: $archivoRespaldo";
} else {
    echo "❌ Backup falló. No se generó salida.";
}
?>
