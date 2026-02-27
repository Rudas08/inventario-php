<?php
include("conexion.php");

/* INSERTAR */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {
    $nombre = $_POST["nombre"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];

    $sql = "INSERT INTO productos (nombre, cantidad, precio, descripcion)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$nombre, $cantidad, $precio, $descripcion]);
}

/* ELIMINAR */
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);
}

/* ACTUALIZAR */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {

    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];

    $sql = "UPDATE productos 
            SET nombre = ?, cantidad = ?, precio = ?, descripcion = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$nombre, $cantidad, $precio, $descripcion, $id]);
}

$productos = $conn->query("SELECT * FROM productos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Inventario</title>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="container">
            <h1>Inventario</h1>
            <div class="card">
                <h2>Agregar producto</h2>

                <form method="POST" class="formulario">
                    <div class="campo">
                        <label>Nombre</label>
                        <input type="text" name="nombre" required>
                    </div>

                    <div class="campo">
                        <label>Cantidad</label>
                        <input type="number" name="cantidad" required>
                    </div>

                    <div class="campo">
                        <label>Precio</label>
                        <input type="number" step="0.01" name="precio" required>
                    </div>

                    <div class="campo">
                        <label>Descripción</label>
                        <textarea name="descripcion"></textarea>
                    </div>

                    <button type="submit" name="agregar" class="btn">
                        Agregar producto
                    </button>
                </form>
            </div>
            <div class="card">
                <h2>Lista de productos</h2>

                <div class="tabla-container">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?= $producto["id"] ?></td>
                                <td><?= $producto["nombre"] ?></td>
                                <td><?= $producto["cantidad"] ?></td>
                                <td>$<?= $producto["precio"] ?></td>
                                <td><?= $producto["descripcion"] ?></td>
                                <td>
                                    <button class="editar-btn"
                                        onclick="abrirModal(
                                            <?= $producto['id'] ?>,
                                            '<?= htmlspecialchars($producto['nombre'], ENT_QUOTES) ?>',
                                            <?= $producto['cantidad'] ?>,
                                            <?= $producto['precio'] ?>,
                                            '<?= htmlspecialchars($producto['descripcion'], ENT_QUOTES) ?>'
                                        )">
                                        Editar
                                    </button>

                                    <a class="eliminar"
                                       href="?eliminar=<?= $producto["id"] ?>"
                                       onclick="return confirm('¿Eliminar este producto?')">
                                       Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="cerrar" onclick="cerrarModal()">&times;</span>
                <h2>Editar producto</h2>

                <form method="POST">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="campo">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="edit_nombre" required>
                    </div>

                    <div class="campo">
                        <label>Cantidad</label>
                        <input type="number" name="cantidad" id="edit_cantidad" required>
                    </div>

                    <div class="campo">
                        <label>Precio</label>
                        <input type="number" step="0.01" name="precio" id="edit_precio" required>
                    </div>

                    <div class="campo">
                        <label>Descripción</label>
                        <textarea name="descripcion" id="edit_descripcion"></textarea>
                    </div>

                    <button type="submit" name="actualizar" class="btn">
                        Guardar cambios
                    </button>
                </form>
            </div>
        </div>
        <script>
            function abrirModal(id, nombre, cantidad, precio, descripcion) {
                document.getElementById("modal").style.display = "flex";
                document.getElementById("edit_id").value = id;
                document.getElementById("edit_nombre").value = nombre;
                document.getElementById("edit_cantidad").value = cantidad;
                document.getElementById("edit_precio").value = precio;
                document.getElementById("edit_descripcion").value = descripcion;
            }

            function cerrarModal() {
                document.getElementById("modal").style.display = "none";
            }
            </script>
    </body>
</html>