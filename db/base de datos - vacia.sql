-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.11-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para ventas
CREATE DATABASE IF NOT EXISTS `ventas` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ventas`;

-- Volcando estructura para tabla ventas.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `precio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.configuracion: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` (`id`, `precio`) VALUES
	(1, 75000.00);
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;

-- Volcando estructura para tabla ventas.embalaje
CREATE TABLE IF NOT EXISTS `embalaje` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.embalaje: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `embalaje` DISABLE KEYS */;
/*!40000 ALTER TABLE `embalaje` ENABLE KEYS */;

-- Volcando estructura para tabla ventas.entradas
CREATE TABLE IF NOT EXISTS `entradas` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(255) DEFAULT NULL,
  `grupo` text DEFAULT NULL,
  `codigo` text DEFAULT NULL,
  `nombre` text DEFAULT NULL,
  `tipo` text DEFAULT NULL,
  `cantidad` int(255) DEFAULT NULL,
  `estante` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `nota` text DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.entradas: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `entradas` DISABLE KEYS */;
/*!40000 ALTER TABLE `entradas` ENABLE KEYS */;

-- Volcando estructura para tabla ventas.existencias
CREATE TABLE IF NOT EXISTS `existencias` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_insumos` int(255) DEFAULT NULL,
  `cantidad` int(255) DEFAULT NULL,
  `estante` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.existencias: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `existencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `existencias` ENABLE KEYS */;

-- Volcando estructura para tabla ventas.insumos
CREATE TABLE IF NOT EXISTS `insumos` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `codigo` text DEFAULT NULL,
  `nombre` text DEFAULT NULL,
  `tipo` int(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.insumos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `insumos` DISABLE KEYS */;
/*!40000 ALTER TABLE `insumos` ENABLE KEYS */;

-- Volcando estructura para tabla ventas.presentacion
CREATE TABLE IF NOT EXISTS `presentacion` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.presentacion: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `presentacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `presentacion` ENABLE KEYS */;

-- Volcando estructura para tabla ventas.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `codigo` text DEFAULT NULL,
  `nombre` text DEFAULT NULL,
  `presentacion` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `limite` int(255) DEFAULT NULL,
  `cantidad` int(255) DEFAULT NULL,
  `precio` double(10,3) DEFAULT NULL,
  `precio_soloenBS` int(1) DEFAULT 0,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.productos: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Volcando estructura para tabla ventas.salidas
CREATE TABLE IF NOT EXISTS `salidas` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(255) DEFAULT NULL,
  `grupo` text DEFAULT NULL,
  `codigo` text DEFAULT NULL,
  `nombre` text DEFAULT NULL,
  `tipo` text DEFAULT NULL,
  `cantidad` int(255) DEFAULT NULL,
  `estante` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `nota` text DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.salidas: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `salidas` DISABLE KEYS */;
/*!40000 ALTER TABLE `salidas` ENABLE KEYS */;

-- Volcando estructura para tabla ventas.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` text DEFAULT NULL,
  `nacionalidad` text DEFAULT NULL,
  `cedula` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `telefono` text DEFAULT NULL,
  `rol` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `clave` text DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.usuarios: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `nombre`, `nacionalidad`, `cedula`, `email`, `telefono`, `rol`, `direccion`, `clave`, `fecha`) VALUES
	(1, 'Administrador General', NULL, NULL, 'admin@admin.com', NULL, '1', NULL, 'YWRtaW4=', '2020-01-18 23:41:18'),
	(4, 'Empleado General', NULL, NULL, 'empleado@empleado.com', NULL, '2', NULL, 'ZW1wbGVhZG8=', '2020-01-19 10:43:37');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla ventas.ventas
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(255) DEFAULT NULL,
  `id_producto` int(255) DEFAULT NULL,
  `grupo` text DEFAULT NULL,
  `codigo` text DEFAULT NULL,
  `nombre` text DEFAULT NULL,
  `presentacion` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `cantidad` text DEFAULT NULL,
  `nota` text DEFAULT NULL,
  `precio` double(10,2) DEFAULT NULL,
  `estado` text DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ventas.ventas: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
