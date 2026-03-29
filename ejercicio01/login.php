<?php
session_start();

// 1. Redirección si ya hay sesión activa
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

include(__DIR__ . "/../config/conexion.php");

// 2. INICIALIZACIÓN: Evita el error "Undefined variable"
$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = trim($_POST['username']);
    $pass_input = trim($_POST['password']);

    if (!empty($user_input) && !empty($pass_input)) {
        // 3. SEGURIDAD: Sentencias preparadas
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $user_input, $pass_input);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows > 0) {
            $_SESSION['user'] = $res->fetch_assoc();
            header("Location: index.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
        $stmt->close();
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema Tarea 4</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body class="login-page">

<div class="card">
        <h2>Iniciar Sesión</h2>

        <?php if (!empty($error)): ?>
            <div class="error-msg">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" class="btn-add">Ingresar</button>
        </form>

        <a href="../index.php" class="btn-return">
            ← Volver al Inicio
        </a>
    </div>
</body>
</html>