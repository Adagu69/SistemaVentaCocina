-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: sis_inventario
-- ------------------------------------------------------
-- Server version	9.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (17,'DESAYUNO','2025-04-24 21:48:30'),(18,'ALMUERZOS','2025-04-25 17:06:31');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `documento` int NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `documento` (`documento`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (9,'Admin',1,'010101','admin@gmail.com','989 011 256','Av Carlos Izaguirre','2021-05-27',26,'2025-04-24 16:56:46','2025-04-24 23:42:39'),(24,'Angel',78509632,'01','ang@gmail.com','989321456','Calle123','2001-04-25',1,'2025-04-25 18:37:03','2025-04-25 16:37:24'),(25,'Manuel',78542136,'020202','man@gmail.com','989 678 987','Calle123','2000-03-07',1,'2025-04-25 12:10:56','2025-04-25 17:10:56');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contratos`
--

DROP TABLE IF EXISTS `contratos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contratos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_nombre` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `id_documento` int NOT NULL,
  `id_correo` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `id_telefono` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `id_direccion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `id_fechaRegistro` date NOT NULL,
  `id_compras` int NOT NULL,
  `id_ultima_compra` datetime NOT NULL,
  `tipoDeEvento` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `numeroDeBanquetes` int NOT NULL,
  `selBanquete` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `comentario` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fechaDelEvento` date NOT NULL,
  `id_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contratos`
--

LOCK TABLES `contratos` WRITE;
/*!40000 ALTER TABLE `contratos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contratos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_categoria` int NOT NULL,
  `codigo` varchar(20) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `imagen` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `stock` int NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  KEY `codigo` (`codigo`),
  KEY `descripcion` (`descripcion`(30))
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (97,17,'01','PAN CON POLLO','vistas/img/productos/default/anonymous.png',6,5,6,0,'2025-04-25 17:07:19'),(98,18,'02','ESTOFADO','vistas/img/productos/default/anonymous.png',22,10,15,2,'2025-04-25 17:10:56');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suscripcion`
--

DROP TABLE IF EXISTS `suscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suscripcion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombreSuscriptor` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `correoSuscriptor` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fechaSuscripcion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suscripcion`
--

LOCK TABLES `suscripcion` WRITE;
/*!40000 ALTER TABLE `suscripcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `suscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `perfil` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `estado` int NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `perfil` (`perfil`),
  KEY `estado` (`estado`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Administrador','admin','$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG','Administrador','vistas/img/usuarios/admin/813.jpg',1,'2025-04-26 11:11:44','2025-04-26 16:11:44'),(74,'Maximiliana','Maxi','$2a$07$asxx54ahjppf45sd87a5aub7LdtrTXnn.ZQdALsthndsluPeTbv.a','Cliente','vistas/img/usuarios/Maxi/717.jpg',1,'2025-04-25 12:03:40','2025-04-25 17:03:40'),(75,'Eufemia','Eufe','$2a$07$asxx54ahjppf45sd87a5aub7LdtrTXnn.ZQdALsthndsluPeTbv.a','Especial','',1,'2025-04-25 00:16:07','2025-04-25 17:05:54'),(76,'Carlos','Car','$2a$07$asxx54ahjppf45sd87a5auwFCZXp9RiVrmkyXovVFBGjMg1nIb6Sa','Vendedor','',1,'2025-04-25 11:35:47','2025-04-25 17:05:26');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_vendedor` int NOT NULL,
  `productos` longtext COLLATE utf8mb3_spanish_ci NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `neto` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `monto_pago` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `codigo` (`codigo`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_vendedor` (`id_vendedor`),
  KEY `fecha` (`fecha`),
  KEY `metodo_pago` (`metodo_pago`),
  KEY `total` (`total`),
  KEY `monto_pago` (`monto_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (79,1745531609,9,0,'[{\"id\":97,\"descripcion\":\"PAN CON POLLO\",\"cantidad\":2,\"precio\":6,\"total\":12,\"stock\":3}]',0.00,12.00,12.00,'Efectivo','2025-04-24 21:53:29',20.00),(80,1745531610,9,1,'[{\"id\":\"98\",\"descripcion\":\"ESTOFADO\",\"cantidad\":\"1\",\"stock\":\"24\",\"precio\":\"15\",\"total\":\"15\"}]',0.00,15.00,15.00,'Efectivo','2025-04-24 21:56:46',0.00),(81,1745538159,9,0,'[{\"id\":97,\"descripcion\":\"PAN CON POLLO\",\"cantidad\":2,\"precio\":6,\"total\":12,\"stock\":1}]',0.00,12.00,12.00,'Efectivo','2025-04-24 23:42:39',20.00),(82,1745599044,24,0,'[{\"id\":98,\"descripcion\":\"ESTOFADO\",\"cantidad\":1,\"precio\":15,\"total\":15,\"stock\":23}]',0.00,15.00,15.00,'Yape','2025-04-25 16:37:24',0.00),(83,1745599045,25,1,'[{\"id\":\"98\",\"descripcion\":\"ESTOFADO\",\"cantidad\":\"1\",\"stock\":\"22\",\"precio\":\"15\",\"total\":\"15\"}]',0.00,15.00,15.00,'Efectivo','2025-04-25 17:10:56',0.00);
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas_historial`
--

DROP TABLE IF EXISTS `ventas_historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas_historial` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_vendedor` int NOT NULL,
  `productos` longtext COLLATE utf8mb3_spanish_ci NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `neto` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `monto_pago` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `codigo` (`codigo`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_vendedor` (`id_vendedor`),
  KEY `fecha` (`fecha`),
  KEY `metodo_pago` (`metodo_pago`),
  KEY `total` (`total`),
  KEY `monto_pago` (`monto_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas_historial`
--

LOCK TABLES `ventas_historial` WRITE;
/*!40000 ALTER TABLE `ventas_historial` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas_historial` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-26 12:13:20
