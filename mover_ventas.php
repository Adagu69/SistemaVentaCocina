<?php
// 🧠 Mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 📦 Configuración
$host = "localhost";
$usuario = "root";
$password = "852456";
$nombreBD = "sis_inventario";

// 🧩 Conexión
try {
    $conexion = new PDO("mysql:host=$host;dbname=$nombreBD;charset=utf8", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexión establecida.<br>";
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

// 📅 Antigüedad: más de 12 meses
$fechaLimite = date('Y-m-d H:i:s', strtotime('-12 months'));

// 📋 1. Seleccionar ventas viejas
$sqlSeleccionar = "SELECT * FROM ventas WHERE fecha < :fechaLimite";
$stmt = $conexion->prepare($sqlSeleccionar);
$stmt->bindParam(":fechaLimite", $fechaLimite);
$stmt->execute();
$ventasAntiguas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 📄 Preparamos log txt
$carpetaLogs = __DIR__ . "/logs/";
if (!file_exists($carpetaLogs)) {
    mkdir($carpetaLogs, 0755, true);
}
$logFile = $carpetaLogs . "log_mover_ventas_" . date('Y-m-d') . ".txt";
$log = fopen($logFile, "a");

// Variables para auditoría
$ventasMovidas = 0;
$listaIds = [];

if (count($ventasAntiguas) > 0) {

    echo "🔎 Ventas encontradas para mover: " . count($ventasAntiguas) . "<br>";
    fwrite($log, "========== Movimiento realizado el " . date('Y-m-d H:i:s') . " ==========\n");
    fwrite($log, "Ventas movidas: " . count($ventasAntiguas) . "\n");

    foreach ($ventasAntiguas as $venta) {
        $sqlInsertar = "INSERT INTO ventas_historial (id, codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago, fecha, monto_pago)
                        VALUES (:id, :codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago, :fecha, :monto_pago)";
        $stmtInsertar = $conexion->prepare($sqlInsertar);
        $stmtInsertar->execute([
            ':id' => $venta['id'],
            ':codigo' => $venta['codigo'],
            ':id_cliente' => $venta['id_cliente'],
            ':id_vendedor' => $venta['id_vendedor'],
            ':productos' => $venta['productos'],
            ':impuesto' => $venta['impuesto'],
            ':neto' => $venta['neto'],
            ':total' => $venta['total'],
            ':metodo_pago' => $venta['metodo_pago'],
            ':fecha' => $venta['fecha'],
            ':monto_pago' => $venta['monto_pago']
        ]);

        $ventasMovidas++;
        $listaIds[] = $venta['id'];

        // Log
        fwrite($log, "ID Venta movida: " . $venta['id'] . ", Código: " . $venta['codigo'] . "\n");
    }

    // 📋 3. Borrar de ventas principal
    $ids = array_column($ventasAntiguas, 'id');
    $idsList = implode(',', array_map('intval', $ids));
    $sqlBorrar = "DELETE FROM ventas WHERE id IN ($idsList)";
    $stmtBorrar = $conexion->prepare($sqlBorrar);
    $stmtBorrar->execute();

    echo "✅ Ventas movidas exitosamente a ventas_historial.<br>";
    fwrite($log, "✅ Movimiento completado exitosamente.\n\n");

    // 🗃️ Insertar en auditoría
    $sqlAuditoria = "INSERT INTO auditoria_movimientos (tipo_movimiento, fecha_movimiento, ventas_movidas, ids_movidos, estado)
                     VALUES ('Mover ventas viejas', NOW(), :ventasMovidas, :idsMovidos, 'Exitoso')";
    $stmtAuditoria = $conexion->prepare($sqlAuditoria);
    $stmtAuditoria->execute([
        ':ventasMovidas' => $ventasMovidas,
        ':idsMovidos' => implode(',', $listaIds)
    ]);

} else {
    echo "📂 No hay ventas antiguas para mover (mayores de 12 meses).<br>";
    fwrite($log, "📂 Sin movimientos. No había ventas para archivar.\n\n");

    // Registrar en auditoría que no hubo movimientos
    $sqlAuditoria = "INSERT INTO auditoria_movimientos (tipo_movimiento, fecha_movimiento, ventas_movidas, ids_movidos, estado)
                     VALUES ('Mover ventas viejas', NOW(), 0, '', 'Sin movimientos')";
    $stmtAuditoria = $conexion->prepare($sqlAuditoria);
    $stmtAuditoria->execute();
}

// 🔒 Cerrar log
fclose($log);

?>
