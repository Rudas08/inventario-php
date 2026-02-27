<?php

if (getenv("MYSQLHOST")) {
    // Producción (Railway)
    $host = getenv("MYSQLHOST");
    $user = getenv("MYSQLUSER");
    $pass = getenv("MYSQLPASSWORD");
    $db   = getenv("MYSQLDATABASE");
    $port = getenv("MYSQLPORT");
} else {
    // Local (XAMPP)
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "inventario";
    $port = 3306;
}

$conn = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>