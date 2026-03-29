<?php
session_start();
include(__DIR__ . "/../config/conexion.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'Administrador') {
    die("Acceso denegado: Se requieren permisos de administrador.");
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM tareas WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: index.php?msg=eliminado");