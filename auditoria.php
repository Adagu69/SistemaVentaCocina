<?php
// 🧠 Mostrar errores (puedes apagar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 📦 Conexión
$host = "localhost";
$usuario = "root";
$password = "852456";
$nombreBD = "sis_inventario";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$nombreBD;charset=utf8", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

// 📋 Consultar auditoría
$sql = "SELECT * FROM auditoria_movimientos ORDER BY fecha_movimiento DESC";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$auditorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Auditoría de Movimientos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">📜 Auditoría de Movimientos de Ventas</h1>

    <?php if (count($auditorias) > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Tipo de Movimiento</th>
                    <th>Fecha</th>
                    <th>Ventas Movidas</th>
                    <th>IDs Movidos</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auditorias as $key => $auditoria): ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo htmlspecialchars($auditoria['tipo_movimiento']); ?></td>
                    <td><?php echo htmlspecialchars($auditoria['fecha_movimiento']); ?></td>
                    <td><?php echo htmlspecialchars($auditoria['ventas_movidas']); ?></td>
                    <td><?php echo htmlspecialchars($auditoria['ids_movidos']); ?></td>
                    <td>
                        <?php if ($auditoria['estado'] === 'Exitoso'): ?>
                            <span class="badge badge-success">Exitoso</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Sin Movimientos</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            No hay registros de auditoría aún.
        </div>
    <?php endif; ?>
</div>

</body>
</html>