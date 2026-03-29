-- Estructura de tabla para `usuarios`
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol` enum('Administrador','Usuario') COLLATE utf8mb4_unicode_ci DEFAULT 'Usuario',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para `usuarios`
INSERT INTO `usuarios` (`id`, `username`, `password`, `rol`) VALUES
(1, 'admin', '1234', 'Administrador'),
(2, 'usuario', '1234', 'Usuario');

-- Estructura de tabla para `tareas`
DROP TABLE IF EXISTS `tareas`;
CREATE TABLE IF NOT EXISTS `tareas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('pendiente','completada') COLLATE utf8mb4_unicode_ci DEFAULT 'pendiente',
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `fk_usuario_tarea` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos (tus datos reales)
INSERT INTO `tareas` (`id`, `titulo`, `estado`, `usuario_id`) VALUES
(1, 'Diseñar interfaz', 'completada', 1),
(2, 'Crear base de datos', 'completada', 1),
(3, 'Publicar', 'completada', 1),
(6, 'Ingresar datos', 'completada', 2),
(7, 'Crear reportes', 'completada', 2),
(8, 'Crear usuarios', 'pendiente', 1);