<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];

    $sql = "INSERT INTO productos (nombre, cantidad, precio) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nombre, $cantidad, $precio]);
}

$productos = $conn->query("SELECT * FROM productos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Inventario</h1>

<h2>Agregar producto</h2>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="number" name="cantidad" placeholder="Cantidad" required>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <button type="submit">Agregar</button>
</form>

<h2>Lista de productos</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Fecha</th>
    </tr>

    <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= $producto["id"] ?></td>
            <td><?= $producto["nombre"] ?></td>
            <td><?= $producto["cantidad"] ?></td>
            <td>$<?= $producto["precio"] ?></td>
            <td><?= $producto["fecha_creacion"] ?></td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>