<?php
session_start();
include(__DIR__ . "/../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty(trim($_POST['titulo']))) {

    $titulo = $_POST['titulo'];
    $usuario_id = (int)$_SESSION['user']['id']; 

    $stmt = $conn->prepare("INSERT INTO tareas (titulo, usuario_id, estado) VALUES (?, ?, 'pendiente')");

    $stmt->bind_param("si", $titulo, $usuario_id);
    
    if ($stmt->execute()) {
        header("Location: index.php?msg=creado");
    } else {
        error_log("Error al insertar tarea: " . $stmt->error);
        header("Location: index.php?msg=error");
    }
    
    $stmt->close(); 
    exit();
} else {
    header("Location: index.php");
    exit();
}
