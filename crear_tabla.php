<?php
include("conexion.php");

$sql = "CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

try {
    $conn->exec($sql);
    echo "Tabla productos creada correctamente.";
} catch (PDOException $e) {
    echo "Error al crear tabla: " . $e->getMessage();
}
?>