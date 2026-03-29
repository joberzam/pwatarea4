<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include(__DIR__ . "/../config/conexion.php");
$user = $_SESSION['user'];

// Consulta segura
$sql = ($user['rol'] === 'Administrador') 
    ? "SELECT * FROM tareas ORDER BY id DESC" 
    : "SELECT * FROM tareas WHERE usuario_id = ? ORDER BY id DESC";

$stmt = $conn->prepare($sql);
if ($user['rol'] !== 'Administrador') $stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gestor de Tareas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h2>Dashboard - Gestor de tareas</h2>
    <div class="user-info">
        <span><strong><?php echo htmlspecialchars($user['username']); ?></strong> (<?php echo $user['rol']; ?>)</span>
        <a href="logout.php"><button class="btn-delete" style="margin-left:15px">Salir</button></a>
    </div>
</header>

<div class="container">
    <div class="card">
        <h3>Nueva Tarea</h3>
        <form action="agregar.php" method="POST" class="task-form">
            <input type="text" name="titulo" placeholder="¿Qué hay que hacer hoy?" required>
            <button type="submit" class="btn-add">Añadir</button>
        </form>
    </div>

    <h3>Tus Tareas</h3>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="card task-item <?php echo $row['estado']; ?>">
            <div style="display:flex; justify-content:space-between; align-items:start">
                <div>
                    <h4><?php echo htmlspecialchars($row['titulo']); ?></h4>
                    <span class="estado <?php echo $row['estado']; ?>"><?php echo $row['estado']; ?></span>
                </div>
                <div class="actions">
                    <?php if($row['estado'] !== 'completada'): ?>
                        <a href="completar.php?id=<?php echo $row['id']; ?>" class="btn-complete">✔</a>
                    <?php endif; ?>
                    
                    <?php if($user['rol'] == 'Administrador'): ?>
                        <a href="eliminar.php?id=<?php echo $row['id']; ?>" 
                           onclick="return confirm('¿Eliminar definitivamente?')" class="btn-delete">🗑</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>