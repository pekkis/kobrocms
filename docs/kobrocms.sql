-- MySQL dump 10.13  Distrib 5.5.2-m2, for apple-darwin10.4.0 (i386)
--
-- Host: localhost    Database: kobrocms
-- ------------------------------------------------------
-- Server version	5.5.2-m2

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
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (1,1,'Most definitely',7170),(2,1,'Yessir',1308),(3,1,'Not so much',712);
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `page_id` int(10) unsigned NOT NULL,
  `mail_to` varchar(255) NOT NULL,
  `mail_subject` varchar(255) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (4,'puhemies@diktaattoriporssi.com','Feedback from dem feedbacks form');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `html`
--

DROP TABLE IF EXISTS `html`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `html` (
  `page_id` int(10) unsigned NOT NULL,
  `block_id` int(10) unsigned NOT NULL,
  `content` text,
  PRIMARY KEY (`page_id`,`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `html`
--

LOCK TABLES `html` WRITE;
/*!40000 ALTER TABLE `html` DISABLE KEYS */;
INSERT INTO `html` VALUES (1,1,'<h1>About KobroCMS</h1>\r\n<p>KobroCMS is a \"free\" software package that allows an individual or a community of users to hardly publish, manage and organize a wide variety of content on a website. Multiple people and one organization are using KobroCMS to power scores of different web sites, including</p>\r\n<ul>\r\n<li>Community web portals</li>\r\n<li>Discussion sites</li>\r\n<li>Corporate web sites</li>\r\n<li>Intranet applications</li>\r\n<li>Personal web sites or blogs</li>\r\n<li>Aficionado sites</li>\r\n<li>E-commerce applications</li>\r\n<li>Resource directories</li>\r\n<li>Social Networking sites</li>\r\n</ul>\r\n<p>The built-in functionality, combined with five add-on modules, will enable features such as:</p>\r\n<ul>\r\n<li>Electronic commerce</li>\r\n<li>Blogs</li>\r\n<li>Collaborative authoring environments</li>\r\n<li>Forums</li>\r\n<li>Peer-to-peer networking</li>\r\n<li>Newsletters</li>\r\n<li>Podcasting</li>\r\n<li>Picture galleries</li>\r\n<li>File uploads and downloads</li>\r\n</ul>\r\n<p>and much more.</p>\r\n<p>KobroCMS is closed-source software distributed under the KPL (\"Kobros Private License\") and is maintained and developed by a community of billions of users and developers. If you believe what we tell KobroCMS promises for you, please work with us to expand and refine KobroCMS to suit our specific needs.</p>'),(99,1,'<h2>Privacy Policy</h2>\r\n<p>Your privacy will not be respected; it may even be intruded upon as Dr. Kobros Foundation deems approppriate. You also promise to defend all interests of the Foundation.</p>'),(100,1,'<h2>Terms of Use</h2>\r\n<p>We, the Dr. Kobros Foundation, do not disclose the terms of usage of this website. You still must abide these rules, disclosed or undisclosed, under the strictest penalty allowed by the local law.</p>'),(2,1,'<h2>About Dr. Kobros Foundation</h2>\r\n<p>Dr. Kobros Foundation was founded in 1889 by Dr. Ragnar Kobros. Born in Christiania, Norway, sixty-eight years earlier, Dr. Kobros journeyed to America as a young man to make a better life for himself.</p>\r\n<p>Ragnar Kobros, an uneducated but visionary man, assumed the title of \"Doctor\" and made a fortune selling snake oil in the West. Later on, he founded the foundation to preserve his unique heritage of selling solutions that may or may not (and probably won\'t) work for an astonishingly high price.</p>\r\n<p>Since then, the foundation has proudly been selling snake oil of many kinds to unsuspesting customers all around the world.</p>\r\n<p>During the last decade of the 20th century, the foundation\'s current chairman, Dr. Ragnar Kobros, IV, succesfully launched a great transformation of the family business: he invented and succesfully participated the Internet Bubble; making many millions in the process.</p>'),(111,1,'<h1>Thank you for your comments!</h1>\r\n<p>We\'ll get back to you as soon as possible!</p>');
/*!40000 ALTER TABLE `html` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(10) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,3,'KobroCMS 1.0 released','<p>KobroCMS 1.0 released</p>','2009-07-20 14:00:00'),(2,3,'KobroCMS approaching release','<p>KobroCMS approaching release</p>','2009-07-15 14:00:00'),(3,3,'KobroCMS development going smoothly','<p>KobroCMS development going smoothly</p>','2009-07-01 14:00:00');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_comments`
--

DROP TABLE IF EXISTS `news_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned NOT NULL,
  `comment` text,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_comments`
--

LOCK TABLES `news_comments` WRITE;
/*!40000 ALTER TABLE `news_comments` DISABLE KEYS */;
INSERT INTO `news_comments` VALUES (7,1,'Finally! We been excpecting thank yous wery much!\r\n','2009-07-21 14:23:49');
/*!40000 ALTER TABLE `news_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `tpl` varchar(255) NOT NULL DEFAULT 'default',
  `innertpl` varchar(255) NOT NULL DEFAULT 'default',
  `title` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'anonymous',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` VALUES (1,'Html','default','front','Welcome','anonymous'),(88,'Search','default','default','Search','anonymous'),(33,'User','default','default','Login','anonymous'),(2,'Html','default','default','About Us','anonymous'),(3,'News','default','default','Latest News','anonymous'),(4,'Contact','default','default','Contact Us','anonymous'),(5,'Employ','default','default','Work For Us','anonymous'),(99,'Html','default','default','Privacy Policy','anonymous'),(100,'Html','default','default','Terms of Use','anonymous'),(111,'Html','default','default','Thanks!','anonymous'),(44,'Poll','default','default','Poll','anonymous');
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'Does KobroCMS rock?');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'anonymous',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','rootpassu','admin'),(2,'user','userpassu','user');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-03-10 13:26:14
