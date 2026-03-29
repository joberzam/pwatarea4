<?php
session_start();
include(__DIR__ . "/../config/conexion.php");

// 1. Verificamos que la petición sea POST y que el título no esté vacío
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty(trim($_POST['titulo']))) {

    $titulo = $_POST['titulo'];
    $usuario_id = (int)$_SESSION['user']['id']; // Aseguramos que sea un entero
    
    // 2. PREPARAR: Creamos el molde de la consulta
    // Los "?" son marcadores de posición (placeholders)
    $stmt = $conn->prepare("INSERT INTO tareas (titulo, usuario_id, estado) VALUES (?, ?, 'pendiente')");

    // 3. VINCULAR (Bind): Le decimos a PHP qué variables van en cada "?"
    // "si" significa: el primer dato es String (s) y el segundo es Integer (i)
    $stmt->bind_param("si", $titulo, $usuario_id);
    
    // 4. EJECUTAR: Se envía a la base de datos de forma segura
    if ($stmt->execute()) {
        header("Location: index.php?msg=creado");
    } else {
        // En desarrollo es útil ver el error, en producción se guarda en un log
        error_log("Error al insertar tarea: " . $stmt->error);
        header("Location: index.php?msg=error");
    }
    
    $stmt->close(); // Cerramos la sentencia para liberar memoria
    exit();
} else {
    // Si intentan entrar directo al archivo o envían datos vacíos
    header("Location: index.php");
    exit();
}