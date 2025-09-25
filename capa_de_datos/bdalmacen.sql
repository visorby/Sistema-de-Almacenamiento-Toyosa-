-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2025 a las 03:31:08
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdalmacen`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle` varchar(20) NOT NULL,
  `id_factura` varchar(20) DEFAULT NULL,
  `id_lote` varchar(20) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id_detalle`, `id_factura`, `id_lote`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
('DET001', 'FAC001', 'LOT001', 10, '50.00', '500.00'),
('DET002', 'FAC001', 'LOT002', 5, '80.00', '400.00'),
('DET003', 'FAC002', 'LOT003', 20, '25.00', '500.00'),
('DET004', 'FAC003', 'LOT001', 15, '50.00', '750.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_proveedor`
--

CREATE TABLE `factura_proveedor` (
  `id_factura` varchar(10) NOT NULL,
  `id_proveedor` varchar(10) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Tipo` enum('Minorista','Mayorista') DEFAULT NULL,
  `MontoTotal` decimal(10,2) DEFAULT NULL,
  `Estado` enum('Emitida','Pagada','Anulada') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `factura_proveedor`
--

INSERT INTO `factura_proveedor` (`id_factura`, `id_proveedor`, `Fecha`, `Tipo`, `MontoTotal`, `Estado`) VALUES
('FAC001', 'PRV001', '2025-09-15', 'Mayorista', '150000.00', 'Pagada'),
('FAC002', 'PRV002', '2025-09-18', 'Minorista', '3500.50', 'Emitida'),
('FAC003', 'PRV003', '2025-09-20', 'Mayorista', '12000.75', 'Emitida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `industrias`
--

CREATE TABLE `industrias` (
  `id_industria` varchar(20) NOT NULL,
  `industria` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `industrias`
--

INSERT INTO `industrias` (`id_industria`, `industria`, `descripcion`) VALUES
('IND001', 'Automotriz', 'Vehículos y repuestos de automóviles'),
('IND002', 'Lubricantes', 'Aceites, filtros y aditivos'),
('IND003', 'Neumáticos', 'Llantas y cámaras para autos y camiones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id_item` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `industria` varchar(50) DEFAULT NULL,
  `stock_Actual` int(11) DEFAULT NULL,
  `stock_Minimo` int(11) DEFAULT NULL,
  `id_proveedor` varchar(10) DEFAULT NULL,
  `id_industria` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id_item`, `nombre`, `categoria`, `industria`, `stock_Actual`, `stock_Minimo`, `id_proveedor`, `id_industria`) VALUES
('ITM001', 'Filtro de aceite Corolla', 'Repuesto', 'Lubricantes', 120, 30, 'PRV002', 'IND002'),
('ITM002', 'Neumático Michelin 195/65R15', 'Llanta', 'Neumáticos', 50, 10, 'PRV003', 'IND003'),
('ITM003', 'Toyota Hilux 2025 4x4', 'Vehículo', 'Automotriz', 5, 1, 'PRV001', 'IND001'),
('ITM004', 'Aceite 10W40 sintético', 'Lubricante', 'Lubricantes', 300, 50, 'PRV002', 'IND002');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `id_lote` varchar(10) NOT NULL,
  `id_factura` varchar(10) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tipo` enum('Minorista','Mayorista') DEFAULT NULL,
  `id_proveedor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lotes`
--

INSERT INTO `lotes` (`id_lote`, `id_factura`, `cantidad`, `tipo`, `id_proveedor`) VALUES
('LOT001', 'FAC001', 3, 'Mayorista', 'PRV001'),
('LOT002', 'FAC002', 100, 'Minorista', 'PRV002'),
('LOT003', 'FAC003', 50, 'Mayorista', 'PRV003');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` varchar(10) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `nombre_empresa` varchar(100) NOT NULL,
  `representante_legal` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `tipo` enum('Minorista','Mayorista') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `razon_social`, `nombre_empresa`, `representante_legal`, `telefono`, `correo`, `tipo`) VALUES
('PRV001', 'Toyota Motor Corp.', 'Toyota Japan', 'Hiroshi Tanaka', '+81 45 123 4567', 'ventas@toyota.jp', 'Mayorista'),
('PRV002', 'LubriMax Bolivia', 'Lubricantes y Filtros S.A.', 'Carlos Quispe', '72012345', 'contacto@lubrimax.com.bo', 'Minorista'),
('PRV003', 'Michelin Andes', 'Neumáticos Michelin Bolivia', 'María Fernández', '76543210', 'ventas@michelin.bo', 'Mayorista'),
('PRV004', 'Motores ', 'Motores y Mas S.A', 'Jorge Sanchez', '76439922', 'jmotores@gmail.com', 'Mayorista'),
('PRV005', 'repuestos', 'Transportes rapidos S.A.', 'Roberto Mendoza', '7896543', 'robertom@gmail.com', 'Mayorista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor_industria`
--

CREATE TABLE `proveedor_industria` (
  `id_proveedor` varchar(20) NOT NULL,
  `id_industria` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor_industria`
--

INSERT INTO `proveedor_industria` (`id_proveedor`, `id_industria`) VALUES
('PRV001', 'IND001'),
('PRV002', 'IND002'),
('PRV003', 'IND003');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restock`
--

CREATE TABLE `restock` (
  `id_restock` varchar(10) NOT NULL,
  `id_item` varchar(10) DEFAULT NULL,
  `id_proveedor` varchar(10) DEFAULT NULL,
  `cantidad_solicitada` int(11) DEFAULT NULL,
  `fecha_solicitud` date DEFAULT NULL,
  `estado` enum('Pendiente','Procesado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `restock`
--

INSERT INTO `restock` (`id_restock`, `id_item`, `id_proveedor`, `cantidad_solicitada`, `fecha_solicitud`, `estado`) VALUES
('RST001', 'ITM002', 'PRV003', 20, '2025-09-21', 'Pendiente'),
('RST002', 'ITM004', 'PRV002', 100, '2025-09-22', 'Procesado'),
('RST003', 'ITM003', 'PRV001', 2, '2025-09-23', 'Pendiente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_lote` (`id_lote`);

--
-- Indices de la tabla `factura_proveedor`
--
ALTER TABLE `factura_proveedor`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `industrias`
--
ALTER TABLE `industrias`
  ADD PRIMARY KEY (`id_industria`),
  ADD UNIQUE KEY `nombre_industria` (`industria`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `fk_items_industria` (`id_industria`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id_lote`),
  ADD KEY `id_factura` (`id_factura`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `proveedor_industria`
--
ALTER TABLE `proveedor_industria`
  ADD PRIMARY KEY (`id_proveedor`,`id_industria`),
  ADD KEY `id_industria` (`id_industria`);

--
-- Indices de la tabla `restock`
--
ALTER TABLE `restock`
  ADD PRIMARY KEY (`id_restock`),
  ADD KEY `id_item` (`id_item`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura_proveedor` (`id_factura`),
  ADD CONSTRAINT `detalle_factura_ibfk_2` FOREIGN KEY (`id_lote`) REFERENCES `lotes` (`id_lote`);

--
-- Filtros para la tabla `factura_proveedor`
--
ALTER TABLE `factura_proveedor`
  ADD CONSTRAINT `factura_proveedor_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_industria` FOREIGN KEY (`id_industria`) REFERENCES `industrias` (`id_industria`),
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `lotes_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura_proveedor` (`id_factura`);

--
-- Filtros para la tabla `proveedor_industria`
--
ALTER TABLE `proveedor_industria`
  ADD CONSTRAINT `proveedor_industria_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE,
  ADD CONSTRAINT `proveedor_industria_ibfk_2` FOREIGN KEY (`id_industria`) REFERENCES `industrias` (`id_industria`) ON DELETE CASCADE;

--
-- Filtros para la tabla `restock`
--
ALTER TABLE `restock`
  ADD CONSTRAINT `restock_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `items` (`id_item`),
  ADD CONSTRAINT `restock_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
