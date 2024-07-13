-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-12-2023 a las 20:30:34
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `barjuan`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandas`
--

CREATE TABLE `comandas` (
  `idComanda` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `idMesa` int(11) NOT NULL,
  `comensales` int(11) NOT NULL,
  `detalles` varchar(250) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'TRUE en espera, FALSE finalizada '
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `comandas`
--

INSERT INTO `comandas` (`idComanda`, `fecha`, `idMesa`, `comensales`, `detalles`, `estado`) VALUES
(1, '2023-01-01 00:00:00', 1, 4, 'Detalles mesa 1', 0),
(2, '2023-01-02 00:00:00', 2, 2, 'Detalles mesa 2', 0),
(3, '2023-01-03 00:00:00', 3, 6, 'Detalles mesa 3', 0),
(4, '2023-01-07 00:00:00', 10, 3, 'Detalles para la mesa 4', 0),
(5, '2023-01-05 00:00:00', 5, 3, 'Detalles mesa 5', 0),
(6, '2023-01-06 00:00:00', 6, 5, 'Detalles mesa 6', 0),
(7, '2023-01-07 00:00:00', 7, 4, 'Detalles mesa 7', 1),
(8, '2023-01-08 00:00:00', 8, 7, 'Detalles mesa 8', 0),
(9, '2023-01-09 00:00:00', 9, 2, 'Detalles mesa 9', 1),
(10, '2023-01-10 00:00:00', 10, 6, 'Detalles mesa 10', 0),
(19, '2023-12-24 00:00:00', 1, 3, 'Alergias alimentarias', 1),
(20, '2023-12-24 00:00:00', 1, 3, 'Alergias alimentarias', 1),
(21, '2023-12-24 00:00:00', 1, 3, 'Alergias alimentarias', 1),
(22, '2023-12-24 00:00:00', 1, 3, 'Alergias alimentarias', 1),
(23, '2023-12-24 00:00:00', 1, 3, 'Alergias alimentarias', 1),
(30, '2023-12-24 00:00:00', 1, 3, 'Alergias alimentarias', 1),
(31, '2023-12-24 00:00:00', 1, 3, 'Alergias alimentarias', 1),
(35, '2023-12-24 00:00:00', 1, 3, 'Alergias alimentarias', 0),
(36, '2023-12-24 00:00:00', 1, 3, 'Alergias alimentarias', 1),
(37, '2023-12-26 00:00:00', 8, 6, 'Alergias alimentarias', 1),
(38, '2023-12-26 00:00:00', 8, 6, 'Alergias alimentarias', 1),
(39, '2023-12-26 00:00:00', 8, 6, 'Alergias alimentarias', 1),
(40, '2023-12-26 00:00:00', 8, 6, 'Alergias alimentarias', 1),
(41, '2023-12-26 22:14:07', 10, 3, 'Alergias alimentarias frutos secos', 1),
(42, '2023-12-27 00:37:54', 1, 3, NULL, 1),
(43, '2023-12-27 00:40:15', 1, 3, NULL, 0),
(44, '2023-12-27 00:40:47', 1, 3, NULL, 1),
(45, '2023-12-27 23:30:51', 10, 2, NULL, 1),
(46, '2023-12-28 13:09:11', 1, 3, NULL, 1),
(47, '2023-12-27 12:00:00', 1, 3, NULL, 1),
(48, '2023-12-27 13:00:00', 1, 4, NULL, 0),
(49, '2023-12-26 13:00:00', 3, 5, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineascomandas`
--

CREATE TABLE `lineascomandas` (
  `idlinea` int(11) NOT NULL,
  `idComanda` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` decimal(8,2) NOT NULL,
  `entregado` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'false sin entregar, true entregado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `lineascomandas`
--

INSERT INTO `lineascomandas` (`idlinea`, `idComanda`, `idProducto`, `cantidad`, `entregado`) VALUES
(1, 1, 1, 7.00, 1),
(2, 1, 10, 10.00, 1),
(3, 1, 3, 3.00, 1),
(4, 1, 4, 1.00, 1),
(5, 2, 1, 3.00, 1),
(6, 2, 2, 2.00, 1),
(7, 2, 3, 1.00, 1),
(8, 2, 4, 2.00, 1),
(9, 2, 5, 1.00, 1),
(10, 3, 1, 2.00, 1),
(11, 3, 2, 1.00, 1),
(12, 3, 3, 3.00, 1),
(13, 4, 9, 9.00, 1),
(14, 4, 9, 1.00, 1),
(15, 4, 10, 4.00, 1),
(16, 5, 5, 2.00, 1),
(17, 5, 6, 3.00, 1),
(18, 6, 7, 1.00, 1),
(19, 6, 8, 2.00, 1),
(20, 6, 9, 1.00, 1),
(21, 7, 10, 4.00, 0),
(22, 7, 6, 4.00, 1),
(23, 8, 7, 2.00, 1),
(24, 8, 8, 1.00, 1),
(25, 9, 9, 3.00, 1),
(26, 9, 10, 1.00, 1),
(27, 9, 4, 1.00, 0),
(28, 10, 5, 2.00, 1),
(29, 10, 6, 3.00, 1),
(30, 10, 7, 1.00, 1),
(31, 35, 1, 3.00, 0),
(32, 35, 5, 3.00, 1),
(33, 36, 1, 3.00, 0),
(34, 37, 1, 6.00, 0),
(35, 38, 1, 6.00, 0),
(36, 39, 1, 6.00, 0),
(37, 40, 1, 6.00, 0),
(38, 41, 10, 3.00, 0),
(39, 4, 1, 7.00, 0),
(40, 4, 1, 7.00, 0),
(41, 4, 1, 7.00, 0),
(42, 4, 1, 7.00, 0),
(43, 42, 1, 7.00, 0),
(44, 42, 10, 10.00, 0),
(45, 43, 1, 7.00, 0),
(46, 43, 10, 10.00, 1),
(47, 44, 1, 7.00, 0),
(48, 44, 10, 10.00, 0),
(49, 4, 1, 7.00, 0),
(50, 4, 1, 7.00, 0),
(51, 45, 1, 7.00, 0),
(52, 45, 10, 3.00, 0),
(53, 46, 1, 7.00, 0),
(54, 46, 10, 10.00, 0),
(55, 47, 1, 7.00, 0),
(56, 47, 10, 10.00, 0),
(57, 48, 1, 7.00, 1),
(58, 48, 10, 10.00, 1),
(59, 49, 1, 7.00, 1),
(60, 49, 10, 10.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineaspedidos`
--

CREATE TABLE `lineaspedidos` (
  `idlinea` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` decimal(8,2) NOT NULL,
  `entregado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `lineaspedidos`
--

INSERT INTO `lineaspedidos` (`idlinea`, `idPedido`, `idProducto`, `cantidad`, `entregado`) VALUES
(1, 1, 1, 4.00, 0),
(2, 6, 1, 1.00, 0),
(3, 2, 1, 3.00, 0),
(4, 7, 1, 7.00, 1),
(5, 3, 1, 5.00, 1),
(6, 8, 1, 6.00, 0),
(7, 4, 1, 1.00, 0),
(8, 9, 1, 7.00, 1),
(9, 5, 1, 8.00, 0),
(10, 10, 1, 2.00, 0),
(11, 1, 10, 9.00, 1),
(12, 6, 10, 3.00, 1),
(13, 2, 10, 5.00, 1),
(14, 7, 10, 1.00, 0),
(15, 3, 10, 1.00, 1),
(16, 8, 10, 1.00, 1),
(17, 4, 10, 5.00, 0),
(18, 9, 10, 5.00, 0),
(19, 5, 10, 3.00, 0),
(20, 10, 10, 9.00, 1),
(21, 1, 2, 6.00, 0),
(22, 6, 2, 6.00, 1),
(23, 2, 2, 3.00, 1),
(24, 7, 2, 7.00, 1),
(25, 3, 2, 3.00, 1),
(26, 8, 2, 4.00, 1),
(27, 4, 2, 2.00, 0),
(28, 9, 2, 10.00, 0),
(29, 5, 2, 6.00, 1),
(30, 10, 2, 3.00, 1),
(31, 1, 3, 8.00, 0),
(32, 6, 3, 4.00, 1),
(33, 2, 3, 9.00, 1),
(34, 7, 3, 8.00, 0),
(35, 3, 3, 10.00, 1),
(36, 8, 3, 4.00, 0),
(37, 4, 3, 2.00, 1),
(38, 9, 3, 5.00, 0),
(39, 5, 3, 1.00, 1),
(40, 10, 3, 10.00, 0),
(41, 1, 4, 3.00, 1),
(42, 6, 4, 2.00, 1),
(43, 2, 4, 6.00, 1),
(44, 7, 4, 3.00, 0),
(45, 3, 4, 10.00, 1),
(46, 8, 4, 7.00, 1),
(47, 4, 4, 2.00, 0),
(48, 9, 4, 6.00, 1),
(49, 5, 4, 7.00, 1),
(50, 10, 4, 5.00, 0),
(51, 1, 5, 2.00, 0),
(52, 6, 5, 5.00, 0),
(53, 2, 5, 2.00, 1),
(54, 7, 5, 3.00, 1),
(55, 3, 5, 7.00, 1),
(56, 8, 5, 9.00, 0),
(57, 4, 5, 2.00, 0),
(58, 9, 5, 2.00, 1),
(59, 5, 5, 3.00, 0),
(60, 10, 5, 2.00, 0),
(61, 1, 1, 45.00, 0),
(62, 96, 1, 4.00, 0),
(63, 97, 1, 5.00, 0),
(64, 98, 1, 5.00, 0),
(65, 99, 2, 6.00, 0),
(66, 100, 6, 40.00, 0),
(67, 101, 6, 40.00, 0),
(68, 102, 1, 9.00, 0),
(69, 103, 1, 9.00, 0),
(70, 104, 1, 9.00, 0),
(71, 105, 10, 2.00, 0),
(72, 106, 10, 2.00, 0),
(73, 107, 10, 2.00, 0),
(74, 108, 10, 2.00, 0),
(75, 109, 10, 2.00, 0),
(76, 110, 10, 2.00, 0),
(77, 111, 10, 2.00, 0),
(78, 125, 10, 0.00, 0),
(79, 126, 3, 6.00, 0),
(80, 127, 3, 6.00, 0),
(81, 127, 2, 4.00, 0),
(82, 127, 1, 4.00, 0),
(83, 128, 3, 6.00, 0),
(84, 128, 2, 4.00, 0),
(85, 128, 1, 4.00, 0),
(86, 129, 3, 6.00, 0),
(87, 129, 2, 4.00, 0),
(88, 129, 1, 4.00, 0),
(89, 130, 3, 6.00, 0),
(90, 130, 2, 4.00, 0),
(91, 130, 1, 4.00, 0),
(92, 131, 3, 6.00, 0),
(93, 131, 2, 4.00, 0),
(94, 131, 1, 4.00, 0),
(95, 132, 3, 6.00, 0),
(96, 132, 2, 4.00, 0),
(97, 132, 1, 4.00, 0),
(98, 133, 5, 2.00, 0),
(99, 133, 4, 2.00, 0),
(100, 133, 3, 6.00, 0),
(101, 133, 2, 4.00, 0),
(102, 133, 1, 4.00, 0),
(103, 137, 1, 4.00, 0),
(104, 138, 1, 4.00, 0),
(105, 139, 1, 4.00, 0),
(106, 140, 1, 4.00, 0),
(107, 141, 1, 4.00, 0),
(108, 142, 1, 4.00, 0),
(109, 143, 1, 4.00, 0),
(110, 144, 1, 4.00, 0),
(111, 145, 1, 3.00, 0),
(112, 145, 2, 7.00, 0),
(113, 145, 3, 9.00, 0),
(114, 145, 4, 10.00, 0),
(115, 145, 5, 2.00, 0),
(116, 145, 6, 2.00, 0),
(117, 145, 7, 2.00, 0),
(118, 145, 8, 2.00, 0),
(119, 145, 9, 2.00, 0),
(120, 145, 10, 2.00, 0),
(121, 146, 1, 3.00, 0),
(122, 146, 2, 7.00, 0),
(123, 146, 3, 9.00, 0),
(124, 146, 4, 10.00, 0),
(125, 146, 5, 2.00, 0),
(126, 146, 6, 2.00, 0),
(127, 146, 7, 2.00, 0),
(128, 146, 8, 2.00, 0),
(129, 146, 9, 2.00, 0),
(130, 146, 10, 2.00, 0),
(131, 147, 1, 3.00, 0),
(132, 147, 2, 7.00, 0),
(133, 147, 3, 9.00, 0),
(134, 147, 4, 10.00, 0),
(135, 147, 5, 2.00, 0),
(136, 147, 6, 2.00, 0),
(137, 147, 7, 2.00, 0),
(138, 147, 8, 2.00, 0),
(139, 147, 9, 2.00, 0),
(140, 147, 10, 2.00, 0),
(141, 148, 1, 3.00, 0),
(142, 148, 2, 7.00, 0),
(143, 148, 3, 9.00, 0),
(144, 148, 4, 10.00, 0),
(145, 148, 5, 2.00, 0),
(146, 148, 6, 2.00, 0),
(147, 148, 7, 2.00, 0),
(148, 148, 8, 2.00, 0),
(149, 148, 9, 2.00, 0),
(150, 148, 10, 2.00, 0),
(151, 149, 1, 3.00, 0),
(152, 150, 1, 3.00, 0),
(153, 151, 1, 3.00, 0),
(154, 151, 2, 4.00, 0),
(155, 152, 1, 3.00, 0),
(156, 152, 2, 4.00, 0),
(157, 153, 1, 3.00, 0),
(158, 153, 2, 4.00, 0),
(159, 154, 1, 3.00, 0),
(160, 154, 2, 4.00, 0),
(161, 155, 1, 1.00, 0),
(162, 155, 2, 2.00, 0),
(163, 155, 3, 3.00, 0),
(164, 155, 4, 4.00, 0),
(165, 155, 5, 5.00, 0),
(166, 155, 6, 6.00, 0),
(167, 155, 7, 7.00, 0),
(168, 155, 8, 8.00, 0),
(169, 155, 9, 9.00, 0),
(170, 155, 10, 10.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `idMesa` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `comensales` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`idMesa`, `nombre`, `comensales`) VALUES
(1, 'mesa1', 4),
(2, 'mesa2', 2),
(3, 'mesa3', 6),
(4, 'mesa4', 8),
(5, 'mesa5', 4),
(6, 'mesa6', 6),
(7, 'mesa7', 8),
(8, 'mesa8', 6),
(9, 'mesa9', 2),
(10, 'mesa10', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedidos` int(11) NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `detalles` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedidos`, `idProveedor`, `fecha`, `detalles`, `estado`) VALUES
(1, 1, '2023-01-01 08:00:00', 'Pedido de productos frescos', 0),
(2, 2, '2023-01-02 10:30:00', 'Pedido de productos gourmet', 1),
(3, 3, '2023-01-03 12:45:00', 'Pedido de suministros culinarios', 0),
(4, 4, '2023-01-04 14:00:00', 'Pedido de carnes y sabores', 1),
(5, 5, '2023-01-05 16:30:00', 'Pedido de pescados del mar azul', 0),
(6, 1, '2023-01-06 09:15:00', 'Otro pedido de productos frescos', 0),
(7, 2, '2023-01-07 11:45:00', 'Otro pedido de productos gourmet', 0),
(8, 3, '2023-01-08 13:30:00', 'Otro pedido de suministros culinarios', 0),
(9, 4, '2023-01-09 15:45:00', 'Otro pedido de carnes y sabores', 0),
(10, 5, '2023-01-10 17:00:00', 'Otro pedido de pescados del mar azul', 0),
(11, 1, '2023-12-17 00:00:00', 'sdasg', 1),
(12, 1, '2023-12-17 00:00:00', 'jgkuyolilo', 1),
(13, 1, '2023-12-17 00:00:00', 'jgjhjpgyjmpgyo', 1),
(14, 1, '2023-12-17 00:00:00', 'jgjhjpgyjmpgyo', 1),
(15, 1, '2023-12-17 01:57:08', 'jgjhjpgyjmpgyo', 1),
(16, 1, '2023-12-17 02:30:36', 'sdasg', 1),
(17, 1, '2023-12-17 02:34:34', 'sdasg', 1),
(18, 1, '2023-12-17 02:34:51', 'sdasg', 1),
(19, 1, '2023-12-17 02:34:55', 'sdasg', 1),
(20, 1, '2023-12-17 02:36:10', 'sdasg', 1),
(21, 1, '2023-12-17 02:36:59', 'sdasg', 1),
(22, 1, '2023-12-17 02:37:31', 'sdasg', 1),
(23, 1, '2023-12-17 02:39:47', 'sdasg', 1),
(24, 1, '2023-12-17 02:40:37', 'sdasg', 1),
(25, 1, '2023-12-17 02:41:16', 'sdasg', 1),
(26, 1, '2023-12-17 02:42:10', 'sdasg', 1),
(27, 1, '2023-12-17 02:43:06', 'sdasg', 1),
(28, 1, '2023-12-17 02:43:41', 'sdasg', 1),
(29, 1, '2023-12-17 02:43:49', 'sdasg', 1),
(30, 1, '2023-12-17 02:44:29', 'sdasg', 1),
(31, 1, '2023-12-17 02:45:22', 'sdasg', 1),
(32, 1, '2023-12-17 02:46:57', 'sdasg', 1),
(33, 1, '2023-12-17 02:47:43', 'sdasg', 1),
(34, 1, '2023-12-17 02:48:33', 'sdasg', 1),
(35, 1, '2023-12-17 02:53:21', 'sdasg', 1),
(36, 2, '2023-12-17 12:34:01', 'jgkuyolilo', 1),
(37, 2, '2023-12-17 12:57:05', 'sdasg', 1),
(38, 2, '2023-12-17 13:06:37', 'sdasg', 1),
(39, 1, '2023-12-17 14:20:36', 'sdasg', 1),
(40, 2, '2023-12-17 15:08:22', 'sdasg', 1),
(41, 2, '2023-12-17 15:23:45', 'rrrrrr', 1),
(42, 1, '2023-12-17 15:38:54', 'rrrrrr', 1),
(43, 1, '2023-12-17 15:39:15', 'rrrrrr', 1),
(44, 1, '2023-12-17 15:41:48', 'rrrrrr', 1),
(45, 1, '2023-12-17 15:43:33', 'jgkuyolilo', 1),
(46, 1, '2023-12-17 15:50:18', 'sdasg', 1),
(47, 3, '2023-12-17 15:53:08', 'sdasg', 1),
(48, 1, '2023-12-17 15:55:39', 'sdasg', 1),
(49, 1, '2023-12-17 15:57:38', 'sdasg', 1),
(50, 1, '2023-12-17 15:58:44', 'sdasg', 1),
(51, 1, '2023-12-17 16:00:59', 'sdasg', 1),
(52, 1, '2023-12-17 16:17:26', 'sdasg', 1),
(53, 1, '2023-12-17 16:23:03', 'sdasg', 1),
(54, 1, '2023-12-17 16:30:35', 'sdasg', 1),
(55, 1, '2023-12-17 16:40:21', 'sdasg', 1),
(56, 1, '2023-12-17 16:49:53', 'sdasg', 1),
(57, 1, '2023-12-17 16:51:18', 'erte', 1),
(58, 2, '2023-12-17 17:13:05', 'sdasg', 1),
(59, 1, '2023-12-17 17:26:26', 'sdasg', 1),
(60, 1, '2023-12-17 17:27:37', 'sdasg', 1),
(61, 1, '2023-12-17 17:28:53', 'sdasg', 1),
(62, 1, '2023-12-17 17:29:24', 'sdasg', 1),
(63, 1, '2023-12-17 17:48:48', 'sdasg', 1),
(64, 1, '2023-12-17 18:10:11', 'sdasg', 1),
(65, 1, '2023-12-17 18:11:02', 'sdasg', 1),
(66, 1, '2023-12-17 18:12:35', 'sdasg', 1),
(67, 1, '2023-12-17 18:12:58', 'sdasg', 1),
(68, 1, '2023-12-17 18:13:24', 'sdasg', 1),
(69, 1, '2023-12-17 18:16:16', 'sdasg', 1),
(70, 1, '2023-12-17 18:16:57', 'sdasg', 1),
(71, 1, '2023-12-17 18:27:37', 'sdasg', 1),
(72, 1, '2023-12-17 18:30:42', 'sdasg', 1),
(73, 1, '2023-12-17 18:33:38', 'sdasg', 1),
(74, 1, '2023-12-17 18:34:44', 'sdasg', 1),
(75, 1, '2023-12-17 18:43:31', 'sdasg', 1),
(76, 1, '2023-12-17 19:07:11', 'sdasg', 1),
(77, 1, '2023-12-17 19:11:21', 'sdasg', 1),
(78, 1, '2023-12-17 20:20:39', 'sdasg', 1),
(79, 1, '2023-12-17 20:28:31', 'sdasg', 1),
(80, 1, '2023-12-17 20:30:26', 'sdasg', 1),
(81, 1, '2023-12-17 20:31:35', 'sdasg', 1),
(82, 1, '2023-12-17 20:31:59', 'sdasg', 1),
(83, 1, '2023-12-17 20:33:04', 'sdasg', 1),
(84, 1, '2023-12-17 20:33:49', 'sdasg', 1),
(85, 1, '2023-12-17 20:41:18', 'sdasg', 1),
(86, 1, '2023-12-17 20:41:41', 'sdasg', 1),
(87, 1, '2023-12-17 20:42:49', 'sdasg', 1),
(88, 1, '2023-12-17 21:05:51', 'sdasg', 1),
(89, 1, '2023-12-17 21:50:48', 'sdasg', 1),
(90, 1, '2023-12-17 21:51:35', 'sdasg', 1),
(91, 3, '2023-12-17 21:56:13', 'jgkuyolilo', 1),
(92, 1, '2023-12-17 22:03:09', 'sdasg', 1),
(96, 1, '2023-12-17 22:31:18', 'sdasg', 1),
(97, 1, '2023-12-17 22:52:56', '', 1),
(98, 1, '2023-12-17 23:26:43', 'sdasg', 1),
(99, 1, '2023-12-17 23:28:13', 'rrrr', 1),
(100, 4, '2023-12-17 23:30:07', 'ttttt', 1),
(101, 4, '2023-12-17 23:30:49', 'ttttt', 1),
(102, 5, '2023-12-17 23:32:04', 'sdasg', 1),
(103, 5, '2023-12-17 23:33:20', 'sdasg', 1),
(104, 5, '2023-12-17 23:34:04', 'sdasg', 1),
(105, 5, '2023-12-17 23:46:24', 'jgjhjpgyjmpgyo', 1),
(106, 5, '2023-12-17 23:49:03', 'jgjhjpgyjmpgyo', 1),
(107, 5, '2023-12-17 23:53:16', 'jgjhjpgyjmpgyo', 1),
(108, 5, '2023-12-17 23:53:52', 'jgjhjpgyjmpgyo', 1),
(109, 5, '2023-12-17 23:57:22', 'jgjhjpgyjmpgyo', 1),
(110, 5, '2023-12-18 00:03:21', 'jgjhjpgyjmpgyo', 1),
(111, 5, '2023-12-18 00:04:02', 'jgjhjpgyjmpgyo', 1),
(112, 2, '2023-12-18 00:22:20', 'sdasg', 1),
(113, 2, '2023-12-18 00:23:00', 'sdasg', 1),
(114, 2, '2023-12-18 00:23:34', 'sdasg', 1),
(115, 2, '2023-12-18 00:23:53', 'sdasg', 1),
(116, 2, '2023-12-18 00:24:20', 'sdasg', 1),
(117, 2, '2023-12-18 00:30:42', 'sdasg', 1),
(118, 2, '2023-12-18 00:31:27', 'sdasg', 1),
(119, 2, '2023-12-18 00:33:40', 'sdasg', 1),
(120, 1, '2023-12-18 00:34:05', 'fhdfh', 1),
(121, 1, '2023-12-18 00:35:13', 'fhdfh', 1),
(122, 1, '2023-12-18 00:35:17', 'fhdfh', 1),
(123, 2, '2023-12-18 00:35:41', 'sdasg', 1),
(125, 1, '2023-12-18 00:41:43', 'sdasg', 1),
(126, 1, '2023-12-18 00:42:45', 'fhdfh', 1),
(127, 1, '2023-12-18 00:46:13', 'fhdfh', 1),
(128, 1, '2023-12-18 00:47:26', 'sdasg', 1),
(129, 1, '2023-12-18 00:48:57', 'sdasg', 1),
(130, 1, '2023-12-18 00:49:36', 'sdasg', 1),
(131, 1, '2023-12-18 00:50:25', 'sdasg', 1),
(132, 1, '2023-12-18 00:51:23', 'sdasg', 1),
(133, 2, '2023-12-18 09:15:20', 'comidas para llevar', 1),
(134, 1, '2023-12-18 09:19:49', '', 1),
(135, 1, '2023-12-18 09:25:18', 'sdasg', 1),
(136, 1, '2023-12-18 09:26:05', '', 1),
(137, 1, '2023-12-18 09:38:28', '', 1),
(138, 1, '2023-12-18 09:42:23', '', 1),
(139, 1, '2023-12-18 09:45:13', '', 1),
(140, 1, '2023-12-18 09:46:31', '', 1),
(141, 1, '2023-12-18 09:46:49', '', 1),
(142, 5, '2023-12-18 22:29:35', 'sdasg', 1),
(143, 1, '2023-12-18 22:30:16', 'sdasg', 1),
(144, 2, '2023-12-21 00:29:46', 'jgkuyolilo', 1),
(145, 4, '2023-12-21 22:56:24', 'yyy', 1),
(146, 4, '2023-12-21 22:58:03', 'yyy', 1),
(147, 4, '2023-12-21 22:58:43', 'yyy', 1),
(148, 4, '2023-12-21 23:12:51', 'yyy', 1),
(149, 1, '2023-12-22 00:27:07', 'sdasg', 1),
(150, 5, '2023-12-22 00:27:50', 'sdasg', 1),
(151, 4, '2023-12-22 00:29:53', 'rrrrr', 1),
(152, 4, '2023-12-22 00:30:54', 'rrrrr', 1),
(153, 4, '2023-12-22 00:34:09', 'rrrrr', 1),
(154, 4, '2023-12-22 00:46:35', 'rrrrr', 1),
(155, 1, '2023-12-26 18:20:58', 'gag', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `precio` decimal(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombre`, `descripcion`, `precio`) VALUES
(1, 'producto1', 'Descripción del Producto 1', 19.99),
(2, 'producto2', 'Descripción del Producto 2', 29.99),
(3, 'producto3', 'Descripción del Producto 3', 39.99),
(4, 'producto4', 'Descripción del Producto 4', 44.99),
(5, 'producto5', 'Descripción del Producto 5', 2.50),
(6, 'producto6', 'Descripción del Producto 6', 23.50),
(7, 'producto7', 'Descripción del Producto 7', 10.00),
(8, 'producto8', 'Descripción del Producto 8', 15.25),
(9, 'producto9', 'Descripción del Producto 9', 2.00),
(10, 'producto10', 'Descripción del Producto 10', 3.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idProveedor` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cif` varchar(9) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idProveedor`, `nombre`, `cif`, `direccion`, `telefono`, `email`, `contacto`) VALUES
(1, 'Proveedor Fresco S.A.', 'A12345678', 'Calle de los Alimentos Frescos, 123', 2111234567, 'info@proveedorfresco.com', 'Juan Pérez'),
(2, 'Distribuciones Delicias Gourmet', 'B87654321', 'Avenida de las Delicias, 567', 2112345678, 'ventas@deliciasgourmet.com', 'María Rodríguez'),
(3, 'Suministros Culinarium', 'C56789012', 'Plaza de los Ingredientes, 89', 2113456789, 'pedidos@culinarium.es', 'Alberto Gómez'),
(4, 'Carnes y Sabores del Campo S.L.', 'D98765432', 'Carretera de las Carnes, 456', 2114567890, 'info@carnesySaborescampo.es', 'Laura Martínez'),
(5, 'Pescados del Mar Azul Ltda.', 'E23456789', 'Paseo de los Pescados, 101', 2115678901, 'ventas@pescadosazul.com', 'Antonio Fernández');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `idStock` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` decimal(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`idStock`, `fecha`, `id_producto`, `cantidad`) VALUES
(1, '2023-01-01 12:00:00', 1, 50.00),
(2, '2023-01-01 12:00:00', 2, 80.00),
(3, '2023-01-01 12:00:00', 3, 70.00),
(4, '2023-01-01 12:00:00', 4, 50.00),
(5, '2023-01-01 12:00:00', 5, 100.00),
(6, '2023-01-01 12:00:00', 6, 60.00),
(7, '2023-01-01 12:00:00', 7, 80.00),
(8, '2023-01-01 12:00:00', 8, 85.00),
(9, '2023-01-01 12:00:00', 9, 80.00),
(10, '2023-01-01 12:00:00', 10, 40.00),
(11, '2023-01-06 14:30:00', 2, 75.00),
(12, '2023-01-06 10:15:00', 3, 60.00),
(13, '2023-01-06 09:45:00', 4, 40.00),
(14, '2023-01-06 16:20:00', 5, 90.00),
(15, '2023-01-06 11:10:00', 6, 55.00),
(16, '2023-01-08 13:45:00', 7, 70.00),
(17, '2023-01-08 08:30:00', 8, 80.00),
(18, '2023-01-08 17:00:00', 9, 65.00),
(19, '2023-01-08 15:25:00', 10, 30.00),
(20, '2023-01-11 18:40:00', 1, 30.00),
(21, '2023-01-11 10:55:00', 2, 60.00),
(22, '2023-01-11 14:00:00', 3, 55.00),
(23, '2023-01-11 08:20:00', 4, 30.00),
(24, '2023-01-11 16:45:00', 5, 85.00),
(25, '2023-01-11 12:30:00', 6, 50.00),
(26, '2023-01-11 09:15:00', 7, 65.00),
(27, '2023-01-11 17:30:00', 8, 75.00),
(28, '2023-01-11 11:05:00', 9, 70.00),
(29, '2023-01-11 15:50:00', 10, 40.00),
(30, '2023-01-15 18:40:00', 1, 20.00),
(31, '2023-01-15 10:55:00', 2, 50.00),
(32, '2023-01-15 14:00:00', 3, 30.00),
(33, '2023-01-15 08:20:00', 4, 10.00),
(34, '2023-01-15 16:45:00', 5, 50.00),
(35, '2023-01-15 12:30:00', 6, 35.00),
(36, '2023-01-15 09:15:00', 7, 50.00),
(37, '2023-01-15 17:30:00', 8, 60.00),
(38, '2023-01-15 11:05:00', 9, 55.00),
(39, '2023-01-15 15:50:00', 10, 20.00),
(40, '2023-01-18 18:40:00', 1, 10.00),
(41, '2023-01-18 10:55:00', 2, 40.00),
(42, '2023-01-18 14:00:00', 3, 20.00),
(43, '2023-01-18 16:45:00', 5, 40.00),
(44, '2023-01-18 12:30:00', 6, 25.00),
(45, '2023-01-18 09:15:00', 7, 30.00),
(46, '2023-01-19 17:30:00', 8, 50.00),
(47, '2023-01-19 11:05:00', 9, 45.00),
(48, '2023-01-19 15:50:00', 10, 10.00),
(49, '2023-01-23 15:50:00', 10, 0.00),
(50, '2023-01-01 17:06:34', 1, 45.00),
(51, '2023-12-27 02:03:00', 1, 3.00),
(52, '2023-12-27 02:03:00', 2, 31.00),
(53, '2023-12-27 02:03:00', 3, 11.00),
(54, '2023-12-27 02:03:00', 4, 1.00),
(55, '2023-12-27 02:07:12', 1, 2.00),
(56, '2023-12-27 02:07:38', 1, 1.00),
(57, '2023-12-27 02:07:43', 1, 10.00),
(59, '2023-12-27 02:09:33', 2, 22.00),
(60, '2023-12-27 02:09:33', 3, 2.00),
(61, '2023-12-27 02:09:33', 4, 0.00),
(63, '2023-12-27 02:10:19', 2, 13.00),
(67, '2023-12-27 02:13:49', 2, 4.00),
(153, '2023-12-28 01:11:43', 9, 36.00),
(154, '2023-12-28 01:20:42', 6, 22.00),
(155, '2023-12-28 01:30:44', 5, 37.00),
(156, '2023-12-28 15:54:15', 1, 7.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `idTicket` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `idComanda` int(11) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `pagado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`idTicket`, `fecha`, `idComanda`, `importe`, `pagado`) VALUES
(1, '2023-01-02 00:00:00', 2, 252.42, 1),
(2, '2023-01-04 00:00:00', 4, 48.46, 1),
(3, '2023-01-06 00:00:00', 6, 42.50, 1),
(4, '2023-01-08 00:00:00', 8, 35.25, 0),
(5, '2023-01-10 00:00:00', 10, 85.50, 1),
(6, '2023-12-28 02:36:41', 1, 110.97, 0),
(7, '2023-12-28 02:37:18', 1, 110.97, 0),
(8, '2023-12-28 02:37:23', 1, 110.97, 0),
(9, '2023-12-28 02:37:44', 1, 110.97, 0),
(10, '2023-12-28 02:38:34', 1, 110.97, 0),
(11, '2023-12-28 02:39:23', 1, 110.97, 0),
(12, '2023-12-28 02:44:59', 1, 110.97, 0),
(13, '2023-12-28 16:16:30', 49, 40.98, 0),
(14, '2023-12-28 16:45:53', 48, 40.98, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`idComanda`),
  ADD KEY `comandas_mesa_idMesa_fk` (`idMesa`);

--
-- Indices de la tabla `lineascomandas`
--
ALTER TABLE `lineascomandas`
  ADD PRIMARY KEY (`idlinea`),
  ADD KEY `lineascomanda_comandas_idComanda_fk` (`idComanda`),
  ADD KEY `lineascomanda_productos_idProducto_fk` (`idProducto`);

--
-- Indices de la tabla `lineaspedidos`
--
ALTER TABLE `lineaspedidos`
  ADD PRIMARY KEY (`idlinea`),
  ADD KEY `lineasPedidos_pedidos_idPedidos_fk` (`idPedido`),
  ADD KEY `lineasPedidos_productos_idProducto_fk` (`idProducto`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`idMesa`),
  ADD UNIQUE KEY `mesa_pk2` (`nombre`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedidos`),
  ADD KEY `pedidos_proveedores_idProveedor_fk` (`idProveedor`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD UNIQUE KEY `nombre_unique` (`nombre`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProveedor`),
  ADD UNIQUE KEY `proveedores_pk2` (`nombre`),
  ADD UNIQUE KEY `proveedores_pk3` (`cif`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idStock`),
  ADD KEY `stock_producto__fk` (`id_producto`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`idTicket`),
  ADD KEY `tickets_comandas_idComanda_fk` (`idComanda`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comandas`
--
ALTER TABLE `comandas`
  MODIFY `idComanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `lineascomandas`
--
ALTER TABLE `lineascomandas`
  MODIFY `idlinea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `lineaspedidos`
--
ALTER TABLE `lineaspedidos`
  MODIFY `idlinea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedidos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `idStock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `idTicket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comandas`
--
ALTER TABLE `comandas`
  ADD CONSTRAINT `comandas_mesa_idMesa_fk` FOREIGN KEY (`idMesa`) REFERENCES `mesa` (`idMesa`);

--
-- Filtros para la tabla `lineascomandas`
--
ALTER TABLE `lineascomandas`
  ADD CONSTRAINT `lineascomanda_comandas_idComanda_fk` FOREIGN KEY (`idComanda`) REFERENCES `comandas` (`idComanda`),
  ADD CONSTRAINT `lineascomanda_productos_idProducto_fk` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `lineaspedidos`
--
ALTER TABLE `lineaspedidos`
  ADD CONSTRAINT `lineasPedidos_pedidos_idPedidos_fk` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedidos`),
  ADD CONSTRAINT `lineasPedidos_productos_idProducto_fk` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_proveedores_idProveedor_fk` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`);

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_producto__fk` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_comandas_idComanda_fk` FOREIGN KEY (`idComanda`) REFERENCES `comandas` (`idComanda`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
