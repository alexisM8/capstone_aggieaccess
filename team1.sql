-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: team1
-- ------------------------------------------------------
-- Server version	5.1.73-log

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
-- Table structure for table `building`
--

DROP TABLE IF EXISTS `building`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `building` (
  `buildID` int(11) NOT NULL AUTO_INCREMENT,
  `buildName` varchar(100) NOT NULL,
  `buildAbbrv` varchar(10) NOT NULL,
  PRIMARY KEY (`buildID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `building`
--

LOCK TABLES `building` WRITE;
/*!40000 ALTER TABLE `building` DISABLE KEYS */;
INSERT INTO `building` VALUES (1,'Howell Hall','HH'),(2,'Burch Hall','BH');
/*!40000 ALTER TABLE `building` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `classID` int(11) NOT NULL AUTO_INCREMENT,
  `profID` int(11) NOT NULL,
  `timeID` int(11) NOT NULL,
  `dateID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `dayID` int(11) NOT NULL,
  PRIMARY KEY (`classID`),
  KEY `profID` (`profID`),
  KEY `timeID` (`timeID`),
  KEY `dayID` (`dayID`),
  KEY `dateID` (`dateID`),
  KEY `courseID` (`courseID`),
  KEY `locationID` (`locationID`),
  CONSTRAINT `class_ibfk_6` FOREIGN KEY (`locationID`) REFERENCES `location` (`locationID`),
  CONSTRAINT `class_ibfk_1` FOREIGN KEY (`profID`) REFERENCES `faculty` (`fid`),
  CONSTRAINT `class_ibfk_2` FOREIGN KEY (`timeID`) REFERENCES `time` (`timeID`),
  CONSTRAINT `class_ibfk_3` FOREIGN KEY (`dayID`) REFERENCES `day` (`daysID`),
  CONSTRAINT `class_ibfk_4` FOREIGN KEY (`dateID`) REFERENCES `date` (`dateID`),
  CONSTRAINT `class_ibfk_5` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES (1,1,2,1,1,1,3),(2,2,3,1,5,18,1),(3,6,6,1,4,2,1),(4,1,6,1,5,11,3),(5,7,8,1,3,7,3);
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `courseID` int(11) NOT NULL AUTO_INCREMENT,
  `courseTitle` varchar(30) NOT NULL,
  `CRN` varchar(10) NOT NULL,
  `departmentID` int(11) DEFAULT NULL,
  PRIMARY KEY (`courseID`),
  UNIQUE KEY `CRN` (`CRN`),
  KEY `departmentID` (`departmentID`),
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'Capstone Project','CS 4233',1),(2,'Computer Science I','CS 1314',1),(3,'Computer Science II','CS 1514',1),(4,'Discrete Math','CS 1523',1),(5,'Operating Systems','CS 3513',1),(6,'Algorithm Analysis','CS 3713',1),(7,'Software Engineering','CS 4202',1),(8,'Network Programming','CS 3013',1),(9,'Programming I','IT 1414',2),(10,'Programming II','IT 2414',2),(11,'Data Structures','CS 2413',1),(12,'Computer Organization/Arch','CS 2513',1),(13,'Database Design & Management','CS 3183',1),(14,'Web Systems Technologies','CS 2333',1),(15,'E-Commerce and Web Security','IAS 3233',5),(16,'Intro to Computer Systems','IT 1013',2),(17,'Intro to Networking','IT 1063',2),(18,'Internetworking Technologies','IT 2064',2),(19,'IT Capstone','IT 4443',2),(20,'Pre-Algebra','MATH 0013',3),(21,'Beginning Algebra','MATH 0103',3),(22,'Intermediate Algebra','MATH 0213',3),(23,'Survey of Mathematics','MATH 1413',3),(24,'Functions and Modeling','MATH 1463',3),(25,'College Algebra','MATH 1513',3),(26,'Plane Trigonometry','MATH 1613',3),(27,'Calc & Analytic Geom I','MATH 2515',3),(28,'Calc & Analytic Geom II','MATH 2535',3),(29,'Differential Equations','MATH 3253',3),(30,'Discrete Math Structures','MATH 3413',3),(31,'Intro to Statistics','STAT 1513',4),(32,'Intro to Prabab & Statistics I','STAT 2013',4);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `date`
--

DROP TABLE IF EXISTS `date`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `date` (
  `dateID` int(11) NOT NULL AUTO_INCREMENT,
  `startDate` varchar(30) NOT NULL,
  `endDate` varchar(30) NOT NULL,
  PRIMARY KEY (`dateID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `date`
--

LOCK TABLES `date` WRITE;
/*!40000 ALTER TABLE `date` DISABLE KEYS */;
INSERT INTO `date` VALUES (1,'01/09/2023','05/05/2023'),(2,'01/09/2023','03/06/2023'),(3,'03/07/2023','05/05/2023'),(4,'05/24/2023','07/24/2023'),(5,'08/14/2023','12/08/2023');
/*!40000 ALTER TABLE `date` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `day`
--

DROP TABLE IF EXISTS `day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `day` (
  `daysID` int(11) NOT NULL AUTO_INCREMENT,
  `days` varchar(20) NOT NULL,
  PRIMARY KEY (`daysID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `day`
--

LOCK TABLES `day` WRITE;
/*!40000 ALTER TABLE `day` DISABLE KEYS */;
INSERT INTO `day` VALUES (1,'MW'),(2,'MWF'),(3,'TR'),(4,'MTWR'),(5,'S'),(6,'F');
/*!40000 ALTER TABLE `day` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `departmentID` int(11) NOT NULL AUTO_INCREMENT,
  `departmentName` varchar(30) NOT NULL,
  `departmentAbbrv` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`departmentID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'Computer Science','CS'),(2,'Information Technology','IT'),(3,'Mathematical Sciences','MATH'),(4,'Statistics','STAT'),(5,'International Accounting Stand','IAS');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollment`
--

DROP TABLE IF EXISTS `enrollment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollment` (
  `enrollmentID` int(11) NOT NULL AUTO_INCREMENT,
  `studentID` int(11) NOT NULL,
  `facultyID` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  PRIMARY KEY (`enrollmentID`),
  KEY `studentID` (`studentID`),
  KEY `facultyID` (`facultyID`),
  KEY `classID` (`classID`),
  CONSTRAINT `enrollment_ibfk_3` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`),
  CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student` (`sid`),
  CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`facultyID`) REFERENCES `faculty` (`fid`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollment`
--

LOCK TABLES `enrollment` WRITE;
/*!40000 ALTER TABLE `enrollment` DISABLE KEYS */;
INSERT INTO `enrollment` VALUES (1,2,1,1),(2,3,6,3),(3,1,1,4),(4,2,1,4),(5,3,1,4),(6,5,1,4),(7,6,1,4),(8,7,1,4),(9,8,1,4),(10,9,1,4),(11,10,1,4),(12,11,1,4),(13,1,2,2),(14,3,2,2),(15,5,2,2),(16,6,2,2),(17,7,2,2),(18,8,2,2),(19,9,2,2),(20,10,2,2),(21,11,2,2),(22,1,1,1),(23,3,1,1),(24,5,1,1),(25,6,1,1),(26,7,1,1),(27,8,1,1),(28,9,1,1),(29,10,1,1),(30,11,1,1),(31,12,1,1),(32,13,1,1),(33,14,1,1),(34,15,1,1),(35,16,1,1),(36,17,1,1),(37,1,7,5),(38,2,7,5),(39,3,7,5),(40,5,7,5),(41,6,7,5),(42,7,7,5),(43,8,7,5),(44,9,7,5),(45,10,7,5),(46,11,7,5),(47,12,7,5),(48,13,7,5),(49,14,7,5),(50,15,7,5),(51,16,7,5),(52,17,7,5);
/*!40000 ALTER TABLE `enrollment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculty` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `role` int(11) NOT NULL,
  `office` int(11) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`fid`),
  UNIQUE KEY `email` (`email`),
  KEY `role` (`role`),
  KEY `office` (`office`),
  CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`role`) REFERENCES `faculty_roles` (`frid`),
  CONSTRAINT `faculty_ibfk_2` FOREIGN KEY (`office`) REFERENCES `location` (`locationID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
INSERT INTO `faculty` VALUES (1,'Chao','cz@cameron.edu','Zhao',1,6,NULL),(2,'Muhammad','mj@cameron.edu','Javed',3,7,NULL),(3,'Jawad','jd@cameron.edu','Drissi',1,8,NULL),(4,'Abbus','aj@cameron.edu','Johari',1,8,NULL),(5,'Teressa','th@cameron.edu','Hickerson',1,6,NULL),(6,'Feridoon','fm@cameron.edu','Moinian',1,6,NULL),(7,'Mike','me@cameron.edu','Estep',1,7,NULL),(9,'Harry','hk@cameron.edu','Kimberling',1,8,NULL),(10,'Ioannis','ia@cameron.edu','Argyros',1,8,NULL),(11,'Gregory','gh@cameron.edu','Herring',1,8,NULL),(12,'Hong','hl@cameron.edu','Li',1,6,NULL),(13,'Christopher','cs@cameron.edu','Sauer',1,7,NULL);
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculty_passwords`
--

DROP TABLE IF EXISTS `faculty_passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculty_passwords` (
  `passID` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(20) NOT NULL,
  `facultyID` int(11) NOT NULL,
  PRIMARY KEY (`passID`),
  KEY `facultyID` (`facultyID`),
  CONSTRAINT `faculty_passwords_ibfk_1` FOREIGN KEY (`facultyID`) REFERENCES `faculty` (`fid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty_passwords`
--

LOCK TABLES `faculty_passwords` WRITE;
/*!40000 ALTER TABLE `faculty_passwords` DISABLE KEYS */;
INSERT INTO `faculty_passwords` VALUES (1,'cIsKing',1),(2,'networkIsKing',2);
/*!40000 ALTER TABLE `faculty_passwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculty_roles`
--

DROP TABLE IF EXISTS `faculty_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculty_roles` (
  `frid` int(11) NOT NULL AUTO_INCREMENT,
  `roles` varchar(20) NOT NULL,
  PRIMARY KEY (`frid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty_roles`
--

LOCK TABLES `faculty_roles` WRITE;
/*!40000 ALTER TABLE `faculty_roles` DISABLE KEYS */;
INSERT INTO `faculty_roles` VALUES (1,'Professor'),(2,'Secretary'),(3,'Chair');
/*!40000 ALTER TABLE `faculty_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `locationID` int(11) NOT NULL AUTO_INCREMENT,
  `buildID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  PRIMARY KEY (`locationID`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,6),(7,1,7),(8,1,8),(9,1,9),(10,1,10),(11,1,11),(12,1,12),(13,1,13),(14,1,14),(15,2,14),(16,2,13),(17,2,12),(18,2,11),(19,2,10),(20,2,9),(21,2,8),(22,2,7),(23,2,6),(24,2,5),(25,2,4),(26,2,3),(27,2,2),(28,2,1);
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `major`
--

DROP TABLE IF EXISTS `major`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `major` (
  `majorID` int(11) NOT NULL AUTO_INCREMENT,
  `majorAbbrv` varchar(5) NOT NULL,
  `major` varchar(50) NOT NULL,
  PRIMARY KEY (`majorID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `major`
--

LOCK TABLES `major` WRITE;
/*!40000 ALTER TABLE `major` DISABLE KEYS */;
INSERT INTO `major` VALUES (1,'CS','Computer Science'),(2,'IT','Information Technology');
/*!40000 ALTER TABLE `major` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `roomID` int(11) NOT NULL AUTO_INCREMENT,
  `roomNum` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`roomID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'101'),(2,'102'),(3,'103'),(4,'104'),(5,'105'),(6,'106A'),(7,'106B'),(8,'106C'),(9,'106D'),(10,'201'),(11,'202'),(12,'203'),(13,'204'),(14,'205');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `major` varchar(4) NOT NULL,
  `classification` varchar(10) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `advisorID` int(11) DEFAULT NULL,
  `majorID` int(11) NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `email` (`email`),
  KEY `advisorID` (`advisorID`),
  KEY `majorID` (`majorID`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`advisorID`) REFERENCES `faculty` (`fid`),
  CONSTRAINT `student_ibfk_2` FOREIGN KEY (`majorID`) REFERENCES `major` (`majorID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'Alexis','ar@cameron.edu','Rodriguez','CS','senior',NULL,NULL,1),(2,'Rachel','rv@cameron.edu','Vanderlely','CS','senior',NULL,NULL,1),(3,'Gabriel','gr@cameron.edu','Perry-Ruiz','CS','senior',NULL,NULL,1),(4,'Bob','bd@cameron.edu','Dylan','Mu','freshman','215-262-7810',NULL,1),(5,'Cade','cr@cameron.edu','Ruple','CS','Senior','580-583-9772',NULL,1),(6,'Christopher','ca@cameron.edu','Argyros','CS','Senior',NULL,NULL,1),(7,'Preston','pm@cameron.edu','Meek','CS','Senior',NULL,NULL,1),(8,'Aaron','ah@cameron.edu','Hendri','CS','Senior',NULL,NULL,1),(9,'Kettisark','kd@cameron.edu','Dy','CS','Senior',NULL,NULL,1),(10,'Avontae','ab@cameron.edu','Broomfield','CS','Senior',NULL,NULL,1),(11,'Jeffery','jw@cameron.edu','Warden','CS','Senior',NULL,NULL,1),(12,'Dylan','dg@cameron.edu','Griggs','CS','Senior',NULL,NULL,1),(13,'Nathaniel','nb@cameron.edu','Bryant','CS','Senior',NULL,NULL,1),(14,'Aaron','an@cameron.edu','Nettles','CS','Senior',NULL,NULL,1),(15,'Jason','jc@cameron.edu','Caha','CS','Senior',NULL,NULL,1),(16,'Abdul','abr@cameron.edu','Rahman','CS','Senior',NULL,NULL,1),(17,'Kimberly','kj@cameron.edu','Jones','CS','Senior',NULL,NULL,1);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_passwords`
--

DROP TABLE IF EXISTS `student_passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_passwords` (
  `passID` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(20) NOT NULL,
  `studentID` int(11) NOT NULL,
  PRIMARY KEY (`passID`),
  KEY `studentID` (`studentID`),
  CONSTRAINT `student_passwords_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student` (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_passwords`
--

LOCK TABLES `student_passwords` WRITE;
/*!40000 ALTER TABLE `student_passwords` DISABLE KEYS */;
INSERT INTO `student_passwords` VALUES (1,'alexis',1),(2,'clarkiscute',2),(3,'zerotwo',3),(4,'P@ssw0rd!',5),(5,'musicrocks',4);
/*!40000 ALTER TABLE `student_passwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time`
--

DROP TABLE IF EXISTS `time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time` (
  `timeID` int(11) NOT NULL AUTO_INCREMENT,
  `timeRange` varchar(35) NOT NULL,
  PRIMARY KEY (`timeID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time`
--

LOCK TABLES `time` WRITE;
/*!40000 ALTER TABLE `time` DISABLE KEYS */;
INSERT INTO `time` VALUES (1,'7:00-8:00AM'),(2,'8:00-9:00AM'),(3,'9:00-10:00AM'),(4,'10:00-11:00AM'),(5,'11:00AM-12:00PM'),(6,'12:00-1:00PM'),(7,'1:00-2:00PM'),(8,'2:00-3:00PM'),(9,'3:00-4:00PM'),(10,'4:00-5:00PM'),(11,'5:00-6:00PM'),(12,'6:00-7:00PM');
/*!40000 ALTER TABLE `time` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-14 10:21:57
