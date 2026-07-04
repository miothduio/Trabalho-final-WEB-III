-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: final
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Salgados'),(2,'Bebidas'),(3,'Sobremesas');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_itens`
--

DROP TABLE IF EXISTS `pedido_itens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `pedido_itens_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pedido_itens_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_itens`
--

LOCK TABLES `pedido_itens` WRITE;
/*!40000 ALTER TABLE `pedido_itens` DISABLE KEYS */;
INSERT INTO `pedido_itens` VALUES (10,5,4,1,6.50,NULL),(11,6,3,1,12.00,NULL),(12,6,4,1,6.50,NULL),(13,7,7,1,6.00,NULL),(14,8,4,1,6.50,NULL);
/*!40000 ALTER TABLE `pedido_itens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_pedido` varchar(20) DEFAULT NULL,
  `numero_totem` int(11) NOT NULL,
  `cliente_nome` varchar(120) DEFAULT NULL,
  `cliente_telefone` varchar(30) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('PENDENTE','EM_PREPARO','PRONTO','FINALIZADO','CANCELADO') DEFAULT 'PENDENTE',
  `data_pedido` datetime DEFAULT current_timestamp(),
  `hora_inicio` datetime DEFAULT NULL,
  `hora_fim` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (5,'00005',1,'Diullian','54991620400',6.50,NULL,'FINALIZADO','2026-07-01 19:19:20','2026-07-01 19:42:39','2026-07-01 19:42:51'),(6,'00006',1,'Flávio','55999999999999',18.50,NULL,'FINALIZADO','2026-07-01 20:00:52','2026-07-01 20:03:08','2026-07-01 20:07:40'),(7,'00007',1,'Eduardo Baptista ','',6.00,NULL,'PENDENTE','2026-07-01 20:06:16',NULL,NULL),(8,'00008',2,'Eduardo Baptista ','55999999999',6.50,NULL,'PENDENTE','2026-07-01 21:26:00',NULL,NULL);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `destaque` tinyint(1) DEFAULT 0,
  `ativo` tinyint(1) DEFAULT 1,
  `estoque` int(11) NOT NULL DEFAULT 0,
  `tempo_preparo` int(11) DEFAULT 10,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,1,'X Burger','Hambúrguer artesanal',25.00,'uploads/produtos/xburger.jpg',1,1,1000,15),(2,1,'X Salada','Hambúrguer com salada',28.00,'uploads/produtos/xsalada.jpg',0,1,1000,15),(3,1,'Pastel','Pastel de carne',12.00,'uploads/produtos/pastel.jpg',1,1,999,8),(4,2,'Coca Cola','350ml',6.50,'uploads/produtos/1782836783_acdbbf56ccb954f2afe7.jpg',0,1,997,2),(5,2,'Suco Natural','Laranja',8.00,'uploads/produtos/suco.jpg',0,1,1000,3),(6,3,'Brownie','Chocolate',14.00,'uploads/produtos/1782958580_c7daeed91a848eb68fb7.jpg',0,1,1000,5),(7,2,'capuccino','',6.00,'',0,1,10,0);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `totens`
--

DROP TABLE IF EXISTS `totens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `totens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave` varchar(20) NOT NULL,
  `token` varchar(64) DEFAULT NULL,
  `numero_totem` int(11) NOT NULL,
  `hostname` varchar(100) DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `ativado` tinyint(1) NOT NULL DEFAULT 0,
  `online` tinyint(1) DEFAULT 0,
  `ultima_conexao` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`chave`),
  UNIQUE KEY `numero_totem` (`numero_totem`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `totens`
--

LOCK TABLES `totens` WRITE;
/*!40000 ALTER TABLE `totens` DISABLE KEYS */;
INSERT INTO `totens` VALUES (8,'129BBB','a2474c25b333508c3f0371248d5d6eef299ed9f289cab128ab86c03f278f58fb',1,'Totem 1','principal','::1',1,1,1,'2026-07-01 23:17:54','2026-07-02 02:07:59'),(9,'09AE7A','9ff1a0681867f0b85dfb69136aab653bcf6db85a10441e55cb008950e31d9a77',2,'Totem 2','principal','::1',1,1,1,'2026-07-02 20:57:31','2026-07-02 02:08:37');
/*!40000 ALTER TABLE `totens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('SUPER_ADMIN','USUARIO') DEFAULT 'USUARIO',
  `ativo` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Administrador','admin@admin.com','$2y$10$PKIBVEEPLrdZ/v7Y06sQIe.FvuVmnUKDsVZowFw9EmY8SrpyMD4yS','SUPER_ADMIN',1,'2026-06-29 22:42:03','2026-06-30 12:23:23'),(3,'Diullian','miothduio@gmail.com','$2y$10$LybfDvICZShJM.DtgNjLPOW8RBSxttHfSA0Eo/.X/tc2giVdQqhrK','USUARIO',1,'2026-06-30 19:14:15','2026-06-30 19:14:15');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'final'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-03 22:06:39
