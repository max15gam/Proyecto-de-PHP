-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.33 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para automotora
CREATE DATABASE IF NOT EXISTS `automotora` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `automotora`;

-- Volcando estructura para tabla automotora.alquileres
CREATE TABLE IF NOT EXISTS `alquileres` (
  `idAlquiler` int(8) NOT NULL AUTO_INCREMENT,
  `fechaInicio` date NOT NULL COMMENT 'Dia uno del alquiler del vehiculo',
  `fechaFin` date NOT NULL COMMENT 'Dia ultimo del alquiler del vehiculo',
  `estado` enum('activado','desactivado','borrado') DEFAULT NULL,
  `idCliente` int(8) NOT NULL,
  `idUsuario` int(4) NOT NULL,
  `idVehiculo` int(4) NOT NULL,
  `precioTotal` varchar(8) NOT NULL DEFAULT '',
  PRIMARY KEY (`idAlquiler`),
  KEY `clientes` (`idCliente`),
  KEY `usuarios` (`idUsuario`),
  KEY `vehiculos` (`idVehiculo`),
  CONSTRAINT `FK_alquilerCliente` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`),
  CONSTRAINT `FK_alquilerUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  CONSTRAINT `FK_alquilerVehiculo` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla automotora.alquileres: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `alquileres` DISABLE KEYS */;
INSERT INTO `alquileres` (`idAlquiler`, `fechaInicio`, `fechaFin`, `estado`, `idCliente`, `idUsuario`, `idVehiculo`, `precioTotal`) VALUES
	(1, '2022-04-02', '2022-04-04', 'activado', 1, 3, 1, '9000'),
	(2, '2022-04-05', '2022-04-10', 'activado', 2, 3, 9, '22500'),
	(3, '2022-04-12', '2022-04-15', 'activado', 3, 3, 3, '16500'),
	(4, '2022-04-27', '2022-04-29', 'activado', 4, 3, 15, '5000'),
	(5, '2022-04-05', '2022-04-15', 'activado', 5, 3, 18, '30000');
/*!40000 ALTER TABLE `alquileres` ENABLE KEYS */;

-- Volcando estructura para tabla automotora.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `idCliente` int(8) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL DEFAULT '',
  `mail` varchar(40) NOT NULL,
  `usuario` varchar(40) NOT NULL,
  `contrasenia` varchar(20) NOT NULL,
  `tipoDocumento` enum('cedula','credencial','pasaporte','otro') DEFAULT NULL,
  `documento` varchar(30) NOT NULL,
  `estado` enum('activado','desactivado','borrado') DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla automotora.clientes: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`idCliente`, `nombre`, `apellido`, `direccion`, `telefono`, `mail`, `usuario`, `contrasenia`, `tipoDocumento`, `documento`, `estado`, `codigo`) VALUES
	(1, 'alberto', 'gutierrez', 'pampa 6677', '239012900', 'albgu36@gmail.com', 'albgut8', 'mbd9010', 'cedula', '49001000', 'activado', NULL),
	(2, 'antonio', 'martinez', 'herrera 8090', '239049182', 'antonio10m@hotmail.com', 'tonio9', 'affai1940', 'credencial', 'brd9030', 'activado', NULL),
	(3, 'fernanda', 'campo', 'nievas 9310', '245623552', 'fefa902@hotmail.com', 'fefita44', '418afnaf', 'pasaporte', 'arm14914z', 'activado', NULL),
	(4, 'maria', 'lopez', 'lima 4190', '249141984', 'malopez41@hotmail.com', 'mari10', 'fan1148', 'otro', '41414aafafa', 'activado', NULL),
	(5, 'roberto', 'gonzalez', 'piro 1940', '241841848', 'robbie1490@hotmail.com', 'robbie5', 'migem411', 'cedula', '591041041', 'activado', NULL);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Volcando estructura para tabla automotora.correo
CREATE TABLE IF NOT EXISTS `correo` (
  `usuario` varchar(50) DEFAULT NULL,
  `asunto` varchar(255) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla automotora.correo: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `correo` DISABLE KEYS */;
INSERT INTO `correo` (`usuario`, `asunto`, `mensaje`) VALUES
	('albgut8', 'pregunta', 'Buenas tardes, cuál es su horario de atención?'),
	('albgut8', 'muy buena atención', 'Quisiera manifestar lo satisfecho que quedé con la atención recibida'),
	('fefita44', 'Agradecimiento', 'Quiero agradecerle nuevamente el que dispusiera parte de su tiempo para escuchar mis propuestas  actuales y ofrecerme sus consejos sobre la actualidad del mercado'),
	('robbie5', 'consulta', 'Buen dia, cuales serían los requisitos de alquiler? gracias');
/*!40000 ALTER TABLE `correo` ENABLE KEYS */;

-- Volcando estructura para tabla automotora.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `tipoUsuario` enum('administrador','encargado','vendedor') DEFAULT NULL,
  `usuario` varchar(40) NOT NULL,
  `contrasenia` varchar(20) NOT NULL,
  `estado` enum('activado','desactivado','borrado') DEFAULT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla automotora.usuarios: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`idUsuario`, `nombre`, `apellido`, `mail`, `tipoUsuario`, `usuario`, `contrasenia`, `estado`) VALUES
	(1, 'jorge', 'gonzalez', 'jorgon@hotmail.com', 'encargado', 'jorgon', 'afj18195', 'activado'),
	(2, 'roberto', 'pazos', 'robgut@hotmail.com', 'vendedor', 'robgut', 'afi91951', 'activado'),
	(3, 'mauricio', 'ramirez', 'automotoragambetta@gmail.com', 'administrador', 'admin', '123456', 'activado'),
	(4, 'leticia', 'fagundez', 'letfag90@hotmail.com', 'vendedor', 'letfagundez', 'afk8191', 'activado'),
	(5, 'ruben', 'perez', 'rubpery@hotmail.com', 'vendedor', 'ruben10', 'aaa999', 'activado');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla automotora.vehiculos
CREATE TABLE IF NOT EXISTS `vehiculos` (
  `idVehiculo` int(4) NOT NULL AUTO_INCREMENT,
  `tipoVehiculo` enum('automovil','tractor','autoelevador') DEFAULT NULL,
  `cantidadPasajeros` int(2) DEFAULT NULL,
  `marca` varchar(20) DEFAULT NULL,
  `modelo` varchar(20) DEFAULT NULL,
  `color` varchar(15) DEFAULT NULL,
  `matricula` varchar(10) DEFAULT NULL,
  `precio` float(7,2) DEFAULT NULL,
  `estado` enum('activado','desactivado','borrado') DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idVehiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla automotora.vehiculos: ~31 rows (aproximadamente)
/*!40000 ALTER TABLE `vehiculos` DISABLE KEYS */;
INSERT INTO `vehiculos` (`idVehiculo`, `tipoVehiculo`, `cantidadPasajeros`, `marca`, `modelo`, `color`, `matricula`, `precio`, `estado`, `imagen`) VALUES
	(1, 'automovil', 2, 'bmw', 'm240i', 'negro', 'aaa123', 4500.00, 'activado', '5.png'),
	(2, 'automovil', 2, 'bmw', 'm240i', 'azul', 'aaa234', 4500.00, 'activado', '6.jpg'),
	(3, 'automovil', 4, 'bmw', '320d', 'blanco', 'aaa345', 5500.00, 'activado', '3.jpg'),
	(4, 'automovil', 4, 'bmw', '320d', 'rojo', 'aaa456', 5500.00, 'activado', '4.jpg'),
	(5, 'automovil', 4, 'bmw', 'tourer', 'blanco', 'aaa567', 4500.00, 'activado', '1.jpg'),
	(6, 'automovil', 4, 'bmw', 'tourer', 'rojo', 'aaa678', 4500.00, 'activado', '2.png'),
	(7, 'automovil', 4, 'bmw', 'xdrive40i', 'rojo', 'aaa789', 6000.00, 'activado', '7.png'),
	(8, 'automovil', 4, 'bmw', 'xdrive40i', 'negro', 'aaa890', 6000.00, 'activado', '8.jpg'),
	(9, 'automovil', 4, 'ford', 'focus', 'azul', 'bbb123', 4500.00, 'activado', '9.jpg'),
	(10, 'automovil', 4, 'ford', 'focus', 'gris', 'bbb234', 4500.00, 'activado', '10.jpg'),
	(11, 'automovil', 4, 'ford', 'mustang', 'negro', 'bbb345', 7000.00, 'activado', '11.jpg'),
	(12, 'automovil', 4, 'ford', 'mustang', 'rojo', 'bbb456', 7000.00, 'activado', '12.jpg'),
	(13, 'automovil', 4, 'ford', 'ranger', 'negro', 'bbb567', 6500.00, 'activado', '13.jpeg'),
	(14, 'automovil', 4, 'ford', 'ranger', 'azul', 'bbb678', 6500.00, 'activado', '14.jpg'),
	(15, 'autoelevador', 1, 'mitsubishi', 'clasidia', 'naranja', 'bbb789', 2500.00, 'activado', '15.jpg'),
	(16, 'autoelevador', 1, 'mitsubishi', 'clasidia', 'verde', 'bbb890', 2500.00, 'activado', '16.jpg'),
	(17, 'autoelevador', 1, 'mitsubishi', 'clasidia', 'amarillo', 'ccc123', 2500.00, 'activado', '17.jpg'),
	(18, 'tractor', 1, 'newHolland', 't6', 'azul', 'ccc234', 3000.00, 'activado', '18.jpg'),
	(19, 'tractor', 1, 'newHolland', 't7', 'azul', 'ccc345', 3500.00, 'activado', '19.jpg'),
	(20, 'tractor', 1, 'newHolland', 't7', 'negro', 'ccc456', 3500.00, 'activado', '20.jpg'),
	(21, 'tractor', 1, 'newHolland', 't8', 'verde', 'ccc567', 4000.00, 'activado', '21.jpg'),
	(22, 'tractor', 1, 'newHolland', 't8', 'rojo', 'ccc678', 4000.00, 'activado', '22.png'),
	(23, 'automovil', 4, 'toyota', 'corolla', 'verde', 'ccc789', 3700.00, 'activado', '23.jpg'),
	(24, 'automovil', 4, 'toyota', 'corolla', 'blanco', 'ccc890', 3700.00, 'activado', '24.jpg'),
	(25, 'automovil', 4, 'toyota', 'raize', 'azul', 'ddd123', 4500.00, 'activado', '25.jpeg'),
	(26, 'automovil', 4, 'toyota', 'raize', 'rojo', 'ddd234', 4500.00, 'activado', '26.jpg'),
	(27, 'automovil', 4, 'toyota', 'raize', 'blanco', 'ddd345', 4500.00, 'activado', '27.png'),
	(28, 'automovil', 4, 'volkswagen', 'gol', 'rojo', 'ddd456', 2500.00, 'activado', '28.jpg'),
	(29, 'automovil', 4, 'volkswagen', 'gol', 'gris', 'ddd567', 2500.00, 'activado', '29.jpg'),
	(30, 'automovil', 4, 'volkswagen', 'saveiro', 'gris', 'ddd678', 3000.00, 'activado', '30.jpg'),
	(31, 'automovil', 4, 'volkswagen', 'saveiro', 'negro', 'ddd789', 3000.00, 'activado', '31.png');
/*!40000 ALTER TABLE `vehiculos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
