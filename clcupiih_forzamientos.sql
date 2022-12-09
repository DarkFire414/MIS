-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2022 a las 18:13:45
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clcupiih`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(50) DEFAULT NULL,
  `Nombre` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`correo`, `contrasena`, `Nombre`) VALUES
('avalenciamendieta@gmail.com', 'Angel2020[]\"*', 'Angel Moises Valencia Mendieta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `boleta` int(10) UNSIGNED NOT NULL COMMENT 'Llave primaria',
  `Contrasena` varchar(100) DEFAULT NULL,
  `Nombre` varchar(80) DEFAULT NULL,
  `unidad` varchar(6) NOT NULL,
  `Planestudios` varchar(12) NOT NULL,
  `semestre` int(2) NOT NULL,
  `acceso` int(2) NOT NULL,
  `laboratorio` varchar(10) NOT NULL,
  `RFID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`boleta`, `Contrasena`, `Nombre`, `unidad`, `Planestudios`, `semestre`, `acceso`, `laboratorio`, `RFID`) VALUES
(2020680071, '$2y$10$koyuyCL6KX90ZuSjdRhvXeKvc04wnUHaOHjD61J5BUzDmLk/5F/R.', 'Joahan', 'upiih', 'MecatrÃ³nica', 7, 2, '', '12345678'),
(2020680151, '$2y$10$XKDywZYcVb5mD1RDcfdNLeWvHZtSBo1hODYdUXdxLzk7J51QIS7cW', 'Angel Moises Valencia Mendieta', 'upiih', 'MecatrÃ³nica', 7, 2, '', '3SAD2323');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forzamientos`
--

CREATE TABLE `forzamientos` (
  `id` int(11) NOT NULL,
  `laboratorio` varchar(3) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hlab`
--

CREATE TABLE `hlab` (
  `idl` varchar(4) NOT NULL,
  `id_labo` int(3) NOT NULL,
  `diasemana` varchar(10) NOT NULL,
  `horario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `hlab`
--

INSERT INTO `hlab` (`idl`, `id_labo`, `diasemana`, `horario`) VALUES
('i317', 317, 'miercoles', '7:30-9:00,9:00-10:30'),
('j317', 317, 'jueves', '9:00-10:30,10:30-12:00,15:00-16:30'),
('l317', 317, 'lunes', '7:30-9:00,9:00-10:30,10:30-12:00,15:00-16:30'),
('m317', 317, 'martes', '9:00-10:30,13:30-15:00'),
('v317', 317, 'viernes', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorio`
--

CREATE TABLE `laboratorio` (
  `id` int(3) NOT NULL,
  `disponibilidad` int(3) NOT NULL,
  `horario` varchar(100) NOT NULL,
  `edificio` int(2) NOT NULL,
  `unidad` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `laboratorio`
--

INSERT INTO `laboratorio` (`id`, `disponibilidad`, `horario`, `edificio`, `unidad`) VALUES
(317, 21, 'lunes: 12-13:30', 3, 'upiih'),
(422, 3, 'martes 12:13:30', 4, 'cecyt'),
(423, 10, 'viernes 12', 4, 'cecyt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(11) NOT NULL,
  `boleta` int(20) NOT NULL,
  `id_labo` int(3) NOT NULL,
  `estatus` int(2) NOT NULL,
  `horainicio` varchar(6) NOT NULL,
  `horatermino` varchar(6) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `boleta`, `id_labo`, `estatus`, `horainicio`, `horatermino`, `motivo`, `fecha`) VALUES
(4, 2020680071, 317, 2, '08:24', '09:25', 'xd', '2022-12-02'),
(8, 2020680151, 317, 2, '08:52', '09:52', 'srf', '2022-12-02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`correo`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`boleta`);

--
-- Indices de la tabla `forzamientos`
--
ALTER TABLE `forzamientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hlab`
--
ALTER TABLE `hlab`
  ADD PRIMARY KEY (`idl`);

--
-- Indices de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `forzamientos`
--
ALTER TABLE `forzamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
