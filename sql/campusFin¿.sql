-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.19-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnos` (
  `id_alumnos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contrasena` varchar(50) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `nacimiento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `cp` int(5) NOT NULL,
  `cuentaBancaria` varchar(24) NOT NULL,
  `curso` float NOT NULL,
  `grado` varchar(20) NOT NULL,
  `telefono` int(9) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id_alumnos`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (38,'dd71281a3e201b5f69dabe3bfa19a514','Lucas','Elvira Martin','1996-12-19','M','51703391N','gnei','nfgpwi','bpwe',28760,'',1.1,'moda',630204348,'lucaselvira96@gmail.com'),(39,'7a6ac96e728116d57e1da1e1ff61af91','pedro','ruiz','1111-11-11','M','45682793D','calle','madrid','madrid',11111,'',1.1,'grafico',915468291,'prueba.alumno.campus@hotmail.com'),(42,'682c2d8a30e299071799352985d01308','Raq','Mar','1996-12-19','F','51703391N','ghet','bfgp3w','bfpw',28760,'',1.1,'grafico',666666666,'raq.marribas@gmail.com'),(43,'a3d111f6ee1ccff987bfdb56d172d242','Cesar ','Elvira Barrueco','1960-04-08','M','50300448T','Av. ViÃ±uelas','Madrid','Tres Cantos',28760,'',1.1,'grafico',601111111,'celvira@minsait.com'),(44,'e2867c7ed4c98fd6a9465d13b61ba6fc','bfgeilr','bpw','1996-12-19','M','51703391N','gmerop','fmwep','fgerp',28760,'',0,'grafico',630204348,'foo@gmail.com'),(49,'ae1a03c6b4ca0152ce4f2ddd4f3bcbaf','bfgeilr','bpw','1996-12-19','M','51703391N','gmerop','fmwep','fgerp',28760,'',0,'grafico',630204348,'l@e.es');
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asignaturas` (
  `id_asignaturas` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_profesores` int(10) unsigned DEFAULT NULL,
  `nombre` varchar(40) NOT NULL,
  `curso` float NOT NULL,
  `grado` varchar(100) NOT NULL,
  `creditos` int(2) NOT NULL,
  `uri_guia_docente` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_asignaturas`),
  KEY `id_profesores` (`id_profesores`),
  CONSTRAINT `asignaturas_ibfk_1` FOREIGN KEY (`id_profesores`) REFERENCES `profesores` (`id_profesores`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignaturas`
--

LOCK TABLES `asignaturas` WRITE;
/*!40000 ALTER TABLE `asignaturas` DISABLE KEYS */;
INSERT INTO `asignaturas` VALUES (1,6,'creatividad',1.1,'grafico',0,'guia_creatividad.pdf'),(2,6,'video',1.1,'grafico',0,'guia_video.pdf'),(3,6,'photoshop',1.1,'grafico',0,'guia_photoshop.pdf'),(4,6,'creatividad',1.2,'grafico',0,'guia_creatividad.pdf'),(5,6,'video',1.2,'grafico',0,'guia_video.pdf'),(6,6,'photoshop',1.2,'grafico',0,'guia_photoshop.pdf'),(7,3,'color',2.1,'grafico',0,'guia_color.pdf'),(8,5,'dibujo',2.1,'grafico',0,'guia_dibujo.pdf'),(9,3,'packaging',2.1,'grafico',0,'guia_packaging.pdf'),(10,3,'color',2.2,'grafico',0,'guia_color.pdf'),(11,5,'dibujo',2.2,'grafico',0,'guia_dibujo.pdf'),(12,3,'packaging',2.2,'grafico',0,'guia_packaging.pdf'),(13,5,'editorial',3.1,'grafico',0,'guia_editorial.pdf'),(14,NULL,'comic',3.1,'grafico',0,'guia_comic.pdf'),(15,NULL,'historia_arte',3.1,'grafico',0,'guia_historia arte.pdf'),(16,5,'editorial',3.2,'grafico',0,'guia_editorial.pdf'),(17,NULL,'comic',3.2,'grafico',0,'guia_comic.pdf'),(18,NULL,'historia_arte',3.2,'grafico',0,'guia_historia arte.pdf'),(19,3,'publicidad',4.1,'grafico',0,'guia_publicidad.pdf'),(20,3,'legislacion',4.1,'grafico',0,'guia_legislacion.pdf'),(21,3,'dibujo_tecnico',4.1,'grafico',0,'guia_dibujo tecnico.pdf'),(22,3,'publicidad',4.2,'grafico',0,'guia_publicidad.pdf'),(23,3,'legislacion',4.2,'grafico',0,'guia_legislacion.pdf'),(24,3,'dibujo_tecnico',4.2,'grafico',0,'guia_dibujo tecnico.pdf'),(25,NULL,'programacion',1.1,'videojuegos',0,'guia_programacion.pdf'),(26,NULL,'unity',1.1,'videojuegos',0,'guia_unity.pdf'),(27,NULL,'animacion',1.1,'videojuegos',0,'guia_animacion.pdf'),(28,NULL,'programacion',1.2,'videojuegos',0,'guia_programacion.pdf'),(29,NULL,'unity',1.2,'videojuegos',0,'guia_unity.pdf'),(30,NULL,'animacion',1.2,'videojuegos',0,'guia_animacion.pdf'),(31,NULL,'modelado',2.1,'videojuegos',0,'guia_modelado.pdf'),(32,NULL,'infografia',2.1,'videojuegos',0,'guia_infografia.pdf'),(33,NULL,'cinema',2.1,'videojuegos',0,'guia_cinema.pdf'),(34,NULL,'modelado',2.2,'videojuegos',0,'guia_modelado.pdf'),(35,NULL,'infografia',2.2,'videojuegos',0,'guia_infografia.pdf'),(36,NULL,'cinema',2.2,'videojuegos',0,'guia_cinema.pdf'),(37,NULL,'programacion_avanzada',3.1,'videojuegos',0,'guia_programacion avanzada.pdf'),(38,NULL,'personajes',3.1,'videojuegos',0,'guia_personajes.pdf'),(39,NULL,'ilustracion',3.1,'videojuegos',0,'guia_ilustracion.pdf'),(40,NULL,'programacion_avanzada',3.2,'videojuegos',0,'guia_programacion avanzada.pdf'),(41,NULL,'personajes',3.2,'videojuegos',0,'guia_personajes.pdf'),(42,NULL,'ilustracion',3.2,'videojuegos',0,'guia_ilustracion.pdf'),(43,NULL,'guion',4.1,'videojuegos',0,'guia_guion.pdf'),(44,NULL,'prototipo',4.1,'videojuegos',0,'guia_prototipo.pdf'),(45,NULL,'desarrollo',4.1,'videojuegos',0,'guia_desarrollo.pdf'),(46,NULL,'guion',4.2,'videojuegos',0,'guia_guion.pdf'),(47,NULL,'prototipo',4.2,'videojuegos',0,'guia_prototipo.pdf'),(48,NULL,'desarrollo',4.2,'videojuegos',0,'guia_desarrollo.pdf'),(49,5,'patronaje',1.1,'moda',0,'guia_patronaje.pdf'),(50,NULL,'medidas',1.1,'moda',0,'guia_medidas.pdf'),(51,5,'historia_moda',1.1,'moda',0,'guia_historia moda.pdf'),(52,5,'patronaje',1.2,'moda',0,'guia_patronaje.pdf'),(53,NULL,'medidas',1.2,'moda',0,'guia_medidas.pdf'),(54,5,'historia_moda',1.2,'moda',0,'guia_historia moda.pdf'),(55,NULL,'fotografia',2.1,'moda',0,'guia_fotografia.pdf'),(56,NULL,'zapatos',2.1,'moda',0,'guia_zapatos.pdf'),(57,NULL,'pantalones',2.1,'moda',0,'guia_pantalones.pdf'),(58,NULL,'fotografia',2.2,'moda',0,'guia_fotografia.pdf'),(59,NULL,'zapatos',2.2,'moda',0,'guia_zapatos.pdf'),(60,NULL,'pantalones',2.2,'moda',0,'guia_pantalones.pdf'),(61,NULL,'tendencia',3.1,'moda',0,'guia_tendencia.pdf'),(62,NULL,'pasarela',3.1,'moda',0,'guia_pasarela.pdf'),(63,NULL,'sombreros',3.1,'moda',0,'guia_sombreros.pdf'),(64,NULL,'tendencia',3.2,'moda',0,'guia_tendencia.pdf'),(65,NULL,'pasarela',3.2,'moda',0,'guia_pasarela.pdf'),(66,NULL,'sombreros',3.2,'moda',0,'guia_sombreros.pdf'),(67,NULL,'textiles',4.1,'moda',0,'guia_textiles.pdf'),(68,NULL,'estampados',4.1,'moda',0,'guia_estampados.pdf'),(69,NULL,'complementos',4.1,'moda',0,'guia_complementos.pdf'),(70,NULL,'textiles',4.2,'moda',0,'guia_textiles.pdf'),(71,NULL,'estampados',4.2,'moda',0,'guia_estampados.pdf'),(72,NULL,'complementos',4.2,'moda',0,'guia_complementos.pdf');
/*!40000 ALTER TABLE `asignaturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matriculaciones`
--

DROP TABLE IF EXISTS `matriculaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matriculaciones` (
  `id_matriculaciones` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_alumnos` int(10) unsigned DEFAULT NULL,
  `id_asignaturas` int(10) unsigned DEFAULT NULL,
  `asistencia` int(11) DEFAULT NULL,
  `nota_final` float DEFAULT NULL,
  PRIMARY KEY (`id_matriculaciones`),
  KEY `id_alumnos` (`id_alumnos`),
  KEY `id_asignaturas` (`id_asignaturas`),
  CONSTRAINT `matriculaciones_ibfk_1` FOREIGN KEY (`id_alumnos`) REFERENCES `alumnos` (`id_alumnos`),
  CONSTRAINT `matriculaciones_ibfk_2` FOREIGN KEY (`id_asignaturas`) REFERENCES `asignaturas` (`id_asignaturas`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matriculaciones`
--

LOCK TABLES `matriculaciones` WRITE;
/*!40000 ALTER TABLE `matriculaciones` DISABLE KEYS */;
INSERT INTO `matriculaciones` VALUES (1,1,3,96,NULL),(2,2,3,96,NULL),(3,2,4,96,NULL),(4,24,3,96,NULL),(5,24,1,96,NULL),(6,2,2,96,NULL),(7,2,1,96,NULL),(8,2,3,96,NULL),(9,34,1,96,NULL),(10,34,2,96,NULL),(11,34,3,96,NULL),(12,34,1,96,NULL),(13,34,2,96,NULL),(14,34,3,96,NULL),(15,35,1,96,NULL),(16,35,2,96,NULL),(17,35,3,96,NULL),(18,36,1,96,NULL),(19,36,7,96,NULL),(20,36,8,96,NULL),(21,37,1,96,NULL),(22,37,2,96,NULL),(23,37,3,96,NULL),(24,38,51,96,NULL),(25,38,49,96,NULL),(26,38,50,96,NULL),(27,39,3,NULL,NULL),(28,39,1,NULL,NULL),(29,39,2,NULL,NULL),(30,42,3,NULL,NULL),(31,42,1,NULL,NULL),(32,42,2,NULL,NULL),(33,43,1,NULL,NULL),(34,43,2,NULL,NULL),(35,43,3,NULL,NULL);
/*!40000 ALTER TABLE `matriculaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notas`
--

DROP TABLE IF EXISTS `notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notas` (
  `id_notas` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_matriculaciones` int(10) unsigned DEFAULT NULL,
  `nota` float NOT NULL,
  `uri` varchar(40) NOT NULL,
  `porcentaje` float DEFAULT NULL,
  `file_pr` varchar(100) DEFAULT NULL,
  `file_al` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_notas`),
  KEY `id_matriculaciones` (`id_matriculaciones`),
  CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`id_matriculaciones`) REFERENCES `matriculaciones` (`id_matriculaciones`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notas`
--

LOCK TABLES `notas` WRITE;
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
/*!40000 ALTER TABLE `notas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificaciones` (
  `id_notificaciones` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_profesores` int(10) unsigned DEFAULT NULL,
  `id_staff` int(10) unsigned DEFAULT NULL,
  `id_destinatario` int(10) unsigned DEFAULT NULL,
  `id_asignaturas` varchar(500) DEFAULT NULL,
  `mensaje` varchar(9000) DEFAULT NULL,
  PRIMARY KEY (`id_notificaciones`),
  KEY `id_remitente_pr` (`id_profesores`),
  KEY `id_remitente_st` (`id_staff`),
  KEY `id_destinatario` (`id_destinatario`),
  CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_profesores`) REFERENCES `profesores` (`id_profesores`),
  CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`id_staff`) REFERENCES `staff` (`id_staff`),
  CONSTRAINT `notificaciones_ibfk_3` FOREIGN KEY (`id_destinatario`) REFERENCES `alumnos` (`id_alumnos`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,1,NULL,NULL,'','hola mundo'),(2,1,NULL,NULL,'','hola mundo'),(3,1,NULL,NULL,'','hola mundo'),(4,1,NULL,NULL,'','hola mundo'),(5,1,NULL,NULL,'1_2_3_4_5_6_25_26_27_49_50_51','hola mundo'),(6,1,NULL,NULL,'','hola caracola'),(7,1,NULL,NULL,'','hola caracola'),(8,1,NULL,NULL,'','hola caracola'),(9,1,NULL,NULL,'','hola caracola'),(10,1,NULL,NULL,'','hola caracola'),(11,1,NULL,NULL,'','hola caracola'),(12,1,NULL,NULL,'','hola caracola'),(13,1,NULL,NULL,'','hola caracola'),(14,1,NULL,NULL,'','hola caracola'),(15,1,NULL,NULL,'','hola caracola'),(16,1,NULL,NULL,'','hola caracola'),(17,1,NULL,NULL,'','hola hola'),(18,1,NULL,NULL,'','hola hola'),(19,1,NULL,NULL,'','hola hola'),(20,1,NULL,NULL,'','hola hola'),(21,1,NULL,NULL,'','hola hola'),(22,1,NULL,NULL,'','hola hola'),(23,1,NULL,NULL,'','hola hola'),(24,1,NULL,NULL,'','hola hola'),(25,1,NULL,NULL,'','hola hola'),(26,1,NULL,NULL,'','hola hola'),(27,1,NULL,NULL,'','hola hola'),(28,1,NULL,NULL,'','hola hola'),(29,1,NULL,NULL,'','hola hola'),(30,1,NULL,NULL,'','hola hola'),(31,1,NULL,NULL,'','hola hola'),(32,1,NULL,NULL,'','hola hola'),(33,1,NULL,NULL,'','hola hola'),(34,1,NULL,NULL,'','hola hola'),(35,1,NULL,NULL,'','hola hola'),(36,1,NULL,NULL,'','hola hola'),(37,1,NULL,NULL,'','hola hola'),(38,1,NULL,NULL,'','hola hola'),(39,1,NULL,NULL,'','hola hola'),(40,1,NULL,NULL,'','hola hola'),(41,1,NULL,NULL,'','hola hola'),(42,1,NULL,NULL,'','Hola nihqbipfiwpge fnewjipga'),(43,1,NULL,NULL,'','Hola nihqbipfiwpge fnewjipga'),(44,1,NULL,NULL,'','Has suspendido pendejo!!!'),(45,1,NULL,NULL,'','Has suspendido pendejo!!!'),(46,1,NULL,NULL,'','Has suspendido pendejo!!!'),(47,1,NULL,NULL,'','Has suspendido pendejo!!!'),(48,1,NULL,NULL,'','Has suspendido pendejo!!!'),(49,1,NULL,NULL,'','Has suspendido pendejo!!!'),(50,1,NULL,NULL,'','Has suspendido pendejo!!!'),(51,1,NULL,NULL,'','Has suspendido pendejo!!!'),(52,1,NULL,NULL,'','Has suspendido pendejo!!!'),(53,1,NULL,NULL,'','Has suspendido pendejo!!!'),(54,1,NULL,NULL,'','Has suspendido pendejo!!!'),(55,1,NULL,NULL,'','Has suspendido pendejo!!!'),(56,1,NULL,NULL,'','Has suspendido pendejo!!!'),(57,1,NULL,NULL,'','Has suspendido pendejo!!!'),(58,1,NULL,NULL,'','Has suspendido pendejo!!!'),(59,1,NULL,NULL,'1','Has suspendido pendejo!!!'),(60,1,NULL,NULL,'3','Has suspendido pendejo!!!'),(61,1,NULL,NULL,'3','Has suspendido pendejo!!!'),(62,1,NULL,NULL,'','Has suspendido pendejo!!!'),(63,1,NULL,NULL,'1_2_3_4_5_6_25_26_27_28_29_30_49_50_51_52_53_54','Has suspendido pendejo!!!'),(64,1,NULL,NULL,'1_2_3_6_25_26_27_49_50_51','Has suspendido pendejo!!!'),(65,1,NULL,NULL,'3_6','Has suspendido pendejo!!!'),(66,1,NULL,NULL,'3_6','Vas a la recu!!!!'),(67,1,NULL,NULL,'3_6','Hola que pasa cara pasa'),(68,1,NULL,NULL,'3_6','Hola que pasa cara pasa'),(69,1,NULL,NULL,'3_6','Hola que pasa cara pasa'),(70,1,NULL,NULL,'3_6','Hola que pasa cara pasa'),(71,1,NULL,NULL,'3_6','Hola que pasa cara pasa'),(72,1,NULL,NULL,'3_6','Hola que pasa cara pasa'),(73,1,NULL,NULL,'3_6','Hola que pasa cara pasa'),(74,1,NULL,NULL,'3_6','Hola que pasa cara pasa'),(75,1,NULL,NULL,'1_3_4_6','Hola amigos de you tube'),(76,1,NULL,NULL,'3_6','Hola que pasa cara pasa'),(77,1,NULL,NULL,'1_2_3_4_5_6','hola que pasa cara pasa'),(78,1,NULL,NULL,'2_3_5_6','hola que pasa cara pasa'),(79,1,NULL,NULL,'2_3_5_6','hola que pasa cara pasa'),(80,1,NULL,NULL,'2_3','hola que pasa cara pasa'),(81,5,NULL,NULL,'','gthd'),(82,5,NULL,NULL,'','gthd'),(83,5,NULL,NULL,'','gthd'),(84,5,NULL,NULL,'','gthd'),(85,5,NULL,NULL,'','gthd'),(86,5,NULL,NULL,'6','gthd'),(87,5,NULL,NULL,'3','gthd'),(88,5,NULL,NULL,'3','gthd'),(89,5,NULL,NULL,'3','gthd'),(90,5,NULL,NULL,'3','gthd'),(91,5,NULL,NULL,'1_2','gthd'),(92,5,NULL,NULL,'1_2','gthd'),(93,5,NULL,NULL,'1_2','gthd'),(94,5,NULL,NULL,'49','gthd'),(95,5,NULL,NULL,'49','gthd'),(96,5,NULL,NULL,'49','gthd'),(97,5,NULL,NULL,'1_2','gthd'),(98,5,NULL,NULL,'1_2','gthd'),(99,5,NULL,NULL,'1_2','gthd'),(100,5,NULL,NULL,'1_2_3','hola que tal?'),(101,5,NULL,NULL,'1_2_3','hola que tal?'),(102,5,NULL,NULL,'1_2_3','hola que tal?'),(103,5,NULL,NULL,'1_2_3','hola que tal?'),(104,5,NULL,NULL,'49','gres'),(105,5,NULL,NULL,'1_2','htrjh'),(106,5,NULL,NULL,'1_2','htrjh'),(107,6,NULL,NULL,'1_2_3','Hola mundo');
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores`
--

DROP TABLE IF EXISTS `profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesores` (
  `id_profesores` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contrasena` varchar(50) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `nacimiento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `cp` int(5) NOT NULL,
  `cuentaBancaria` varchar(24) NOT NULL,
  `telefono` int(9) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id_profesores`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (5,'9dd1ec732f59c0b12f9fd05fe3d8b224','Cesar','Elvira Martin','2066-09-01','M','51703391N','gjerp','gep','vbpei',0,'',630204348,'lucaselvira96@gmail.com'),(6,'802f050b17608ef32e851a33ff2eb5c0','raq','gnfve','1996-12-19','F','51703391N','fwerg','ge','ge',0,'',673867673,'raq.marribas@gmail.com'),(7,'a9e3343b9c1efa5df97019e91fe48fdd','jhryj','ghet','1996-12-19','M','51703391N','few','npiofw','bpe',0,'es00-0000-0000-0000-0000',630204348,'rmarribas@fomento.es');
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recursos_subida`
--

DROP TABLE IF EXISTS `recursos_subida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recursos_subida` (
  `id_recursos_subida` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `g_destinatario` varchar(100) DEFAULT NULL,
  `c_destinatario` float DEFAULT NULL,
  `id_remitente` int(10) unsigned DEFAULT NULL,
  `uri` varchar(100) NOT NULL,
  `descripcion` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id_recursos_subida`),
  KEY `id_remitente` (`id_remitente`),
  CONSTRAINT `recursos_subida_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `profesores` (`id_profesores`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recursos_subida`
--

LOCK TABLES `recursos_subida` WRITE;
/*!40000 ALTER TABLE `recursos_subida` DISABLE KEYS */;
INSERT INTO `recursos_subida` VALUES (1,'creatividad',NULL,1.1,6,'../files/profesores/raq_liberation-mono.zip',NULL),(2,'creatividad',NULL,1.2,6,'../files/profesores/raq_liberation-mono.zip',NULL);
/*!40000 ALTER TABLE `recursos_subida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reprografia`
--

DROP TABLE IF EXISTS `reprografia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reprografia` (
  `id_archivo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) DEFAULT NULL,
  `file` varchar(40) DEFAULT NULL,
  `fecha_subida` date DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `comentario` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id_archivo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reprografia`
--

LOCK TABLES `reprografia` WRITE;
/*!40000 ALTER TABLE `reprografia` DISABLE KEYS */;
/*!40000 ALTER TABLE `reprografia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id_staff` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contrasena` varchar(50) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `nacimiento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `cp` int(5) NOT NULL,
  `cuentaBancaria` varchar(24) NOT NULL,
  `telefono` int(9) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id_staff`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trabajos_subida`
--

DROP TABLE IF EXISTS `trabajos_subida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trabajos_subida` (
  `id_trabajos_subida` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `id_destinatario` int(10) unsigned DEFAULT NULL,
  `id_remitente` int(10) unsigned DEFAULT NULL,
  `uri` varchar(100) NOT NULL,
  `descripcion` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id_trabajos_subida`),
  KEY `id_remitente` (`id_remitente`),
  KEY `id_destinatario` (`id_destinatario`),
  CONSTRAINT `trabajos_subida_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `alumnos` (`id_alumnos`),
  CONSTRAINT `trabajos_subida_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `profesores` (`id_profesores`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trabajos_subida`
--

LOCK TABLES `trabajos_subida` WRITE;
/*!40000 ALTER TABLE `trabajos_subida` DISABLE KEYS */;
INSERT INTO `trabajos_subida` VALUES (1,'creatividad',3,37,'../files/alumnos',NULL),(2,'patronaje',5,38,'../files/alumnos',NULL),(3,'patronaje',5,38,'../files/alumnos',NULL),(5,'creatividad',6,43,'../files/alumnos/6-57-40_Cesar _Elvira Barrueco_43.zip',NULL),(6,'creatividad',6,43,'../files/alumnos/9-01-32_Cesar _Elvira Barrueco_43.zip',NULL),(7,'creatividad',6,42,'../files/alumnos/10-33-21_Raq_Mar_42.zip',NULL);
/*!40000 ALTER TABLE `trabajos_subida` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-30  1:13:35
