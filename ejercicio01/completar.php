<?php
session_start();
if (!isset($_SESSION['user'])) exit(header("Location: login.php"));
include(__DIR__ . "/../config/conexion.php");

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("UPDATE tareas SET estado='completada' WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: index.php?msg=actualizado");