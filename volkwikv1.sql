-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-12-2020 a las 07:16:42
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `volkwikv1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `IdCliente` int(11) UNSIGNED NOT NULL,
  `Dni` varchar(8) DEFAULT NULL,
  `User` varchar(50) NOT NULL,
  `Nombres` varchar(244) DEFAULT NULL,
  `Direccion` varchar(244) DEFAULT NULL,
  `Telefono` int(11) NOT NULL,
  `Correo` varchar(250) NOT NULL,
  `Compras` int(11) NOT NULL,
  `Foto` varchar(250) NOT NULL,
  `Estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`IdCliente`, `Dni`, `User`, `Nombres`, `Direccion`, `Telefono`, `Correo`, `Compras`, `Foto`, `Estado`) VALUES
(1, '76621871', 'PabloCliente2', 'Pablo Vega', 'Santiago de surco, mz. G lot.5', 980251512, 'pvegav@autonoma.edu.pe', 0, '1608245151_YO.JPG', 'Habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `IdDP` int(11) NOT NULL,
  `IdPedido` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Precio` float(10,2) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Descargado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Disparadores `detallepedido`
--
DELIMITER $$
CREATE TRIGGER `AumentarVentas` AFTER INSERT ON `detallepedido` FOR EACH ROW update producto set producto.Ventas = producto.Ventas +1
WHERE producto.IdProducto= NEW.IdProducto
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reducirStock` AFTER INSERT ON `detallepedido` FOR EACH ROW UPDATE producto set producto.Stock = producto.Stock - new.cantidad
WHERE IdProducto = new.IdProducto
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `IdEmpleado` int(10) UNSIGNED NOT NULL,
  `Dni` varchar(8) NOT NULL,
  `Nombres` varchar(255) DEFAULT NULL,
  `User` varchar(20) DEFAULT NULL,
  `Telefono` varchar(9) DEFAULT NULL,
  `Correo` varchar(250) NOT NULL,
  `Foto` varchar(250) NOT NULL,
  `Estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`IdEmpleado`, `Dni`, `Nombres`, `User`, `Telefono`, `Correo`, `Foto`, `Estado`) VALUES
(21, '76621871', 'Pablo Cesar Vega Valverde', 'PabloVeg', '980251512', 'pvegav@autonoma.edu.pe', '1608341555_YO.JPG', 'Habilitado'),
(22, '12345678', 'Juan Herrera', 'SuperAdmin', '980251512', 'jherrera@autonoma.edu.pe', '1608341565_MargaritaFamiliar.jpg', 'Habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `IdPedido` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `CostoDelivery` float(10,2) NOT NULL DEFAULT 0.00,
  `MontoTotal` float(10,2) DEFAULT NULL,
  `Estado` varchar(250) COLLATE utf8mb4_spanish2_ci NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Disparadores `pedido`
--
DELIMITER $$
CREATE TRIGGER `nuevacompra` AFTER INSERT ON `pedido` FOR EACH ROW UPDATE cliente SET cliente.Compras = cliente.Compras + 1 WHERE
IdCliente = new.IdCliente
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidosv`
--

CREATE TABLE `pedidosv` (
  `IdPedido` int(11) DEFAULT NULL,
  `Nombres` varchar(244) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `Direccion` varchar(244) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CostoDelivery` float(10,2) DEFAULT NULL,
  `MontoTotal` float(10,2) DEFAULT NULL,
  `Estado` varchar(250) COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `IdProducto` int(11) NOT NULL,
  `Nombres` varchar(244) DEFAULT NULL,
  `Precio` float(10,2) DEFAULT NULL,
  `Stock` int(11) UNSIGNED DEFAULT NULL,
  `Foto` varchar(250) NOT NULL DEFAULT 'default.jpg',
  `Categoria` varchar(25) NOT NULL,
  `PrecioP` float(10,2) NOT NULL,
  `EnPromo` varchar(5) NOT NULL,
  `Ventas` int(11) NOT NULL DEFAULT 0,
  `Estado` varchar(50) DEFAULT NULL,
  `PromoSema` varchar(250) NOT NULL DEFAULT 'No Semanal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`IdProducto`, `Nombres`, `Precio`, `Stock`, `Foto`, `Categoria`, `PrecioP`, `EnPromo`, `Ventas`, `Estado`, `PromoSema`) VALUES
(36, 'Mini Micrófono Karaoke Condensador Handheld Blue 3.5', 3.50, 17, '1608227340_MiniMicroCondenseKaraoke.jpg', 'Microfono', 2.00, 'No', 0, 'Habilitado', 'No Semanal'),
(37, 'Microfono De Cuello Lavalier For Samsung', 5.50, 14, '1608227486_H3eb61971473f47429be8529a2826dc43c.jpg', 'Microfono', 2.00, 'Si', 0, 'Habilitado', 'No Semanal'),
(38, 'SM-HT for iPhone Microfono inalambrico Lavalier', 18.00, 10, '1608229064_Haaf47fbd126a41e1b7adb7110dacb331W.jpg', 'Microfono', 15.00, 'No', 0, 'Habilitado', 'No Semanal'),
(39, 'audio microfono de 6m by m1/bym-1 mike for boya', 21.00, 20, '1608229473_Ha0db44812a8342b2bd2dd0fd192e92811.png', 'Microfono', 18.00, 'No', 0, 'Habilitado', 'No Semanal'),
(40, 'DS878 USB studio microfono karaoke', 15.00, 10, '1608229642_H659970af41d04f25ad41b304b138ad28v.jpg', 'Microfono', 12.00, 'No', 0, 'Habilitado', 'No Semanal'),
(41, 'GAM-140 Microfono Profesional Solapa ', 10.00, 10, '1608229811_H8bfb8f08cf2c40f8afff6d4218fce8a3H.jpg', 'Microfono', 8.00, 'No', 0, 'Habilitado', 'No Semanal'),
(42, ' Audifono Bluetooth 300 MAH Aprueba de agua', 20.00, 9, '1608230101_Ha1b817ad849f4bf2ac759ff7ebfc34d3w.jpg', 'Audifonos', 18.00, 'No', 0, 'Habilitado', 'No Semanal'),
(43, 'Auricular Bluetooth con control táctil deportivo con cancelación de ruido TWS ', 30.00, 20, '1608230327_H1d31b3a3718c4ce89fd7abb0a194a10fv.png', 'Audifonos', 27.00, 'No', 0, 'Habilitado', 'No Semanal'),
(44, 'Audifonos M11 TWS IPX7 2000mah', 20.00, 20, '1608230965_H8b29b6dc0022450b87088a27cea4e137z.jpg', 'Audifonos', 18.00, 'No', 0, 'Habilitado', 'No Semanal'),
(45, 'Auricular con pantalla digital IPX7 Impermeable Hifi 9D', 20.00, 20, '1608231351_H0dd7f8d77b364f77986da27e733f8925k.jpg', 'Audifonos', 18.00, 'No', 0, 'Habilitado', 'No Semanal'),
(46, 'Auricular Bluetooth táctil inteligente 2000mAh 9D', 30.00, 13, '1608231563_H32d119228e8745b994705a8723f57bc3m.jpg', 'Audifonos', 25.00, 'Si', 0, 'Habilitado', 'No Semanal'),
(47, 'CTYPEl F9 Auricular Bluetooth V5.0  TWS Impermeable IPX-5', 24.00, 20, '1608232048_He8acb0291fc54819b26f8b217e1b31b9G.jpg', 'Audifonos', 22.00, 'No', 0, 'Habilitado', 'No Semanal'),
(48, 'Reloj inteligente T500 Serie 5 Bluetooths', 24.00, 20, '1608232428_H06cae145aa794b6ca90f.jpg', 'Smart Watch', 22.00, 'No', 0, 'Habilitado', 'No Semanal'),
(49, ' Reloj Inteligente Android Smartwatch T500 cardíaca presión arteria / llamada', 45.00, 20, '1608232584_H0513ee74cd3d4131bcd493262c922931B.jpg', 'Smart Watch', 40.00, 'No', 0, 'Habilitado', 'No Semanal'),
(50, 'Reloj inteligente IWO 12 Monitor de ritmo cardíaco temperatura W26', 45.00, 20, '1608232669_Ha6e414c29dfb485cb409dc708510d132H.jpg', 'Smart Watch', 40.00, 'No', 0, 'Habilitado', 'No Semanal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `verpedidos`
--

CREATE TABLE `verpedidos` (
  `IdCliente` int(11) DEFAULT NULL,
  `Nombres` varchar(244) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Precio` float(10,2) DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Estado` varchar(250) COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IdCliente`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`IdDP`),
  ADD KEY `IdPedido` (`IdPedido`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`IdEmpleado`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`IdPedido`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IdCliente` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  MODIFY `IdDP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `IdEmpleado` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `IdPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `IdProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `fkp` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`IdPedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkpro` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
