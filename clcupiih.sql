-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 07, 2022 at 10:15 PM
-- Server version: 10.5.17-MariaDB-1:10.5.17+maria~deb11
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clcupiih`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrador`
--

CREATE TABLE `administrador` (
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(50) DEFAULT NULL,
  `Nombre` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrador`
--

INSERT INTO `administrador` (`correo`, `contrasena`, `Nombre`) VALUES
('avalenciamendieta@gmail.com', 'Angel2020[]\"*', 'Angel Moises Valencia Mendieta'),
('j@gmail.com', 'Joahan2001414', 'Joahan Pacheco Hernandez');

-- --------------------------------------------------------

--
-- Table structure for table `estudiante`
--

CREATE TABLE `estudiante` (
  `boleta` int(10) UNSIGNED NOT NULL COMMENT 'Llave primaria',
  `Contrasena` varchar(100) DEFAULT NULL,
  `Nombre` varchar(80) DEFAULT NULL,
  `unidad` varchar(6) NOT NULL,
  `Planestudios` varchar(12) NOT NULL,
  `semestre` int(2) NOT NULL,
  `acceso` int(2) DEFAULT NULL,
  `laboratorio` varchar(10) NOT NULL,
  `rfid` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estudiante`
--

INSERT INTO `estudiante` (`boleta`, `Contrasena`, `Nombre`, `unidad`, `Planestudios`, `semestre`, `acceso`, `laboratorio`, `rfid`) VALUES
(2015020282, '$2y$10$M.B33VQbtnLvmw7XWbkaDeIBtDJdMd6bbYtQjoyTF.arG9BjCmgoK', 'Brandon ', 'upiih', 'Mecatrónica', 7, 2, '317', '29E2FA97'),
(2020680071, '$2y$10$vK12jL/C8rCGn6YRsVr3buOzZQ7izueyB3OabCoCuTlkDJ5uPoxP2', 'Joahan Pacheco Hernandez', 'upiih', 'Mecatrónica', 7, 2, '', '87654321'),
(2020680074, '$2y$10$KUCz9mukOCIfkSU1KB3nIOjVQQNTy1wqGJCrLLFuc6O7ePrJC9rOS', 'Javier ', 'upiih', 'Mecatrónica', 7, 2, '317', '546321'),
(2020680151, '$2y$10$XKDywZYcVb5mD1RDcfdNLeWvHZtSBo1hODYdUXdxLzk7J51QIS7cW', 'Angel Moises Valencia Mendieta', 'upiih', 'Mecatrónica', 7, 1, '423', '36912150');

-- --------------------------------------------------------

--
-- Table structure for table `hlab`
--

CREATE TABLE `hlab` (
  `idl` varchar(4) NOT NULL,
  `id_labo` int(3) NOT NULL,
  `diasemana` varchar(10) NOT NULL,
  `horario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hlab`
--

INSERT INTO `hlab` (`idl`, `id_labo`, `diasemana`, `horario`) VALUES
('i317', 317, 'miercoles', '7:30-9:00,9:00-10:30'),
('i422', 422, 'miercoles', '7:30-9:00'),
('j317', 317, 'jueves', '9:00-10:30,10:30-12:00,15:00-16:30'),
('j422', 422, 'jueves', '7:30-9:00'),
('l317', 317, 'lunes', '7:30-9:00,9:00-10:30,10:30-12:00,15:00-16:30'),
('l422', 422, 'lunes', '7:30-9:00'),
('m317', 317, 'martes', '9:00-10:30,13:30-15:00'),
('m422', 422, 'martes', '7:30-9:00'),
('v317', 317, 'viernes', ''),
('v422', 422, 'viernes', '7:30-9:00');

-- --------------------------------------------------------

--
-- Table structure for table `laboratorio`
--

CREATE TABLE `laboratorio` (
  `id` int(3) NOT NULL,
  `disponibilidad` int(3) NOT NULL,
  `horario` varchar(100) NOT NULL,
  `edificio` int(2) NOT NULL,
  `unidad` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laboratorio`
--

INSERT INTO `laboratorio` (`id`, `disponibilidad`, `horario`, `edificio`, `unidad`) VALUES
(317, 4, 'lunes: 12-13:30', 3, 'upiih'),
(422, 29, '', 4, 'upiih'),
(423, 10, 'viernes 12', 4, 'cecyt');

-- --------------------------------------------------------

--
-- Table structure for table `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(10) NOT NULL,
  `rfid` varchar(15) NOT NULL,
  `laboratorio` varchar(10) NOT NULL,
  `mov` varchar(10) NOT NULL,
  `conteo` int(10) NOT NULL,
  `fecha` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movimientos`
--

INSERT INTO `movimientos` (`id`, `rfid`, `laboratorio`, `mov`, `conteo`, `fecha`) VALUES
(47, '87654321', '317', 'entrada', 5, '2022-12-08 04:11:05.890000'),
(48, '87654321', '317', 'salida', 5, '2022-12-08 04:11:53.420000');

-- --------------------------------------------------------

--
-- Table structure for table `solicitudes`
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
-- Dumping data for table `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `boleta`, `id_labo`, `estatus`, `horainicio`, `horatermino`, `motivo`, `fecha`) VALUES
(19, 2015020282, 317, 2, '13:30', '14:30', 'Xd\r\n', '2022-11-23'),
(27, 2020680071, 317, 2, '14:00', '15:00', 'xd', '2022-11-23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`correo`);

--
-- Indexes for table `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`boleta`);

--
-- Indexes for table `hlab`
--
ALTER TABLE `hlab`
  ADD PRIMARY KEY (`idl`);

--
-- Indexes for table `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
