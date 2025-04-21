-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 21-04-2025 a las 18:50:27
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
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `alumno_id` int NOT NULL,
  `alumno_numero_control` varchar(15) NOT NULL,
  `alumno_password` varchar(200) NOT NULL,
  `alumno_rol` enum('alumno') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alumno_ultimo_acceso` timestamp NULL DEFAULT NULL,
  `alumno_fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspirantes`
--

CREATE TABLE `aspirantes` (
  `aspirante_id` int NOT NULL,
  `aspirante_apellido_paterno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aspirante_apellido_materno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aspirante_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aspirante_fecha_nacimiento` date NOT NULL,
  `aspirante_sexo` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aspirante_curp` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aspirante_celular` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aspirante_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aspirante_nip` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aspirante_fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `aspirantes`
--

INSERT INTO `aspirantes` (`aspirante_id`, `aspirante_apellido_paterno`, `aspirante_apellido_materno`, `aspirante_nombre`, `aspirante_fecha_nacimiento`, `aspirante_sexo`, `aspirante_curp`, `aspirante_celular`, `aspirante_email`, `aspirante_nip`, `aspirante_fecha_registro`) VALUES
(11, 'DOMINGUEZ', 'MEDINA', 'ANGEL URIEL', '2002-12-27', 'H', 'DOMA021227HTSMDNA5', '8341620284', 'urielmedina@gmail.com', '$2y$10$N.KEJaQO.dvkF89fqK.H6e8vxgSYi0z2RLTcW4EibmhAaDToiw/jq', '2025-04-21 18:46:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `personal_id` int NOT NULL,
  `personal_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `personal_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `personal_rol` enum('personal') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `personal_activo` tinyint(1) DEFAULT '1',
  `personal_ultimo_acceso` timestamp NULL DEFAULT NULL,
  `personal_fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`personal_id`, `personal_usuario`, `personal_password`, `personal_rol`, `personal_activo`, `personal_ultimo_acceso`, `personal_fecha_registro`) VALUES
(5, 'uriel', '$2y$10$snzzk9Ud6XosMEz0SpWFBucTSqyXEmkCb1YilnnGKuQO47PYM0fo2', 'personal', 1, '2025-04-21 18:30:03', '2025-04-13 13:30:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`alumno_id`),
  ADD UNIQUE KEY `fk_numero_control` (`alumno_numero_control`);

--
-- Indices de la tabla `aspirantes`
--
ALTER TABLE `aspirantes`
  ADD PRIMARY KEY (`aspirante_id`),
  ADD UNIQUE KEY `curp` (`aspirante_curp`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`personal_id`),
  ADD UNIQUE KEY `numero_control` (`personal_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `alumno_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aspirantes`
--
ALTER TABLE `aspirantes`
  MODIFY `aspirante_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `personal_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
