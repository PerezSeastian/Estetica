-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2025 a las 03:21:22
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `estetica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda`
--

CREATE TABLE `agenda` (
  `id_cita` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(20) NOT NULL,
  `sucursal` varchar(100) NOT NULL,
  `servicio` varchar(100) NOT NULL,
  `taxi_perruno` enum('Sí','No') DEFAULT 'No',
  `estado` varchar(20) DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `agenda`
--

INSERT INTO `agenda` (`id_cita`, `id_usuario`, `id_mascota`, `fecha`, `hora`, `sucursal`, `servicio`, `taxi_perruno`, `estado`) VALUES
(1, 7, 14, '2025-10-10', '16:15-17:15', 'sucursal2', 'baño', 'No', 'pendiente'),
(2, 7, 14, '2025-10-10', '09:30-10:30', 'sucursal1', 'baño', 'No', 'pendiente'),
(3, 7, 14, '2025-10-10', '15:00-16:00', 'sucursal1', 'baño', 'No', 'pendiente'),
(4, 7, 14, '2025-10-14', '09:30-10:30', 'sucursal1', 'baño', 'No', 'En servicio'),
(5, 7, 14, '2025-10-22', '09:30-10:30', 'sucursal2', 'baño', 'No', 'pendiente'),
(6, 7, 14, '2025-10-15', '08:30-09:30', 'sucursal1', 'baño', 'No', 'pendiente'),
(7, 7, 14, '2025-10-17', '08:30-09:30', 'sucursal1', 'baño', 'Sí', 'pendiente'),
(8, 8, 16, '2025-10-17', '22:00-23:00', 'sucursal2', 'baño', 'No', 'pendiente'),
(9, 13, 22, '2025-10-23', '08:30-09:30', 'sucursal1', 'baño', 'No', 'Terminado'),
(10, 13, 23, '2025-10-23', '22:00-23:00', 'sucursal1', 'baño', 'Sí', 'En servicio o proces');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id_sucursal` int(11) NOT NULL,
  `hora_apertura` time NOT NULL,
  `hora_cierre` time NOT NULL,
  `intervalos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`intervalos`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id_sucursal`, `hora_apertura`, `hora_cierre`, `intervalos`) VALUES
(1, '08:00:00', '22:53:00', '[{\"inicio\":\"08:30\",\"fin\":\"09:30\"},{\"inicio\":\"22:00\",\"fin\":\"23:00\"},{\"inicio\":\"11:10\",\"fin\":\"00:48\"}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascotas`
--

CREATE TABLE `mascotas` (
  `id_mascota` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `especie` varchar(50) NOT NULL,
  `raza` varchar(100) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mascotas`
--

INSERT INTO `mascotas` (`id_mascota`, `id_usuario`, `nombre`, `especie`, `raza`, `edad`, `foto`, `estado`) VALUES
(14, 7, 'Junioor', 'Perro', 'schnauzer', 7, '68eda93b56a70.jpg', 'cambio_casa'),
(15, 8, 'Junior', 'Perro', 'schnauzer', 7, '68e55b0bb2759.jpg', 'activo'),
(16, 8, 'Booz', 'Perro', 'Corriente', 3, '68e55d12be941.jpg', 'activo'),
(22, 13, 'Junior', 'Perro', 'schnauzer', 7, '68fa30c1d2394.jpg', 'activo'),
(23, 13, 'Cuphead', 'Perro', 'schnauzer', 3, NULL, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_completo` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_completo`, `telefono`, `correo`, `contrasena`, `direccion`, `estado`) VALUES
(7, 'Sebastián Santigo Pérez', '5637130708', 'sspsantiago15@gmail.com', '$2y$10$ALp5nhwd4IGywqMW6E8YU.a0wEt1s8HbEUimRk13ZV/lG7JdbYF7e', 'Peñon bajo', 'activo'),
(8, 'Dana de Santiago Péreez', '5522310064', 'dana@gmail.com', '$2y$10$FyoC.MQVJSFzhsGxh2i7qOE/gFnDbO1eUN0Ht66TTp1tNkyNQS5gu', 'Peñon bajo', 'activo'),
(13, 'Sebastián Santiago Pérez', '5637190709', 'sspsantiago@gmail.com', '$2y$10$MNBnOILqvxjSsjnMEXP0yuCy/ptD3bGaamHvCJR3wwJZ5ZpoxUtqi', 'Peñon bajo', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_mascota` (`id_mascota`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indices de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id_mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `agenda_ibfk_2` FOREIGN KEY (`id_mascota`) REFERENCES `mascotas` (`id_mascota`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD CONSTRAINT `mascotas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
