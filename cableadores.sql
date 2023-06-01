-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2023 a las 00:35:12
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarTiemposTarea` (IN `p_tiempo_tarea` VARCHAR(50), IN `p_id_user` INT)   BEGIN
 
  -- Actualizar la tabla usuarios
    UPDATE usuarios SET id_estado = 1 WHERE id_usuario = p_id_user;
    
    -- Actualizar la tabla ordenes
    UPDATE ordenes SET estado_orden = 2 WHERE id_usuario_fusionador = p_id_user;

   -- Insertar en la tabla tiempos_tarea
    INSERT INTO tiempos_tarea (tiempo_tarea, id_user, id_orden)
    VALUES (p_tiempo_tarea, p_id_user, id_orden);


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

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id_orden`, `N_orden`, `direccion`, `descripcion`, `id_usuario_cableador`, `id_usuario_fusionador`, `id_zona`, `fecha_registro`, `estado_orden`) VALUES
(32, 'MDS-123466', 'Calle 70 112b 93', 'Prueba Daniel-1', 1, 9, 2, '2023-05-30 10:11:43', 2),
(33, 'MDS-123467', 'Calle 70 112b 93', 'Prueba Jairo-1', 1, 13, 3, '2023-05-30 10:11:43', 2),
(34, 'MDS-123468', 'Calle 70 112b 93', 'Prueba Daniel-2', 1, 9, 2, '2023-05-31 10:14:25', 2),
(35, 'MDS-123469', 'Calle 70 112b 93', 'Prueba Jairo-2', 1, 13, 3, '2023-05-31 10:14:41', 2),
(36, 'MDS-123470', 'carrera 100 # 13 65', 'Prueba', 1, 9, 2, '2023-06-01 14:01:06', 2);

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

--
-- Volcado de datos para la tabla `tiempos_tarea`
--

INSERT INTO `tiempos_tarea` (`id`, `tiempo_tarea`, `id_user`, `fecha`, `estado`, `id_orden`) VALUES
(72, '00:00:09', 13, '2023-05-31 10:12:30', 1, 33),
(73, '00:00:09', 9, '2023-05-31 10:13:43', 1, 32),
(74, '00:00:36', 9, '2023-05-31 10:15:40', 1, 34),
(75, '00:00:23', 13, '2023-05-31 10:17:00', 1, 35),
(76, '00:00:18', 9, '2023-06-01 15:01:46', 1, 36);

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

--
-- Volcado de datos para la tabla `tiempos_traslado`
--

INSERT INTO `tiempos_traslado` (`id`, `tiempo`, `id_user`, `fecha`, `estadoTrsa`, `id_orden`) VALUES
(12, '00:00:07', 13, '2023-05-31 10:12:17', 1, 33),
(13, '00:00:09', 9, '2023-05-31 10:13:30', 1, 32),
(14, '00:00:10', 9, '2023-05-31 10:15:00', 1, 34),
(15, '00:00:12', 13, '2023-05-31 10:16:34', 1, 35),
(16, '00:00:29', 9, '2023-06-01 15:01:19', 1, 36);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
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
(1, 'Admin', 'johanpg14@hotmail.com', '0', 'c4ca4238a0b923820dcc509a6f75849b', 'admin', 1, NULL, 1, 1),
(9, 'Daniel', 'd@hotmail.com', '3223291127', 'c4ca4238a0b923820dcc509a6f75849b', 'Daniel', 1, 2, 4, 1),
(13, 'Jairo Orlando ', 'jairoorlandoguatama@gmail.com', '3058162244', 'c4ca4238a0b923820dcc509a6f75849b', 'Jairo', 1, 3, 4, 1),
(15, 'Helver', 'helver248@hotmail.es', '3058162244', '72daa12eed01addc08e08f7a792e99b9', 'Helver', 1, 2, 2, 1);

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
(4, 'Chapinero', 1);

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
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tiempos_tarea`
--
ALTER TABLE `tiempos_tarea`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `tiempos_traslado`
--
ALTER TABLE `tiempos_traslado`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `id_zona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
