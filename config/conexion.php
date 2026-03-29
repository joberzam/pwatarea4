<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tareas_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error);
    die("Error técnico en el servidor. Intente más tarde.");
}

$conn->set_charset("utf8mb4");