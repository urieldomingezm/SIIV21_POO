-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 17-04-2025 a las 05:45:09
-- Versión del servidor: 8.0.41
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `instituto_tecnologico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes`
--

CREATE TABLE `aspirantes` (
  `id` int NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `curp` varchar(18) NOT NULL,
  `celular` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nip` varchar(200) NOT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `aspirantes`
--

INSERT INTO `aspirantes` (`id`, `apellido_paterno`, `apellido_materno`, `nombre`, `fecha_nacimiento`, `sexo`, `curp`, `celular`, `email`, `nip`, `fecha_registro`) VALUES
(5, 'DOMINGUEZ', 'MEDINA', 'ANGEL URIEL', '2002-12-27', 'H', 'DOMA021227HTSMDNA5', '8341620284', 'urielmedina7u7@outlook.com', '$2y$10$8a/s4J3oVooFle5ka6H57uycakaXtS34Me/FH34Rbn5LUcIs9tKfS', '2025-04-13 23:25:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `numero_control` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipo_usuario` enum('alumno','personal') NOT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `ultimo_acceso` timestamp NULL DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `numero_control`, `password`, `tipo_usuario`, `activo`, `ultimo_acceso`, `fecha_registro`) VALUES
(5, 'uriel', '$2y$10$snzzk9Ud6XosMEz0SpWFBucTSqyXEmkCb1YilnnGKuQO47PYM0fo2', 'personal', 1, '2025-04-16 16:47:40', '2025-04-13 13:30:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aspirantes`
--
ALTER TABLE `aspirantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curp` (`curp`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_control` (`numero_control`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aspirantes`
--
ALTER TABLE `aspirantes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
