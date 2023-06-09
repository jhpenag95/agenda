-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2023 a las 23:14:09
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cableadores`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_estadisticas` ()   BEGIN
    DECLARE despachadores INT;
    DECLARE cableadores INT;
    DECLARE fusionadores INT;
    DECLARE ordenes_finalizadas INT;
    DECLARE ordenes_en_tarea INT;
    
    SELECT COUNT(*) INTO despachadores FROM usuarios WHERE id_rol = 2;
    SELECT COUNT(*) INTO cableadores FROM usuarios WHERE id_rol = 3;
    SELECT COUNT(*) INTO fusionadores FROM usuarios WHERE id_rol = 4;
    SELECT COUNT(*) INTO ordenes_finalizadas FROM ordenes WHERE estado_orden = 2;
    SELECT COUNT(*) INTO ordenes_en_tarea FROM ordenes WHERE estado_orden = 1;
    
    SELECT despachadores, cableadores, fusionadores, ordenes_finalizadas, ordenes_en_tarea;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_tarea`
--

CREATE TABLE `estado_tarea` (
  `id_estado_tarea` int(11) NOT NULL,
  `Nombre_estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_tarea`
--

INSERT INTO `estado_tarea` (`id_estado_tarea`, `Nombre_estado`) VALUES
(1, 'Disponible'),
(2, 'En tarea'),
(3, 'No Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id_orden` int(11) NOT NULL,
  `N_orden` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `id_usuario_cableador` int(11) DEFAULT NULL,
  `id_usuario_fusionador` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_orden` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Despachador'),
(3, 'Cableador'),
(4, 'Fusionador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempos_tarea`
--

CREATE TABLE `tiempos_tarea` (
  `id` int(100) NOT NULL,
  `tiempo_tarea` varchar(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_orden` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempos_traslado`
--

CREATE TABLE `tiempos_traslado` (
  `id` int(100) NOT NULL,
  `tiempo` varchar(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estadoTrsa` int(100) NOT NULL DEFAULT 1,
  `id_orden` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `clave` varchar(1000) NOT NULL,
  `nombre_usuario` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `id_zona` int(11) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `telefono`, `clave`, `nombre_usuario`, `estado`, `id_zona`, `id_rol`, `id_estado`) VALUES
(28, 'Admin', 'helver248@hotmail.es', '3058162244', '$2y$10$N3ZnbAS8UKmjxxAblQxki.xQNJrjx9sivDoTmCXVAKQjtHoPSYwx2', 'admin', 1, 5, 1, 1),
(33, 'Helver', 'helver24@hotmail.es', '3058162244', '$2y$10$.og/DqzXqzb/WS4lc5aI1eusIW0McFZJ4t/z.zdbpN4KURxa0vvZa', 'Johan', 1, 2, 3, 1),
(34, 'Brando', 'br@hotmail.com', '3058162244', '$2y$10$NI09rXbKQv4t70qk74WsIuQF3SkSSUS6FeJXYbsqannxwPyYlFToa', 'Brandon', 1, 3, 4, 1),
(35, 'Jairo', 'johanpg14@hotmail.com', '3058162244', '$2y$10$.og/DqzXqzb/WS4lc5aI1eusIW0McFZJ4t/z.zdbpN4KURxa0vvZa', 'Jairo', 1, 2, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE `zonas` (
  `id_zona` int(11) NOT NULL,
  `nombre_zona` varchar(50) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`id_zona`, `nombre_zona`, `estado`) VALUES
(2, 'Fontibón ', 1),
(3, 'Engativa', 1),
(4, 'Chapinero', 1),
(5, 'N/A', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estado_tarea`
--
ALTER TABLE `estado_tarea`
  ADD PRIMARY KEY (`id_estado_tarea`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `ordenes_ibfk_3` (`id_zona`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tiempos_tarea`
--
ALTER TABLE `tiempos_tarea`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_orden` (`id_orden`);

--
-- Indices de la tabla `tiempos_traslado`
--
ALTER TABLE `tiempos_traslado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_orden` (`id_orden`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `usuarios_ibfk_2` (`id_rol`),
  ADD KEY `usuarios_ibfk_1` (`id_zona`),
  ADD KEY `fk_estado` (`id_estado`);

--
-- Indices de la tabla `zonas`
--
ALTER TABLE `zonas`
  ADD PRIMARY KEY (`id_zona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estado_tarea`
--
ALTER TABLE `estado_tarea`
  MODIFY `id_estado_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tiempos_tarea`
--
ALTER TABLE `tiempos_tarea`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de la tabla `tiempos_traslado`
--
ALTER TABLE `tiempos_traslado`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `id_zona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_3` FOREIGN KEY (`id_zona`) REFERENCES `zonas` (`id_zona`);

--
-- Filtros para la tabla `tiempos_tarea`
--
ALTER TABLE `tiempos_tarea`
  ADD CONSTRAINT `tiempos_tarea_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_orden`);

--
-- Filtros para la tabla `tiempos_traslado`
--
ALTER TABLE `tiempos_traslado`
  ADD CONSTRAINT `tiempos_traslado_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_orden`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado_tarea` (`id_estado_tarea`),
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_zona`) REFERENCES `zonas` (`id_zona`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
